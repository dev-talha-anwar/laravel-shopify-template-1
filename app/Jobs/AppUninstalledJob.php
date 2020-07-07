<?php

namespace App\Jobs;

use App\Http\Traits\ShopifyApiTrait;
use App\Http\Traits\ShopifyTrait;
use App\User;
use Osiset\ShopifyApp\Actions\CancelCurrentPlan;
use Osiset\ShopifyApp\Contracts\Commands\Shop as IShopCommand;
use Osiset\ShopifyApp\Contracts\Objects\Values\ShopDomain;
use Osiset\ShopifyApp\Contracts\Queries\Shop as IShopQuery;

class AppUninstalledJob extends \Osiset\ShopifyApp\Messaging\Jobs\AppUninstalledJob
{
    use ShopifyTrait,ShopifyApiTrait;
    protected $shopDomain;

    public function __construct(ShopDomain $domain)
    {
        $this->shopDomain = $domain;
    }
    
    public function handle(IShopCommand $shopCommand,IShopQuery $shopQuery,CancelCurrentPlan $cancelCurrentPlanAction)
    : bool{
        $shop = User::where('name' , $this->shopDomain->toNative())->first();
        if($shop):
        $shop->theme_id = null;
        $shop->scriptTag_id = null;
        $shop->status = false;
        $shop->shopify_freemium = false;
        $shop->save();
        // package logic to uninstall app
        $shop = $shopQuery->getByDomain($this->shopDomain);
        $shopId = $shop->getId();
        $cancelCurrentPlanAction($shopId);
        $shopCommand->clean($shopId);
        $shopCommand->softDelete($shopId);
        endif;
        return true;
    }
}
