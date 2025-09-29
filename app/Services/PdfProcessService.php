<?php

namespace App\Services;

use App\Jobs\CommonEmailNotificationJob;
use App\Models\Booking;
use App\Models\FileProcesses;
use App\Notifications\CandidateNotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use Smalot\PdfParser\Parser;

class PdfProcessService
{
    protected $fileStorageService;

    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    public function processPdf(string $pdfFilePath, string $fileType): void
    {
        $message = [
            'unable_to_process' => [],
            'success_ids'       => [],
            'success_emails'       => []
        ];

        try {
            // 1 Create the parent process record as 'pending'
            $fileProcess = FileProcesses::create([
                'user_id'      => auth()->id(),
                'process_name' => 'Admit/Certificate Upload',
                'file_name'    => $pdfFilePath,
                'status'       => 'pending',
            ]);

            // 2️ Split the PDF
            $splitFiles = $this->splitPdf($pdfFilePath);
        } catch (\Throwable $e) {
            Log::error("PDF split failed", [
                'file'  => $pdfFilePath,
                'error' => $e->getMessage()
            ]);

            $fileProcess->update([
                'status'        => 'failed',
                'error_message' => "PDF split failed: " . $e->getMessage(),
            ]);
            return;
        }

        $anySuccess = false; // track if any split was successfully processed
        $message = [
            'success_emails' => [],
            'success_ids'    => [],
            'unable_to_process' => [],
        ];

        foreach ($splitFiles as $splitPdfPath) {
            try {
                $extractedData = $this->extractContentFromPdf($splitPdfPath);

                $name        = $extractedData['full_name'] ?? null;
                $dobRaw      = $extractedData['dob'] ?? null;
                $dateOfBirth = $dobRaw && strtotime($dobRaw) ? date('Y-m-d', strtotime($dobRaw)) : null;
                $examDate    = !empty($extractedData['exam_date']) ? $extractedData['exam_date'] : null;

                if (!$name || !$dateOfBirth || !$examDate) {
                    $message['unable_to_process'][] = $splitPdfPath ?? 'Unknown';
                    continue;
                }

                $normalizedDate = \Carbon\Carbon::createFromFormat('Y-F-d', $examDate)->toDateString();

                $booking = $this->findMatchingBooking($name, $dateOfBirth, $normalizedDate);

                if (!$booking) {
                    $message['unable_to_process'][] = $name;
                    continue;
                }

                $this->attachPdfToBooking($booking, $splitPdfPath, $fileType);
                $booking->save();

                // Notify candidate
                if ($booking->candidate) {
                    $booking->candidate->notify(new CandidateNotification([
                        'title'   => "Congratulations !",
                        'message' => "Your $fileType is ready for the exam: " . $booking->exam->title,
                        'url'     => '',
                    ]));

                    $message['success_emails'][] = $booking->candidate->email;
                }

                $message['success_ids'][] = $booking->id;
                $anySuccess = true; // mark at least one success
            } catch (\Throwable $e) {
                Log::error("Failed processing split PDF", [
                    'file'  => $splitPdfPath,
                    'error' => $e->getMessage()
                ]);
            } finally {
                if (is_file($splitPdfPath)) {
                    unlink($splitPdfPath);
                }
            }
        }

        // Update parent file process status
        $fileProcess->update([
            'status'        => $anySuccess ? 'success' : 'failed',
            'error_message' => $anySuccess ? null : 'No valid bookings found or PDF corrupted/edited.'
        ]);

        // Dispatch notification emails if needed
        if (!empty($message['success_emails'])) {
            dispatch(new CommonEmailNotificationJob($message['success_emails'], 'admit_card_ready'));
        }

        // Remove original uploaded PDF
        if (file_exists($pdfFilePath)) {
            unlink($pdfFilePath);
        }

        // Final log
        Log::info('PDF processing completed', [
            'file'    => $pdfFilePath,
            'summary' => $message
        ]);
    }

    // public function splitPdf(string $pdfFilePath): array
    // {
    //     $outputDirectory = storage_path('app/tmp/split/');
    //     if (!file_exists($outputDirectory)) {
    //         mkdir($outputDirectory, 0777, true);
    //     }

    //     $pdf = new Fpdi();
    //     $pageCount = $pdf->setSourceFile($pdfFilePath);

    //     if ($pageCount === 0) {
    //         throw new \Exception('Unable to read PDF file. Make sure the file is valid.');
    //     }

    //     $splitFiles = [];

    //     for ($pageNum = 1; $pageNum <= $pageCount; $pageNum++) {
    //         $singlePdf = new Fpdi();
    //         $singlePdf->setSourceFile($pdfFilePath);

    //         $templateId = $singlePdf->importPage($pageNum);
    //         $singlePdf->addPage();
    //         $singlePdf->useTemplate($templateId);

