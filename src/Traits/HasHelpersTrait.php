<?php

namespace Nip\Controllers\Traits;

use Nip\HelperBroker;
use Nip\Helpers\AbstractHelper;

/**
 * Trait HasHelpersTrait
 * @package Nip\Controllers\Trait
 *
 * @method \Nip_Helper_Url Url()
 * @method \Nip_Helper_Arrays Arrays()
 * @method \Nip_Helper_Async Async()
 */
trait HasHelpersTrait
{
    /**
     * @var AbstractHelper[]
     */
    protected $helpers = [];

    /**
     * @param $name
     * @return AbstractHelper
     */
    public function getHelper($name)
    {
        return HelperBroker::get($name);
    }
}