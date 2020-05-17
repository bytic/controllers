<?php

namespace Nip\Controllers\Traits;

use Nip\Http\Request;

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
        $this->setName($request->getControllerName());
        $this->setAction($request->getActionName());
    }
}
