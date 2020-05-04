<?php

namespace Nip\Controllers\Tests\Traits;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\BaseControllerWithUtilityMethods;
use Nip\Http\Response\Response;

/**
 * Class ControllerActionCallTest
 * @package Nip\Controllers\Tests\Traits
 */
class ControllerActionCallTest extends AbstractTest
{
    public function testCallActionEmptyMethod()
    {
        $controller = new BaseControllerWithUtilityMethods();

        self::expectException(\Exception::class);
        $controller->callAction();
    }

    public function testBeforeAndAfterCalls()
    {
        $controller = new BaseControllerWithUtilityMethods();
        $response = $controller->callAction('index');

        self::assertInstanceOf(Response::class, $response);
//        var_dump($response);die();
        self::assertTrue($response->hasHeader('beforeAction'));
        self::assertTrue($response->hasHeader('afterAction'));
    }
}
