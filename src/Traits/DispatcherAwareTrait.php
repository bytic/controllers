<?php

namespace Nip\Controllers\Traits;

use Nip\Controllers\Controller;
use Nip\Request;

/**
 * Trait DispatcherAwareTrait
 * @package Nip\Controllers\Traits
 */
trait DispatcherAwareTrait
{
    /**
     * @param bool $action
     * @param bool $controller
     * @param bool $module
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function call($action = false, $controller = false, $module = false, $params = [])
    {
        /** @var Request $newRequest */
        $newRequest = $this->getRequest()->duplicateWithParams($action, $controller, $module, $params);

        $action = [
            'module' => $newRequest->getModuleName(),
            'controller' => $newRequest->getControllerName(),
            'action' => $newRequest->getActionName(),
        ];
        return $this->getDispatcher()->call($action, $params);
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

    /**
     * @return mixed
     */
    protected function getDispatcher()
    {
        return app('dispatcher');
    }
}
