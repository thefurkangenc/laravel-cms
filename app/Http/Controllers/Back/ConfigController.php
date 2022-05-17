<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ConfigController extends Controller
{
    public function index()
    {
        $config = Config::find(1);
        return view('back.config.index', compact('config'));
    }
    public function configUpdate(Request $request)
    {
        $config = Config::find(1);
        $config->title = $request->title;
        $config->active = $request->active;
        $config->facebook = $request->facebook;
        $config->twitter = $request->twitter;
        $config->linkedin = $request->linkedin;
        $config->github = $request->github;
        $config->instagram = $request->instagram;
        $config->youtube = $request->youtube;

        if ($request->hasFile('logo')) {
            if (File::exists(public_path($config->logo))) {
                File::delete(public_path($config->logo));
            }
            $logo = STR::slug($request->title) . 'logo' . STR::slug(STR::substr(now(), 8, 10)) . '.' . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('uploads'), $logo);
            $config->logo = '/uploads/' . $logo;
        }
        if ($request->hasFile('favicon')) {
            if (File::exists(public_path($config->favicon))) {
                File::delete(public_path($config->favicon));
            }
            $favicon = STR::slug($request->title) . 'favicon' . STR::slug(STR::substr(now(), 8, 10)) . '.' . $request->favicon->getClientOriginalExtension();
            $request->favicon->move(public_path('uploads'), $favicon);
            $config->favicon = '/uploads/' . $favicon;
        }
        $config->save();
        toastr('Ayarlar güncellendi');
        return redirect()->back();
    }
}
