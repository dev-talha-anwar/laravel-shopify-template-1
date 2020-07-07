<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Setting;
use Illuminate\Http\Request;
use Auth;
class SettingController extends Controller
{
    public function Geolocation(){
        $settings = auth()->user()->settings;
        if($settings->geolocation):
            $settings->geolocation = 0;
            $settings->save();
            return response()->json(['success' => "Geolocation Turned Off."]);
        else:
            $settings->geolocation = 1;
            $settings->save();
            return response()->json(['success' => "Geolocation Turned On."]);
        endif;
    }
}