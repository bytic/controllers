<?php

namespace Nip\Controllers\View;

use Nip\Controllers\Controller;
use Nip\Http\Request;
use Nip\Utility\Container;
use Nip\View\View;

/**
 * Class ControllerViewHydrator
 * @package Nip\Controllers\View
 */
class ControllerViewHydrator
{

    /**
     * @param View $view
     * @param null $controller
     * @return mixed
     */
    public static function initContentBlocks($view, $controller = null)
    {
        $action = inflector()->underscore($controller->getAction());
        $controller = $controller->getName();

        $view->setBlock('content', $controller . '/' . $action);

        return $view;
    }

    /**
     * @param $view
     * @param null|Controller $controller
     * @return mixed
     */
    public static function initVars($view, $controller = null)
    {
        $request = static::detectRequest($controller);
        if (method_exists($view, 'setRequest')) {
            if ($request instanceof Request) {
                $view->setRequest($request);
            }
        }

        $view->set('controller', $controller->getName());
        $view->set('action', $controller->getAction());

        return $view;
    }

    /**
     * @param $view
     * @param void|Controller $controller
     * @return mixed
     */
    public static function populatePath($view, $controller = null)
    {
        $path = ViewPathDetector::for($controller);
        if (is_dir($path)) {
            $view->setBasePath($path);
        }

        return $view;
    }

    /**
     * @param null|Controller $controller
     * @return array|Request|\Nip\Request|string|null
     */
    protected static function detectRequest($controller = null)
    {
        if ($controller instanceof Controller && $controller->hasRequest()) {
            return $controller->getRequest();
        }
        if (function_exists('request') && Container::container()->has('request')) {
            $request = request();
            if ($request instanceof Request) {
                return $request;
            }
        }
        return null;
    }
}
