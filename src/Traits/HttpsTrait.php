<?php

namespace Nip\Controllers\Traits;

use Nip\Http\Request;

/**
 * Trait HttpsTrait
 * @package Nip\Controllers\Traits
 */
trait HttpsTrait
{
    /**
     * @param Request|null $request
     */
    public function checkSecureRequest(Request $request = null)
    {
        if ($this->needsSecureRequest($request)) {
            $this->forceSecureRequest($request);
        }
    }

    /**
     * @param Request|null $request
     */
    public function forceSecureRequest(Request $request = null)
    {
        $request = $request ? $request : $this->getRequest();
        if ($this->isSecureRequest($request)) {
            return;
        }
        $this->redirect(str_replace('http://', 'https://', $request->fullUrl()));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function isSecureRequest(Request $request = null)
    {
        $request = $request ? $request : $this->getRequest();

        return $request->isSecure();
    }

    /**
     * @param Request|null $request
     * @return bool
     */
    protected function needsSecureRequest(Request $request = null)
    {
        return false;
    }
}
