<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests\Traits;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\Controllers\BaseControllerWithUtilityMethods;
use Nip\Request;

/**
 * Class DispatchAwareTraitTest.
 */
class DispatchAwareTraitTest extends AbstractTest
{
    public function testCallSameControllerWithEmptyParams()
    {
        $controller = new BaseControllerWithUtilityMethods();
        $controller->setRequest(new Request());

        $response = $controller->call('hello');
        static::assertSame('hello', $response);
    }

    public function testCallSameControllerWithParams()
    {
        $controller = new BaseControllerWithUtilityMethods();
        $controller->setRequest(new Request());

        $response = $controller->call('hello', ['John']);
        static::assertSame('hello John', $response);
    }
}
