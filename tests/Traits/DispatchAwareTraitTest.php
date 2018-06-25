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
        $newController = new BaseControllerWithUtilityMethods();

        $dispatcher = m::mock(Dispatcher::class)
            ->shouldReceive('generateController')
            ->andReturn($newController)
            ->getMock();

        $controller = new BaseControllerWithUtilityMethods();
        $controller->setDispatcher($dispatcher);
        $controller->setRequest(new Request());

        $response = $controller->call('hello');
        static::assertSame('hello', $response);
    }
}
