<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;


class SettingController extends Controller
{
    public function index(): View|RedirectResponse
    {
        try {
            return view('adminr.settings.index');
        } catch (\Exception | \Error $e){
            info($e->getMessage());
            return $this->backError('Something went wrong!');
        }
    }

    public function general(): View|RedirectResponse
    {
        try {
            return view('adminr.settings.general');
        } catch (\Exception | \Error $e){
            info($e->getMessage());
            return $this->backError('Something went wrong!');
        }
    }
    
    public function email(): View|RedirectResponse
    {
        try {
            return view('adminr.settings.email');
        } catch (\Exception | \Error $e){
            info($e->getMessage());
            return $this->backError('Something went wrong!');
        }
    }

    public function features(): View|RedirectResponse
    {
        try {
            return view('adminr.settings.features');
        } catch (\Exception | \Error $e){
            info($e->getMessage());
            return $this->backError('Something went wrong!');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        try{
            foreach($request->except('_token') as $key => $input) {
                $setting = Setting::where('option', $key)->first();
                if ($input instanceof UploadedFile){
                    if($request->hasFile($key)){
                        $value = $this->uploadFile($input, 'settings', Str::snake($key).'_')->getFilePath();
                        if($setting){
                            $this->deleteStorageFile($setting->value);
                        }
                    } else {
                        $value = $setting->value;
                    }
                } else {
                    $value = is_array($input) ? json_encode($input) : $input;
                }
                if($setting){
                    $setting->update([
                        "option" => $key,
                        "value" => $value
                    ]);
                } else {
                    Setting::firstOrCreate([
                        "option" => $key,
                        "value" => $value
                    ]);
                }

                /// Clear all the setting cache
                /// To get latest updated data

                Cache::forget('getSetting'.Str::studly($key));
            }

            return $this->backSuccess('Setting updated successfully');
        } catch (\Exception $e){
            return $this->backError('Error: ' . $e->getMessage());
        } catch (\Error $e){
            return $this->backError('Error: ' . $e->getMessage());
        }
    }
}

