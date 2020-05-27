<?php

namespace Nip\Controllers\Traits;

use Nip\Controllers\Response\ResponseFactory;
use Nip\Controllers\Response\ResponsePayload;
use Nip\Controllers\Response\ResponsePayloadTransformer;
use Nip\Http\Response\Response;

/**
 * Trait HasResponseTrait
 * @package Nip\Controllers\Traits
 */
trait HasResponseTrait
{
    use \Nip\Http\Response\ResponseAwareTrait;

    protected $responseFactory = null;
    protected $responsePayload = null;

    /**
     * @return Response
     */
    public function newResponse()
    {
        return ResponsePayloadTransformer::make($this, $this->payload());
    }

    /**
     * @return null
     */
    protected function getResponseFactory()
    {
        if ($this->responseFactory === null) {
            $this->responseFactory = new ResponseFactory();
        }

        return $this->responseFactory;
    }

    /**
     * @return null
     */
    public function payload()
    {
        if ($this->responsePayload === null) {
            $this->responsePayload = new ResponsePayload();
        }

        return $this->responsePayload;
    }
}
