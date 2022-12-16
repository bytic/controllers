<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests\Fixtures\Controllers;

/**
 * Class BaseController.
 */
class ViewController extends \Nip\Controllers\ViewController
{
    public function index()
    {
        return 'index';
    }

    /**
     * @return string
     */
    public function generateViewPath()
    {
        return \dirname(__DIR__) . '/views';
    }
}
