<?php

namespace App\Http\Controllers;

use App\Http\Traits\ShopifyApiTrait;
use App\Http\Traits\ShopifyTrait;
use App\Models\Country;
use App\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    use ShopifyApiTrait,ShopifyTrait;
    
    public function index(){
    	$countries = Country::all();
    	$user_currencies = [];
    	$check = auth()->user()->shop_countries;
    	if(!$check->isEmpty()):
    		$user_currencies = $check->pluck('id')->toArray();
    	endif;
    	$default_country = Country::where('name' , auth()->user()->default_country)->first()->id;
    	return view("welcome",compact('countries','user_currencies','default_country'));
    }
    
    public function update(Request $request){
        $validator = validator($request->all(), [
            'countries' => 'required',
            'countries.*' => 'required|exists:countries,id'
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }
        $shop = auth()->user();
        $default_country = Country::where('name',$shop->default_country)->first();
        if(in_array($default_country->id,request('countries'))):
            $shop->shop_countries()->sync(Country::find(request('countries')));
            $this->createSnippetFile($shop->theme_id,$shop->default_country,$shop->default_currency,$shop);
            return response()->json(['success' => "Countries Updated Successfully."]);
        else:
            return response()->json(['error' => "You Can not Delete Default Currency."]);
        endif;
    }
    
    public function changestatus(){
        $shop = auth()->user();
        $setting = $shop->settings;
        if($shop->settings->enable):
            $this->deleteIncludeSnippet($shop->theme_id);
            $setting->enable = false;
            $setting->save();
            return response()->json(['success' => "Disabled"]);
        else:
            $this->includeSnippet($shop->theme_id);
            $setting->enable = true;
            $setting->save();
            return response()->json(['success' => "Enabled"]);
        endif;
        return response()->json(['error' => "You Can not Delete Default Currency."]);
    }
    public function checkShopStatus($domain){
        $shop = User::where('name' , $domain)->get();
        if($shop->isEmpty()):
            return response()->json(['status' => 0]);
        else:
            return response()->json(['status' => 1]);        
        endif;
    }
    public function checkGeolocationStatus($domain){
        $settings = User::where('name' , $domain)->first()->settings;
        if($settings->geolocation):
            return response()->json(['status' => 1]);
        else:
            return response()->json(['status' => 0]);
        endif;
    }
}
