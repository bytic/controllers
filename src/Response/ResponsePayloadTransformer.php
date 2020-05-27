<?php

namespace Nip\Controllers\Response;

use Nip\Controllers\Controller;
use Nip\Controllers\Traits\HasResponseTrait;
use Nip\Controllers\View\ControllerViewHydrator;
use Nip\Utility\Str;

/**
 * Class ResponsePayloadTransformer
 * @package Nip\Controllers\Response
 */
class ResponsePayloadTransformer
{
    protected $controller;
    protected $payload;
    protected $factory;

    /**
     * @param Controller|HasResponseTrait $controller
     * @param ResponsePayload $payload
     * @return \Nip\Http\Response\Response
     */
    public static function make($controller, ResponsePayload $payload)
    {
        $transformer = new static($controller, $payload);

        return $transformer->toResponse();
    }

    /**
     * ResponsePayloadTransformer constructor.
     * @param Controller $controller
     * @param ResponsePayload $payload
     */
    protected function __construct($controller, ResponsePayload $payload)
    {
        $this->controller = $controller;
        $this->payload = $payload;

        $this->factory = new ResponseFactory();
    }


    /**
     * @return \Nip\Http\Response\Response
     */
    protected function toResponse()
    {
        $controllerMethod = $this->responseControllerMethod();
        if (method_exists($this->controller, $controllerMethod)) {
            return call_user_func_array([$this->controller, $controllerMethod], [$this->factory, $this->payload]);
        }
        $format = $this->payload->getFormat();
        if (in_array($format, ['view', 'html'])) {
            return $this->toViewResponse();
        }

        return $this->factory->noContent();
    }

    /**
     * @return \Nip\Http\Response\Response
     */
    protected function toViewResponse()
    {
        $view = $this->controller->getView();

        ControllerViewHydrator::populatePath($view, $this->controller);
        ControllerViewHydrator::initVars($view, $this->controller);
        ControllerViewHydrator::initContentBlocks($view, $this->controller);

        $this->factory->setView($view);

        $viewPath = $this->controller->getLayoutPath();

        return $this->factory->view($viewPath, $this->payload->all());
    }

    protected function responseControllerMethod(): string
    {
        return $this->controller->getAction()
            .Str::studly($this->payload->getFormat())
            .'Response';
    }
}
