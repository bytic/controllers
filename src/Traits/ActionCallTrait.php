<?php

namespace Nip\Controllers\Traits;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Trait ActionCallTrait
 * @package Nip\Controllers\Traits
 */
trait ActionCallTrait
{
    protected $action = null;

    /**
     * @param bool $method
     * @param array $parameters
     * @return ResponseInterface
     */
    public function callAction($method = false, $parameters = [])
    {
        if ($method) {
            if ($this->validAction($method)) {
                $this->setAction($method);

                return $this->runAction($method, $parameters);
            } else {
                throw new NotFoundHttpException(
                    'Controller method ['.$method.'] not found for '.get_class($this)
                );
            }
        }

        throw new NotFoundHttpException('No action specified for '.get_class($this));
    }

    /**
     * @param $method
     * @param array $parameters
     * @return ResponseInterface
     */
    protected function runAction($method, $parameters = [])
    {
        $this->callUtilityMethods('parseRequest');
        $this->callUtilityMethods('beforeAction');
        call_user_func_array([$this, $method], $parameters);
        $this->callUtilityMethods('afterAction');

        return $this->getResponse(true);
    }

    /**
     * @param $method
     */
    protected function callUtilityMethods($method)
    {
        if (method_exists($this, $method)) {
            $this->{$method};
        }
    }

    /**
     * @param $action
     * @return bool
     */
    protected function validAction($action)
    {
        return in_array($action, get_class_methods(get_class($this)));
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
     * @return self
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }
}
