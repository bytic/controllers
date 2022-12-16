<?php

declare(strict_types=1);

namespace Nip\Controllers\Traits;

use Nip\Controllers\Response\ResponseFactory;
use Nip\Controllers\Response\ResponsePayload;
use Nip\Controllers\Response\ResponsePayloadTransformer;
use Nip\Http\Response\Response;
use Nip\Http\Response\ResponseAwareTrait;

/**
 * Trait HasResponseTrait.
 */
trait HasResponseTrait
{
    use ResponseAwareTrait;

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
    protected function getResponseFactory(): ?ResponseFactory
    {
        if (null === $this->responseFactory) {
            $this->responseFactory = new ResponseFactory();
        }

        return $this->responseFactory;
    }

    /**
     * @return null
     */
    public function payload()
    {
        if (null === $this->responsePayload) {
            $this->responsePayload = $this->generateResponsePayload();
        }

        return $this->responsePayload;
    }

    protected function generateResponsePayload(): ResponsePayload
    {
        return ResponsePayload\ResponsePayloadFactory::fromController($this);
    }
}
