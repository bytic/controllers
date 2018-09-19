<?php

namespace Nip\Controllers\Tests\Fixtures;

use Nip\Controllers\Controller;
use Nip\Controllers\Traits\BaseControllerTrait;

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
}
