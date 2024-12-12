<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests\View;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\Controllers\Parent\ChildController;
use Nip\Controllers\Tests\Fixtures\Controllers\ViewController;
use Nip\Controllers\View\ViewPathDetector;

/**
 * Class ViewPathDetectorTest.
 */
class ViewPathDetectorTest extends AbstractTest
{
    public function testForAutodetect()
    {
        $path = TEST_FIXTURE_PATH . \DIRECTORY_SEPARATOR . 'views';
        self::assertSame($path, ViewPathDetector::for(new ChildController()));
    }

    public function testForGenerateViewPath()
    {
        $path = TEST_FIXTURE_PATH . \DIRECTORY_SEPARATOR . 'views';

        $controller = \Mockery::mock(ViewController::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('generateViewPath')->once()->andReturn($path);

        self::assertSame($path, ViewPathDetector::for($controller));
    }
}
