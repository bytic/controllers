<?php

namespace Nip\Controllers;

use Nip\Controllers\Response\ResponsePayload;
use Nip\Controllers\Traits\HasViewTrait;

/**
 * Class ViewController
 * @package Nip\Controllers
 */
class ViewController extends Controller
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
