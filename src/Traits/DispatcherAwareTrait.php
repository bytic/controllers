<?php

namespace Nip\Controllers\Traits;

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
        if (count($arguments) >= 3) {
            return $this->callMCA(...$arguments);
        }

        if (count($arguments) == 2 && is_array($arguments[1])) {
            if (is_string($arguments[0])) {
                return $this->{$arguments[0]}(...$arguments[1]);
            }
        }

        if (count($arguments) == 1) {
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
     */
    protected function callMCA($action = false, $controller = false, $module = false, $params = [])
    {
        $newRequest = $this->getRequest()->duplicateWithParams($action, $controller, $module, $params);

        $controller = $this->getDispatcher()->generateController($newRequest);
        $controller = $this->prepareCallController($controller, $newRequest);

        return call_user_func_array([$controller, $action], $params);
    }

    /**
     * @param self $controller
     * @param Request $newRequest
     * @return Controller
     */
    protected function prepareCallController($controller, $newRequest)
    {
        $controller->setRequest($newRequest);
        $controller->populateFromRequest($newRequest);

        return $controller;
    }

    /**
     * @param bool $action
     * @param bool $controller
     * @param bool $module
     * @param array $params
     */
    protected function forward($action = false, $controller = false, $module = false, $params = [])
    {
        $this->getDispatcher()->forward($action, $controller, $module, $params);
    }
}
