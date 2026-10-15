<?php

namespace Croox\FormIntercept\Tests;

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function test_interception_is_off_unless_enabled(): void
    {
        putenv('FORM_INTERCEPT_ENABLED');
        unset($_ENV['FORM_INTERCEPT_ENABLED'], $_SERVER['FORM_INTERCEPT_ENABLED']);

        $config = require __DIR__.'/../config/form-intercept.php';

        $this->assertFalse($config['enabled']);
    }
}
