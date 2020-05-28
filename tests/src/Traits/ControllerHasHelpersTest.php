<?php

namespace Nip\Controllers\Tests\Traits;

use Nip\Controllers\Controller;
use Nip\Controllers\Tests\AbstractTest;

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
    }

    public function testGetHelper()
    {
        $controller = new Controller();

        static::assertInstanceOf('Nip_Helper_Url', $controller->getHelper('Url'));
        static::assertInstanceOf('Nip_Helper_Xml', $controller->getHelper('Xml'));
    }
}
