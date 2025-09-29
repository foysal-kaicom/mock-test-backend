<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\Faq;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class HomeController extends Controller
{
    public $fileStorageService;
    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }
    public function settingsData()
    {
        $settings = BusinessSetting::latest()->first();

        return $this->responseWithSuccess($settings, 'Business Settings Data');
    }

    public function faq()
    {
        $faqs = Faq::select('id','question','answer')->where('status', 1)->orderBy('position')->get();
        return $this->responseWithSuccess($faqs, 'All FAQ');
    }


    public function test(Request $request)
    {

        try {
            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');

                $path = $file->storeAs('/pdf', 'test.pdf', ['disk' => 'public']); //store into local
                $localFilePath = storage_path('/app/public/' . $path); //get path from local

                $pdfUpload = $this->fileStorageService->uploadPdfFileToCloud($localFilePath, 'pdf', 'pdf');
                $data['file'] = $pdfUpload['public_path'];
            }


            return $this->responseWithSuccess([], "Candidate registered successfully", 201);
        } catch (Throwable $e) {
            return $this->responseWithError($e->getMessage(), 'Something went wrong.');
        }
    }
}
