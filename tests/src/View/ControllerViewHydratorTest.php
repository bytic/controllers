<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests\View;

use Mockery\Mock;
use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\Controllers\ViewController;
use Nip\Controllers\View\ControllerViewHydrator;
use Nip\View;

/**
 * Class ControllerViewHydratorTest.
 */
class ControllerViewHydratorTest extends AbstractTest
{
    public function testPopulatePath()
    {
        $view = new View();
        $controller = new ViewController();
        ControllerViewHydrator::populatePath($view, $controller);

        self::assertStringStartsWith($controller->generateViewPath(), $view->getBasePath());
    }

    public function testInitContentBlocks()
    {
        /** @var View\View|Mock $view */
        $view = \Mockery::mock(View::class)->makePartial();
        $view->shouldReceive('load')->with('/testName/test_action')->andReturnTrue();

        $controller = new ViewController();
        $controller->setName('testName');
        $controller->setAction('testAction');
        ControllerViewHydrator::initContentBlocks($view, $controller);

        self::assertNull($view->render('content'));
    }
}
