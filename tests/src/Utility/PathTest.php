<?php

namespace Nip\Controllers\Tests\Utility;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\Controllers\BaseController;
use Nip\Controllers\Tests\Fixtures\Controllers\Parent\ChildController;
use Nip\Controllers\Utility\Path;

/**
 * Class PathTest
 * @package Nip\Controllers\Tests\Utility
 */
class PathTest extends AbstractTest
{
    /**
     * @dataProvider data_basePath
     * @param $controller
     * @param $path
     */
    public function test_basePath($controller, $path)
    {
        self::assertSame($path, Path::basePath($controller));
    }

    /**
     * @return \string[][]
     */
    public function data_basePath()
    {
        $path = TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'Controllers';
        return [
            [BaseController::class, $path],
            [ChildController::class, $path],
            [new BaseController(), $path],
            [new ChildController(), $path],
        ];
    }
}
