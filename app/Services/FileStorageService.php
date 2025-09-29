<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


class FileStorageService
{
    public $imageUploadPath = 'image';
    public $pdfUploadPath = 'pdf';

    protected $disk;

    public function __construct()
    {
        $this->disk = config('filesystems.cloud', 'r2');
    }


    public function updateFileFromCloud($fileToDelete, $newFile)
    {
        try {

            $deleteResult = $this->deleteFileFromCloud($fileToDelete);

            $type = collect(explode('/', parse_url($fileToDelete, PHP_URL_PATH)))
                ->reverse()
                ->skip(1)
                ->first();

            if ($deleteResult) {
                $storePath = $this->uploadImageToCloud($newFile, $type);
                if ($storePath) {
                    return  $storePath;
                }
            } else {
                Log::debug("File upload failed.");
                return [
                'storage_path' => '',
                'public_path'  => "",
                'mime'         => "",
            ];
            }
        } catch (\Exception $e) {
            return 'Update failed: ' . $e->getMessage();
        }
    }

    public function deleteFileFromCloud($filePath)
    {
        try {
            $fullUrl = $filePath;
            $path = parse_url($fullUrl, PHP_URL_PATH);
            $path = ltrim($path, '/');

            if (Storage::disk($this->disk)->exists($path)) {
                $delete = Storage::disk($this->disk)->delete($path);
                if ($delete) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } catch (\Exception $e) {
            Log::log('error', 'File delete failed: ' . $e->getMessage());
            return false;
        }
    }
    /**
     * Upload an image to AWS S3
     *
     * @param UploadedFile $file
     * @return string|bool
     */
    private function uploadFile($file, $generated_path)
    {
        try {

            $mime = $file->getClientMimeType();

            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();

            $storagePath = $file->storeAs($generated_path, $filename, 'r2');

            Storage::disk($this->disk)->setVisibility($storagePath, 'public');

            // $publicPath = Storage::disk($this->disk)->url($storagePath);

            return [
                'storage_path' => $storagePath,
                'public_path'  => "https://media.kaicombd.com/" . $storagePath,
                'mime'         => $mime,
            ];
        } catch (\Throwable $e) {
            Log::critical($e->getMessage());
            return response()->json(['error' => 'File upload failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function uploadPdfFileToCloud($localPath, $type, $fileType)
    {
       
        try {
            if (!file_exists($localPath)) {
                return response()->json(['error' => 'File not found.']);
            }

            if($fileType == 'pdf'){
                $file_name = uniqid('pdf-').'.pdf';
            }
            elseif($fileType == 'audio'){
                $file_name = uniqid('audio-').'.mp3';
            }


        if (empty($file_name)) {

            throw new \InvalidArgumentException('file name was empty');
        }

        $generated_path = $this->generatePath($type, $file_name).'/'.$file_name;


        if (empty($generated_path)) {

            throw new \InvalidArgumentException('generated pass was empty');
        }

       
        // Read the file content
        $fileContents = file_get_contents($localPath);

        // Upload to R2
        $path=Storage::disk('r2')->put($generated_path, $fileContents);

        // Get public URL
        $url = Storage::disk('r2')->url($generated_path);

            return [
                'storage_path' => $generated_path,
                'public_path'  => $url
            ];
        } catch (\Throwable $e) {
            Log::critical($e->getMessage());
            return response()->json(['error' => 'File upload failed', 'message' => $e->getMessage()], 500);
        }
    }



    // public function uploadImageToCloud($file, $type)
    // {

    //     $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

    //     $generated_path = $this->generatePath($type, $file_name);

    //     Log::debug('Generated path for file upload: ' . $generated_path);
    //     return $this->uploadFile($file, $generated_path);
    // }

    public function uploadImageToCloud($file, $type)
    {

        $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        if (empty($file_name)) {

            throw new \InvalidArgumentException('file name was empty');
        }

        $generated_path = $this->generatePath($type, $file_name);


        if (empty($generated_path)) {

            throw new \InvalidArgumentException('generated pass was empty');
        }

        return $this->uploadFile($file, $generated_path);
    }


    public function generatePath(string $type, $file_name): string
    {

        return "/uploads/$type";
    }
    // public function generatePath(string $type, $file_name): string
    // {
    //     switch ($type) {

    //         case 'slider':
    //             return sprintf(
    //                 '/uploads/slider/%s.webp',
    //                 md5($file_name) . '-' . $file_name
    //             );

    //         case 'candidate':
    //             return sprintf(
    //                 '/uploads/candidate/%s.webp',
    //                 md5($file_name) . '-' . $file_name
    //             );

    //         case 'misc':
    //             return sprintf(
    //                 '/uploads/misc/%s.webp',
    //                 md5($file_name) . '-' . $file_name
    //             );
    //         case 'logo':
    //             return sprintf(
    //                 '/uploads/logo/%s.webp',
    //                 md5($file_name) . '-' . $file_name
    //             );
    //         case 'result':
    //             return sprintf(
    //                 '/uploads/result/%s.webp',
    //                 md5($file_name) . '-' . $file_name
    //             );
    //         case 'admitcard':
    //             return sprintf(
    //                 '/uploads/result/%s.webp',
    //                 md5($file_name) . '-' . $file_name
    //             );
    //         case 'certificate':
    //             return sprintf(
    //                 '/uploads/certificate/%s.webp',
    //                 md5($file_name) . '-' . $file_name
    //             );
    //         default:
    //             throw new \InvalidArgumentException('Unsupported image type');
    //     }
    // }
}
