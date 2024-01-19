<?php

namespace RBoonzaijer\LaravelMultipleFlashMessages\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use RBoonzaijer\LaravelMultipleFlashMessages\FlashMessageServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [FlashMessageServiceProvider::class];
    }
}
