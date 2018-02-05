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
     * @param bool $action
     * @return ResponseInterface
     */
    public function callAction($action = false)
    {

        if ($action) {
            if ($this->validAction($action)) {
                $this->setAction($action);

                $this->parseRequest();
                $this->beforeAction();
                $this->{$action}();
                $this->afterAction();

                return $this->getResponse();
            } else {
                throw new NotFoundHttpException(
                    'Controller method [' . $action . '] not found for ' . get_class($this)
                );
            }
        }

        throw new NotFoundHttpException('No action specified for ' . get_class($this));
    }

    /**
     * Called before action
     */
    protected function parseRequest()
    {
        return true;
    }

    /**
     * Called before $this->action
     */
    protected function beforeAction()
    {
        return true;
    }

    /**
     * Called after $this->action
     */
    protected function afterAction()
    {
        return true;
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
