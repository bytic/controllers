<?php

namespace Nip\Controllers\Tests\Helpers;

use Nip\Controllers\Controller;
use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\BaseControllerWithUtilityMethods;
use Nip\Http\Response\Response;

/**
 * Class ControllerHasHelpersTest
 * @package Nip\Tests\Helpers
 */
class ControllerHasHelpersTest extends AbstractTest
{

    public function testDynamicCallHelper()
    {
        $controller = new Controller();

        static::assertInstanceOf('Nip_Helper_Url', $controller->Url());
//        static::assertInstanceOf('Nip_Helper_Xml', $controller->Xml());
//        static::assertInstanceOf('Nip_Helper_Passwords', $controller->Passwords());
    }

    public function testGetHelper()
    {
        $controller = new Controller();

        static::assertInstanceOf('Nip_Helper_Url', $controller->getHelper('Url'));
        static::assertInstanceOf('Nip_Helper_Xml', $controller->getHelper('Xml'));
        static::assertInstanceOf('Nip_Helper_Passwords', $controller->getHelper('passwords'));
    }
}
