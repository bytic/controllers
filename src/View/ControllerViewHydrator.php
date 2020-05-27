<?php

namespace Nip\Controllers\View;

use Nip\Controllers\Controller;
use Nip\Http\Request;

/**
 * Class ControllerViewHydrator
 * @package Nip\Controllers\View
 */
class ControllerViewHydrator
{

    /**
     * @param $view
     * @param null $controller
     * @return mixed
     */
    public static function initContentBlocks($view, $controller = null)
    {
        $request = static::detectRequest($controller);
        $view->setBlock(
            'content',
            $controller->getName() . '/' . $controller->getAction()
        );

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
     */
    public static function populatePath($view, $controller = null)
    {
        if (method_exists($controller, 'generateViewPath')) {
            $view->setBasePath($controller->generateViewPath());
            return $view;
        }

        if (!defined('MODULES_PATH')) {
            return $view;
        }
        $request = static::detectRequest($controller);
        if (!($request instanceof Request)) {
            return $view;
        }

        $path = MODULES_PATH . $request->getModuleName() . '/views/';
        if (!is_dir($path)) {
            return $view;
        }
        $view->setBasePath(MODULES_PATH . $request->getModuleName() . '/views/');

        return $view;
    }

    /**
     * @param null|Controller $controller
     */
    protected static function detectRequest($controller = null)
    {
        if ($controller instanceof Controller && $controller->hasRequest()) {
            return $controller->getRequest();
        }
        $request = function_exists('request')? request() : null;
        if ($request instanceof Request) {
            return $request;
        }
        return null;
    }
}