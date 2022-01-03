<?php

namespace Nip\Controllers;

use Nip\Controllers\Behaviours\RegistersViewPaths;
use Nip\Controllers\Response\ResponsePayload;
use Nip\Controllers\Traits\HasViewTrait;

/**
 * Class ViewController
 * @package Nip\Controllers
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
