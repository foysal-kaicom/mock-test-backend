<?php

namespace App\Jobs;

use App\Services\PdfProcessService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PdfSplitProcessJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    public $pathName;
    public $fileType;

    public function __construct(string $pathName, string $fileType)
    {
        $this->pathName = $pathName;
        $this->fileType = $fileType;
    }

    public function handle(PdfProcessService $pdfProcessService): void
    {
        // Create service here to avoid serialization issues
        Log::debug("Call process pdf from Handle");
        $pdfProcessService->processPdf($this->pathName, $this->fileType);
    }
}
