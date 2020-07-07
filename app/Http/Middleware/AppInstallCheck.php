<?php

namespace App\Http\Middleware;

use App\Order;
use App\Models\Setting;
use Closure;
use Illuminate\Support\Facades\Auth;
class AppInstallCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $shop = Auth::user();
        $setting=$shop->settings;
        if($setting ==null){
            $setting= new Setting();
            $setting->user_id=$shop->id;
            $setting->save();
            // Now saving orders in our database
        }
        return $next($request);
    }
}
