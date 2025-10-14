<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateBusinessSettingsRequest;

class BusinessSettingController extends Controller
{
    public function showEditPage(){
        $bsData = BusinessSetting::where('id', 1)->first();
        return view('business-settings.edit', compact('bsData'));
    }

    /**
    * Basic Info
    */
    // public function updateGeneralInfo(UpdateBusinessSettingsRequest $request)
    // {
    //     $setting = BusinessSetting::find(1);
    //     $data = $request->validated();

    //     if ($request->hasFile('logo')) {
    //         if ($setting->logo && file_exists(public_path($setting->logo))) {
    //             unlink(public_path($setting->logo));
    //         }

    //         $photoName = time() . '_' . $request->file('logo')->getClientOriginalName();
    //         $request->file('logo')->move(public_path('business-settings/logos'), $photoName);
    //         $data['logo'] = 'business-settings/logos/' . $photoName;
    //     }

    //     $setting->update($data);

    //     Toastr::success('Basic Information updated.');
    //     return redirect()->route('business-settings.edit', 1);
    // }

    public function updateGeneralInfo(UpdateBusinessSettingsRequest $request)
    {
        $setting = BusinessSetting::find(1);
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }

            // Store new logo in 'public/business-settings/logos'
            $path = $request->file('logo')->store('business-settings/logos', 'public');

            // Save only the relative path
            $data['logo'] = $path;
        }

        $setting->update($data);

        Toastr::success('Basic Information updated.');
        return redirect()->route('business-settings.edit', 1);
    }


    /**
    * Legal Info
    */
    public function updateLegalInfo(UpdateBusinessSettingsRequest $request)
    {
        $setting = BusinessSetting::find(1);

        $data = $request->validated();

        if ($request->hasFile('certification_docs')) {
            if ($setting->certification_docs && file_exists(public_path($setting->certification_docs))) {
                unlink(public_path($setting->certification_docs));
            }

            $certification_doc_name = time() . '_' . $request->file('certification_docs')->getClientOriginalName();
            $request->file('certification_docs')->move(public_path('business-settings/certification_docs'), $certification_doc_name);
            $data['certification_docs'] = 'business-settings/certification_docs/' . $certification_doc_name;
        }

        if ($request->hasFile('authorized_docs')) {
            if ($setting->authorized_docs && file_exists(public_path($setting->authorized_docs))) {
                unlink(public_path($setting->authorized_docs));
            }

            $authorized_doc_name = time() . '_' . $request->file('authorized_docs')->getClientOriginalName();
            $request->file('authorized_docs')->move(public_path('business-settings/authorized_docs'), $authorized_doc_name);
            $data['authorized_docs'] = 'business-settings/authorized_docs/' . $authorized_doc_name;
        }

        if ($request->hasFile('legal_docs')) {
            $legal_doc_paths = [];
        
            if ($setting->legal_docs) {
                $existing_docs = json_decode($setting->legal_docs, true);
                foreach ($existing_docs as $existing_doc) {
                    if (file_exists(public_path($existing_doc))) {
                        unlink(public_path($existing_doc));
                    }
                }
            }
            foreach ($request->file('legal_docs') as $file) {
                $legal_doc_name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('business-settings/legal_docs'), $legal_doc_name);
                $legal_doc_paths[] = 'business-settings/legal_docs/' . $legal_doc_name;
            }
            $data['legal_docs'] = json_encode($legal_doc_paths);
        }
        
        $setting->update($data);

        Toastr::success('Legal Information updated.');
        return redirect()->route('business-settings.edit', 1);
    }

    /**
    * Social Media Links
    */
    public function updateSocialLinks(UpdateBusinessSettingsRequest $request)
    {
        $setting = BusinessSetting::find(1);

        $data = $request->validated();

        if ($request->hasFile('favicon_icon')) {
            if ($setting->favicon_icon && file_exists(public_path($setting->favicon_icon))) {
                unlink(public_path($setting->favicon_icon));
            }

            $iconName = time() . '_' . $request->file('favicon_icon')->getClientOriginalName();
            $request->file('favicon_icon')->move(public_path('business-settings/favicons'), $iconName);
            $data['favicon_icon'] = 'business-settings/favicons/' . $iconName;
        }

        $setting->update($data);

        Toastr::success('Social Information updated.');
        return redirect()->route('business-settings.edit', 1);
    }

    /**
    * Policies
    */
    public function updatePolicies(UpdateBusinessSettingsRequest $request)
    {
        $setting = BusinessSetting::find(1);
        $data = $request->validated();
        $data['privacy_policy'] = strip_tags($request->input('privacy_policy'));
        $data['terms_and_conditions'] = strip_tags($request->input('terms_and_conditions'));
        $data['return_policy'] = strip_tags($request->input('return_policy'));

        $setting->update($data);

        Toastr::success('Policy Information updated.');
        return redirect()->route('business-settings.edit', 1);
    }
}
