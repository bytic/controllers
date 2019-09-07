<?php

namespace Nip\Controllers\Traits;

use Nip\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait DispatcherAwareTrait
 * @package Nip\Controllers\Traits
 */
trait DispatcherAwareTrait
{
    use \Nip\Dispatcher\DispatcherAwareTrait;

    /**
     * @param null|Request $request
     *
     * @return Response
     */
    public function dispatch($request = null)
    {
        $request = $request ? $request : $this->getRequest();
        $this->populateFromRequest($request);

        return $this->dispatchAction($request->getActionName());
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function call()
    {
        $arguments = func_get_args();
        $argumentsCount = count($arguments);
        if ($argumentsCount >= 3) {
            return $this->callMCA(...$arguments);
        }

        if ($argumentsCount == 2) {
            if (is_string($arguments[0]) && is_array($arguments[1])) {
                return $this->{$arguments[0]}(...$arguments[1]);
            }
            return $this->callMCA(...$arguments);
        }

        if ($argumentsCount == 1) {
            return $this->{$arguments[0]}();
        }

        throw new \Exception("Controller call method invoked with invalid parameters");
    }

    /**
     * @param bool $action
     * @param bool $controller
     * @param bool $module
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    protected function callMCA($action = false, $controller = false, $module = false, $params = [])
    {
        $newRequest = $this->getRequest()->duplicateWithParams($action, $controller, $module, $params);

        $controller = $this->getDispatcher()->generateController($newRequest);
        $controller = $this->prepareCallController($controller, $newRequest);

        return call_user_func_array([$controller, $action], $params);
    }

    /**
     * @param Controller $controller
     * @param Request $newRequest
     * @return Controller
     */
    protected function prepareCallController($controller, $newRequest)
    {
        $controller->setRequest($newRequest);
        $controller->populateFromRequest($newRequest);

        if (method_exists($controller, 'setView')) {
            $controller->setView($this->getView());
        }

        return $controller;
    }

    /**
     * @param bool $action
     * @param bool $controller
     * @param bool $module
     * @param array $params
     * @throws \Nip\Dispatcher\Exceptions\ForwardException
     */
    protected function forward($action = false, $controller = false, $module = false, $params = [])
    {
        $this->getDispatcher()->forward($action, $controller, $module, $params);
    }
}
