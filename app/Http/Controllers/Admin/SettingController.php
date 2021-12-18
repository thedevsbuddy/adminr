<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Devsbuddy\AdminrCore\Http\Controllers\AdminrController;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;


class SettingController extends AdminrController
{
    public function index()
    {
        try {
            return view('admin.settings.index');
        } catch (\Exception $e){
            return back()->with('error', 'Error: ' . $e->getMessage());
        } catch (\Error $e){
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try{
            foreach($request->except('_token') as $key => $input) {
                $setting = Setting::where('option', $key)->first();
                if ($input instanceof UploadedFile){
                    if($request->hasFile($key)){
                        $value = $this->uploadFile($input, 'settings')->getFileName();
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
            }

            return back()->with('success', 'Setting updated successfully');
        } catch (\Exception $e){
            return back()->with('error', 'Error: ' . $e->getMessage());
        } catch (\Error $e){
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}

