<?php

namespace Nip\Controllers\Tests\Traits;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\BaseControllerWithUtilityMethods;
use Nip\Dispatcher\Dispatcher;
use Nip\Request;
use Mockery as m;

/**
 * Class DispatchAwareTraitTest
 * @package Nip\Controllers\Tests\Traits
 */
class DispatchAwareTraitTest extends AbstractTest
{
    public function testCallWithEmptyParams()
    {
        $controller = new BaseControllerWithUtilityMethods();
        $controller->setRequest(new Request());

        $response = $controller->call('hello');
        static::assertSame('hello', $response);
    }
}
