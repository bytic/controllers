<?php

declare(strict_types=1);

namespace Nip\Controllers\Response\ResponsePayload\Traits;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Trait HasHeadersTrait.
 */
trait HasHeadersTrait
{
    /**
     * @var ResponseHeaderBag
     */
    public $headers;

    protected function initHeaders()
    {
        $this->headers = new ResponseHeaderBag();
    }

    /**
     * @return ResponseHeaderBag
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $value
     */
    public function addP3PHeader($value = 'CP="CAO PSA OUR"')
    {
        // FIX FOR IE SESSION COOKIE
        // CAO IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT
        // ALL ADM DEV PSAi COM OUR OTRo STP IND ONL
//        header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');

        $this->headers->set('P3P', $value);
    }
}
