<?php

declare(strict_types=1);

namespace Nip\Controllers\Traits;

use Nip\Dispatcher\Resolver\ClassResolver\NameFormatter;
use Nip\Http\Response\Response;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Trait ActionCallTrait.
 */
trait ActionCallTrait
{
    protected $action = null;

    /**
     * @param bool $action
     *
     * @return Response|ResponseInterface
     */
    public function dispatchAction($action = false)
    {
        $action = NameFormatter::formatActionName($action);

        return $this->callAction($action);
    }

    /**
     * @param bool  $method
     * @param array $parameters
     *
     * @return ResponseInterface
     */
    public function callAction($method = false, $parameters = [])
    {
        if ($method) {
            if ($this->validAction($method)) {
                $this->setAction($method);

                return $this->runAction($method, $parameters);
            } else {
                throw new NotFoundHttpException('Controller method [' . $method . '] not found for ' . static::class);
            }
        }

        throw new NotFoundHttpException('No action specified for ' . static::class);
    }

    /**
     * @param array $parameters
     *
     * @return ResponseInterface
     */
    protected function runAction($method, $parameters = [])
    {
        $this->invokeStage('parseRequest');
        $this->invokeStage('beforeAction');

        $response = \call_user_func_array([$this, $method], $parameters);

        if ($response instanceof ResponseInterface) {
            $this->setResponse($response);
        }

        $this->invokeStage('afterAction');

        if ($this->hasResponse()) {
            return $this->getResponse();
        }

        return $this->getResponse(true);
    }

    /**
     * @return bool
     */
    protected function validAction($action)
    {
        return \in_array($action, get_class_methods(static::class));
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return self
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }
}
