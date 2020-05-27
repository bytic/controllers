<?php

namespace Nip\Controllers\Response\ResponsePayload;

use Nip\Controllers\Response\ResponseData;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Trait HasHeadersTrait
 * @package Nip\Controllers\Response\ResponsePayload
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

}