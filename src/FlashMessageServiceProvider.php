<?php

namespace RBoonzaijer\LaravelMultipleFlashMessages;

use Illuminate\Support\ServiceProvider;

class FlashMessageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(FlashMessageContainer::class, function() {
            return new FlashMessageContainer();
        });
    }

    public function boot()
    {
        //
    }
}
