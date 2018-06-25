<?php

namespace Nip\Controllers\Tests\Traits;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\BaseControllerWithUtilityMethods;
use Nip\Request;

/**
 * Class DispatchAwareTraitTest
 * @package Nip\Controllers\Tests\Traits
 */
class DispatchAwareTraitTest extends AbstractTest
{
    public function testDynamicCallHelper()
    {
        $controller = new BaseControllerWithUtilityMethods();
        $controller->setRequest(new Request());

        $controller->call();
        static::assertInstanceOf('Nip_Helper_Url', $controller->Url());
    }
}
