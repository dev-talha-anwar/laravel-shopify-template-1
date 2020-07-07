<?php
namespace App\Http\Traits;

use App\Models\Country;
use Illuminate\Support\Facades\Request;

trait ShopifyTrait {

    // public function createSnippetFile($themeid,$country_name,$currency,$shop = null){
	// 	$this->shop($shop);
    // 	$countries=$shop->shop_countries;
    // 	if($countries->isEmpty()){
    // 		$countries = Country::where('name' , $country_name)->get();
    // 	}
    //     $currency_symbols=$countries->pluck('currency_symbol');
    // 	$lfile = view('currency_converter',compact('countries','currency_symbols','country_name','currency'))->render();
    //         $add=[
    //             "asset" => [
    //                 "key" => config('constants.strings.app_snippet'),
    //                 "value" => "{$lfile}"
    //             ]
    //         ];
    //     $request = $this->api_request('PUT',"saveSingleAsset",$themeid,$add);
    // }
	// public function deleteSnippetFile($themeid,$shop = null){
	// 	$this->shop($shop);
    //     $requests = $this->api_request("DELETE","deleteAsset",$themeid,["asset[key]" => config('constants.strings.app_snippet')],['status']);
    // }
	// public function createScriptTag($shop){
	// 	$this->shop($shop);
	// 	if(!$shop->scriptTag_id):
	// 		$add=[
	// 	        "script_tag" => [
	// 				"event" => "onload",
	// 				"display_scope" => "order_status",
	// 	            "src" => secure_asset(config('constants.strings.filename'))
	// 	        ]
	// 	    ];
	// 	    $scriptTag_id =  $this->api_request('POST', "saveScriptTag", null ,$add,['body','script_tag','id']);
	// 	    $shop->scriptTag_id = "{$scriptTag_id}";
	// 	    $shop->save();
	// 	endif;
	// }
	// public function includeSnippet($themeid,$shop = null){
	// 	$this->shop($shop);
	// 	$requests =  $this->api_request('GET', "getSingleAsset",$themeid,["asset[key]" => config('constants.strings.theme_liquid_file')],['body','asset','value']);
	// 	if($requests):
	//         $html = $requests;
	//         if(strpos($html, config('constants.strings.app_start_identifier')) === false):
	// 	        $pos = strpos($html,config('constants.strings.app_include_before_tag'));
	// 	        $newhtml = substr($html,0,$pos).config('constants.strings.app_include').substr($html,$pos);
	// 	        $toupdate = [
	// 	            "asset" => [
	// 	                "key" => config('constants.strings.theme_liquid_file'),
	// 	                "value" => $newhtml
	// 	            ]
	// 	        ];
	// 	        $this->api_request('PUT', "saveSingleAsset",$themeid,$toupdate,['status']);
	//     	endif;
    // 	endif;
	// }
	// public function deleteIncludeSnippet($themeid,$shop = null){
	// 	$this->shop($shop);
	// 	$requests =  $this->api_request('GET', "getSingleAsset",$themeid,["asset[key]" => config('constants.strings.theme_liquid_file')],['body','asset','value']);
	// 	$pos = strpos($requests,config('constants.strings.app_start_identifier'));
	// 	if($pos !== false):
	// 		$pos2 = strpos($requests,config('constants.strings.app_end_identifier'));
	//         $newhtml = substr($requests,0,$pos).substr($requests,$pos2+strlen(config('constants.strings.app_end_identifier')));
	//         $toupdate = [
	//             "asset" => [
	//                 "key" => config('constants.strings.theme_liquid_file'),
	//                 "value" => $newhtml
	//             ]
	//         ];
	//         $requests =  $this->api_request('PUT', "saveSingleAsset",$themeid,$toupdate,['status']);
    // 	endif;
	// }
}