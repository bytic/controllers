<?php

declare(strict_types=1);

namespace Nip\Controllers\Traits;

use Nip\HelperBroker;
use Nip\Helpers\AbstractHelper;

/**
 * Trait HasHelpersTrait.
 *
 * @method \Nip_Helper_Arrays Arrays()
 * @method \Nip_Helper_Async  Async()
 */
trait HasHelpersTrait
{
    /**
     * @var AbstractHelper[]
     */
    protected $helpers = [];

    /**
     * @return AbstractHelper
     */
    public function getHelper($name)
    {
        return HelperBroker::get($name);
    }

    /**
     * @return \Nip_Helper_Url
     *
     * @deprecated use \Nip\url() instead
     */
    public function Url()
    {
        return $this->getHelper('Url');
    }
}
