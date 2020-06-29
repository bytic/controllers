<?php

namespace Nip\Controllers\Tests\View;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\Controllers\ViewController;
use Nip\Controllers\View\ControllerViewHydrator;
use Nip\View;

/**
 * Class ControllerViewHydratorTest
 * @package Nip\Controllers\Tests\View
 */
class ControllerViewHydratorTest extends AbstractTest
{
    public function test_populatePath()
    {
        $view = new View();
        $controller = new ViewController();
        ControllerViewHydrator::populatePath($view, $controller);

        self::assertStringStartsWith($controller->generateViewPath(), $view->getBasePath());
    }
}