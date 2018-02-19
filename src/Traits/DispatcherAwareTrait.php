<?php

namespace Nip\Controllers\Traits;

/**
 * Trait DispatcherAwareTrait
 * @package Nip\Controllers\Traits
 */
trait DispatcherAwareTrait
{

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
     * @param bool $action
     * @param bool $controller
     * @param bool $module
     * @param array $params
     * @return mixed
     */
    public function call($action = false, $controller = false, $module = false, $params = [])
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
