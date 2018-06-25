<?php

namespace Nip\Controllers\Traits;

use Nip\Request;

/**
 * Trait RequestAwareTrait
 * @package Nip\Controllers\Traits
 */
trait RequestAwareTrait
{
    use \Nip\Http\Request\RequestAwareTrait;

    /**
     * @param Request $request
     */
    public function populateFromRequest(Request $request)
    {
        $this->name = $request->getControllerName();
        $this->action = $request->getActionName();
    }
}