    //         $outputFilePath = $outputDirectory . 'page_' . $pageNum . '.pdf';
    //         $singlePdf->output('F', $outputFilePath);

    //         $splitFiles[] = $outputFilePath;
    //     }

    //     return $splitFiles;
    // }

    public function splitPdf(string $pdfFilePath): array
    {
        $convertedPdf = $this->convertPdf($pdfFilePath); // convert to FPDI-compatible version

        $outputDirectory = storage_path('app/tmp/split/');
        if (!file_exists($outputDirectory)) {
            mkdir($outputDirectory, 0777, true);
        }

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($convertedPdf);

        if ($pageCount === 0) {
            throw new \Exception('Unable to read PDF file. Make sure the file is valid.');
        }

        $splitFiles = [];

        for ($pageNum = 1; $pageNum <= $pageCount; $pageNum++) {
            $singlePdf = new Fpdi();
            $singlePdf->setSourceFile($convertedPdf);

            $templateId = $singlePdf->importPage($pageNum);
            $singlePdf->addPage();
            $singlePdf->useTemplate($templateId);

            $outputFilePath = $outputDirectory . 'page_' . $pageNum . '.pdf';
            $singlePdf->output('F', $outputFilePath);

            $splitFiles[] = $outputFilePath;
        }

        return $splitFiles;
    }

    private function convertPdf(string $path): string
    {
        Log::info("converting pdf");
        $convertedPath = storage_path('app/tmp/converted_' . basename($path));
        $cmd = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH -sOutputFile="
            . escapeshellarg($convertedPath) . " " . escapeshellarg($path);
        exec($cmd, $output, $returnVar);

        if ($returnVar !== 0) {
            Log::error("PDF conversion failed");
            throw new \Exception("PDF conversion failed");
        }

        return $convertedPath;
    }


    public function extractContentFromPdf(string $pdfFilePath): array
    {
        $parser = new Parser();
        $pdf    = $parser->parseFile($pdfFilePath);
        $text   = $pdf->getText();

        $text = preg_replace('/[\x{3000}▶⬯⬮]/u', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        $data = [];

        if (preg_match('/(\d{4})\s+(June|July|August|September|October|November|December)\s+(\d{1,2})/', $text, $m)) {
            $data['exam_date'] = "{$m[1]}-{$m[2]}-{$m[3]}";
        }

        if (preg_match('/受験番号\s*(\d+)/u', $text, $m)) {
            $data['examinee_number'] = $m[1];
        }

        if (preg_match('/(\d{8})/', $text, $m)) {
            $data['dob'] = $m[1];
        }

        if (preg_match('/名\s*前\s+([A-Z.\s]+)/u', $text, $m)) {
            $data['full_name'] = trim($m[1]);
        }


        if (preg_match('/会場名.*?University of Dhaka/i', $text)) {
            $data['venue'] = 'University of Dhaka';
        }

        preg_match('/\s*前\s*([\p{L}\s]+?)\s*生年月日/u', $text, $matchesName);
        $data['name'] = $matchesName[1] ?? 'Not found';

        preg_match('/(\d{8})\s*生年月日/u', $text, $matchesDOB);
        $data['date_of_birth'] = $matchesDOB[1] ?? 'Not found';

        preg_match('/試験名\s*([\p{L}\s]+?)\s*/u', $text, $matchesExamTitle);
        $data['exam_title'] = $matchesExamTitle[1] ?? 'Not found';

        return $data;
    }

    protected function findMatchingBooking(string $name, string $dateOfBirth, string $normalizedDate): ?Booking
    {
        return Booking::whereHas('candidate', function ($query) use ($name, $dateOfBirth) {
            $query->where(function ($q) use ($name) {
                $q->whereRaw("TRIM(CONCAT(first_name, ' ', last_name)) = ?", [$name])
                    ->orWhereRaw("TRIM(CONCAT(first_name, ' ', last_name, ' ', surname)) = ?", [$name]);
            })->where('date_of_birth', $dateOfBirth);
        })
            ->whereHas('exam', function ($query) use ($normalizedDate) {
                $query->whereDate('exam_date', $normalizedDate);
            })->where('status', Booking::CONFIRMED)
            ->first();
    }

    protected function attachPdfToBooking(Booking $booking, string $pdfPath, string $fileType): void
    {
        if ($fileType === 'certificate') {
            if (empty($booking->certificate_file)) {
                $upload = $this->fileStorageService->uploadPdfFileToCloud($pdfPath, 'certificate', 'pdf');
                $booking->certificate_file = $upload['public_path'];
            }
        } else {
            if (empty($booking->admit_card_file)) {
                $upload = $this->fileStorageService->uploadPdfFileToCloud($pdfPath, 'admit_card', 'pdf');
                $booking->admit_card_file = $upload['public_path'];
            }
        }
    }
}
