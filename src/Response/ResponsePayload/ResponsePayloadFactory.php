<?php

declare(strict_types=1);

namespace Nip\Controllers\Response\ResponsePayload;

use Nip\Controllers\Response\ResponsePayload;

class ResponsePayloadFactory
{
    protected $controller = null;
    protected $request = null;
    protected ?ResponsePayload $payload = null;

    public static function fromController($controller): ResponsePayload
    {
        $factory = new self();
        $factory->controller = $controller;
        $factory->request = $controller->getRequest();

        return $factory->create();
    }

    protected function create(): ResponsePayload
    {
        $this->payload = $this->new();
        $this->checkDefault();
        $this->checkRequestQuery();

        return $this->payload;
    }

    protected function new(): ResponsePayload
    {
        return new ResponsePayload();
    }

    protected function checkDefault()
    {
        if (method_exists($this->controller, 'getView')) {
            $this->payload->withDefaultFormat('view');
        }
    }

    protected function checkRequestQuery()
    {
        if (!$this->request) {
            return;
        }
        $param = $this->request->get(ResponsePayload::REQUEST_PARAM_FORMAT);
        if (empty($param)) {
            return;
        }

        $this->payload->withFormat($param);
    }
}
