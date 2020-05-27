<?php

namespace Nip\Controllers\Tests\Fixtures\Controllers;

use Nip\Controllers\Controller;

/**
 * Class BaseController
 * @package Nip\Controllers\Tests\Fixtures
 */
class BaseController extends Controller
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
