<?php

namespace Nip\Controllers\Tests\Fixtures\Controllers;

/**
 * Class BaseController
 * @package Nip\Controllers\Tests\Fixtures
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
        return dirname(__DIR__) . '/views';
    }
}
