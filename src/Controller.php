<?php

namespace Nip\Controllers;

use Nip\Controllers\Traits\BaseControllerTrait;

/**
 * Class Controller
 * @package Nip
 */
class Controller
{
    use BaseControllerTrait;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
//        $this->inflectName();
    }

    /**
     * @param $name
     * @param $arguments
     * @return bool|mixed
     */
    public function __call($name, $arguments)
    {
        if ($name === ucfirst($name)) {
            return $this->getHelper($name);
        }

        return trigger_error("Call to undefined method [$name] in controller [{$this->getClassName()}]", E_USER_ERROR);
    }



    /**
     * @return string
     */
    public function getRootNamespace()
    {
        return $this->getApplication()->getRootNamespace();
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return app('app');
    }
}
