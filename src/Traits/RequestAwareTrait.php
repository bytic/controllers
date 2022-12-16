<?php

declare(strict_types=1);

namespace Nip\Controllers\Traits;

use Nip\Http\Request;

/**
 * Trait RequestAwareTrait.
 */
trait RequestAwareTrait
{
    use \Nip\Http\Request\RequestAwareTrait;

    public function populateFromRequest(Request $request)
    {
        $this->setName($request->getControllerName());
        $this->setAction($request->getActionName());
    }
}
