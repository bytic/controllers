<?php

declare(strict_types=1);

namespace Nip\Controllers;

use Nip\Controllers\Behaviours\RegistersViewPaths;
use Nip\Controllers\Traits\HasViewTrait;

/**
 * Class ViewController.
 */
class ViewController extends Controller implements RegistersViewPaths
{
    use HasViewTrait;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
//        $this->inflectName();
    }
}
