<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests\Fixtures\Controllers;

use Nip\Controllers\Controller;

/**
 * Class BaseController.
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
        return \dirname(__DIR__) . '/views';
    }
}
