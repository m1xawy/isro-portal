<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $checkboxes = ['disable_register'];
        foreach ($checkboxes as $checkbox) {
            if (!$request->has($checkbox)) {
                Setting::updateOrCreate(['key' => $checkbox], ['value' => 0]);
            }
        }

        /*
        foreach ($request->except('_token') as $key => $value) {
            Setting::set($key, $value);
        }
        */

        return back()->with('success', 'Settings updated!');
    }

    public function clear_cache()
    {
        \Artisan::call('optimize:clear');
        return back()->with('success', 'All caches have been cleared!');
    }
}
