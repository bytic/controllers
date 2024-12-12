<?php

declare(strict_types=1);

namespace Nip\Controllers\Traits;

use Nip\Http\Request;

/**
 * Trait HttpsTrait.
 */
trait HttpsTrait
{
    public function checkSecureRequest(Request $request = null)
    {
        if ($this->needsSecureRequest($request)) {
            $this->forceSecureRequest($request);
        }
    }

    public function forceSecureRequest(Request $request = null)
    {
        $request = $request ?: $this->getRequest();
        if ($this->isSecureRequest($request)) {
            return;
        }
        $this->redirect(str_replace('http://', 'https://', $request->fullUrl()));
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function isSecureRequest(Request $request = null)
    {
        $request = $request ?: $this->getRequest();

        return $request->isSecure();
    }

    /**
     * @return bool
     */
    protected function needsSecureRequest(Request $request = null)
    {
        return false;
    }
}
