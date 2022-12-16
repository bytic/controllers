<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests\Fixtures\Controllers\Parent;

use Nip\Controllers\Controller;

/**
 * Class ChildController.
 */
class ChildController extends Controller
{
    public function index()
    {
        return 'index';
    }
}
