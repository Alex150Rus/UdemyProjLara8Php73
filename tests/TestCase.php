<?php

namespace Tests;

use Database\Factories\UserFactory;
use http\Client\Curl\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function user() {
        return UserFactory::new()->create();
    }
}
