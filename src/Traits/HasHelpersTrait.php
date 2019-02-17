<?php

namespace Nip\Controllers\Traits;

use Nip\HelperBroker;

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
     * @var Helpers\AbstractHelper[]
     */
    protected $helpers = [];

    /**
     * @param $name
     * @return Helpers\AbstractHelper
     */
    public function getHelper($name)
    {
        return HelperBroker::get($name);
    }
}
