<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests\Traits;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\Controllers\BaseControllerWithUtilityMethods;
use Nip\Http\Response\Response;

/**
 * Class ControllerActionCallTest.
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
