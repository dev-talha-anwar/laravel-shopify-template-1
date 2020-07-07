<?php

namespace App\Jobs;

use App\Http\Traits\ShopifyApiTrait;
use App\Http\Traits\ShopifyTrait;
use App\Models\Country;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AfterAuthenticateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,ShopifyApiTrait,ShopifyTrait;

    public function handle()
    {
        $shop = auth()->user();
        $setting=$shop->settings;
        if($setting == null):
            $setting = Setting::create(['user_id' => $shop->id]);
        endif;
        if(!$shop->status):
            $themeid = $this->getActiveTheme();
            $shop->theme_id = "{$themeid}";
            // $this->createScriptTag($shop);
            // $this->createSnippetFile($themeid,$country_name,$currency,$shop);
            // $this->includeSnippet($themeid,$shop);
            $setting->enable = 1;
            $shop->status = true;
            $shop->save();
            $setting->save();
        endif;
    }
}
