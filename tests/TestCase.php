<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

//        Artisan::call('config:cache');
//        Artisan::call('config:clear');
//
//        Artisan::call('migrate');
//        Artisan::call('db:seed');

    }

    public function tearDown(): void
    {
        parent::tearDown();
//        Artisan::call('migrate:reset');
//        Artisan::call('config:cache');
//        Artisan::call('config:clear');
    }
}
