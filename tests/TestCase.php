<?php

namespace RBoonzaijer\LaravelMultipleFlashMessages\Tests;

use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use RBoonzaijer\LaravelMultipleFlashMessages\FlashMessageServiceProvider;

class TestCase extends OrchestraTestCase
{
    use WithWorkbench;
    
    protected function getPackageProviders($app)
    {
        return [FlashMessageServiceProvider::class];
    }
}
