<?php

declare(strict_types=1);

namespace Nip\Controllers\Traits;

use Nip\Container\Container;
use Nip\Dispatcher\Dispatcher;
use Nip\Request;

/**
 * Trait DispatcherAwareTrait.
 */
trait DispatcherAwareTrait
{
    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function call()
    {
        $arguments = \func_get_args();
        if (\count($arguments) >= 3) {
            return $this->callMCA(...$arguments);
        }

        if (2 == \count($arguments) && \is_array($arguments[1])) {
            if (\is_string($arguments[0])) {
                return $this->{$arguments[0]}(...$arguments[1]);
            }
        }

        if (1 == \count($arguments)) {
            return $this->{$arguments[0]}();
        }

        throw new \Exception('Controller call method invoked with invalid parameters');
    }

    /**
     * @param bool  $action
     * @param bool  $controller
     * @param bool  $module
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function callMCA($action = false, $controller = false, $module = false, $params = [])
    {
        /** @var Request $newRequest */
        $newRequest = $this->getRequest()->duplicateWithParams($action, $controller, $module, $params);

        /* @noinspection PhpUnhandledExceptionInspection */
        return $this->getDispatcher()->callFromRequest($newRequest, $params);
    }

    /**
     * @param bool  $action
     * @param bool  $controller
     * @param bool  $module
     * @param array $params
     *
     * @throws \Nip\Dispatcher\Exceptions\ForwardException
     */
    protected function forward($action = false, $controller = false, $module = false, $params = [])
    {
        $this->getDispatcher()->forward($action, $controller, $module, $params);
    }

    /**
     * @return Dispatcher
     */
    protected function getDispatcher()
    {
        if (\function_exists('app')) {
            return app('dispatcher');
        }

        return Container::getInstance()->get('dispatcher');
    }
}
