<?php

namespace Nip\Controllers\Response;

use Nip\Controllers\Controller;
use Nip\Controllers\Traits\HasResponseTrait;
use Nip\Controllers\Traits\HasViewTrait;
use Nip\Controllers\View\ControllerViewHydrator;
use Nip\Http\Response\JsonResponse;
use Nip\Http\Response\Response;
use Nip\Utility\Str;

/**
 * Class ResponsePayloadTransformer
 * @package Nip\Controllers\Response
 */
class ResponsePayloadTransformer
{
    /**
     * @var Controller|HasViewTrait
     */
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
     * @return \Nip\Http\Response\Response|JsonResponse
     */
    protected function toResponse()
    {
        $controllerMethod = $this->responseControllerMethod();
        if (method_exists($this->controller, $controllerMethod)) {
            return call_user_func_array([$this->controller, $controllerMethod], [$this->factory, $this->payload]);
        }
        $format = $this->payload->getFormat();
        switch ($format) {
            case 'view':
            case 'html':
                return $this->toViewResponse();
            case 'json':
                return $this->factory->json($this->payload->all());
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
        $this->payload->headers->set('Content-Type', 'text/html');

        $viewPath = $this->controller->getLayoutPath();

        $response = $this->factory->view(
            $viewPath,
            $this->payload->data->all(),
            Response::HTTP_OK,
            $this->payload->headers->all()
        );

        $response->setCharset('utf-8');
        return $response;
    }

    protected function responseControllerMethod(): string
    {
        return $this->controller->getAction()
            .Str::studly($this->payload->getFormat())
            .'Response';
    }
}
