<?php

namespace Nip\Controllers\Tests\Fixtures\Controllers\Parent;

use Nip\Controllers\Controller;

/**
 * Class ChildController
 * @package Nip\Controllers\Tests\Fixtures\Controllers\Parent
 */
class ChildController extends Controller
{
    public function index()
    {
        return 'index';
    }
}
