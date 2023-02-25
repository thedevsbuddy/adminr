<?php

namespace Adminr\Core\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Adminr\Core\ViewComposers\MenuComposer;
use Adminr\Core\Adminr;
use Adminr\Core\Facades\AdminrFacade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Adminr\Core\Http\Helpers\ModuleHelper;

class AdminrRelationshipServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /// Do nothing here
    }

    public function boot(): void
    {
        /// Add magical relationships here
        /// Take reference from
        /// [Laravel's Dynamic Relationship](https://laravel.com/docs/9.x/eloquent-relationships#dynamic-relationships)
        ///
        /// ```php
        /// use App\Models\Order;
        /// use App\Models\Customer;
        ///
        /// Order::resolveRelationUsing('customer', function ($orderModel) {
        ///    return $orderModel->belongsTo(Customer::class, 'customer_id');
        /// });
        ///```
    }
}
