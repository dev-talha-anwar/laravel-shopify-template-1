<?php
namespace App\Http\Traits;

use App\Models\Country;
use Illuminate\Support\Facades\Request;

trait ShopifyApiTrait {
	private $shop;
	
	public function shop($shop = null){
		if(!$this->shop):
			$this->shop = ($shop ?  $shop : auth()->user());
		endif;
	}

	public function api_request($method = "GET" ,$api = "" ,$api_get_fields = null, $api_post_fields = null  ,$api_required_fields = null,$shop = null){
		$this->shop($shop);
		$response =  $this->shop->api()->rest($method, $this->makeUrl($api , $api_get_fields),$api_post_fields);
		if($response['errors'] === true):
			return false;
		endif;
		if($api_required_fields):
			foreach ($api_required_fields as $key => $value) {
				if(!isset($response[$value])):
					return $response;
				endif;
				$response = $response[$value];
			}
			return $response;
		endif;
		return $response;
	}
	public function makeUrl($api,$data = null){
		$url = [];
		foreach (config("constants.apis.$api") as $value) {
			if($data) :
				$url[]=$value;
				$url[] = $data;
				$data = null;
			else:
				$url[] = $value;
			endif;
		}
		return implode('', $url);
	}
	public function getActiveTheme($shop = null){
		$this->shop($shop);
		$requests =  $this->api_request('GET', "getAllThemes",null , null , ['body','themes']);
            $themeid = null;
            foreach($requests as $theme){
                if($theme['role'] == "main"){
                    $themeid = $theme['id'];
                    break;
                }
			}
		return $themeid;
	}
}