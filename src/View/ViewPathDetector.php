<?php

namespace Nip\Controllers\View;

use Nip\Controllers\Utility\Path;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class ViewPathDetector
 * @package Nip\Controllers\View
 */
class ViewPathDetector
{
    use SingletonTrait;

    /**
     * @var array
     */
    protected $paths = [];

    /**
     * ViewPathDetector constructor.
     */
    public function __construct()
    {
        $this->initFromCache();
    }

    /**
     * @param $controller
     * @return bool
     */
    public static function for($controller)
    {
        return static::instance()->detectForController($controller);
    }

    /**
     * @param $controller
     * @return bool
     */
    protected function detectForController($controller)
    {
        $key = $this->keyForController($controller);
        if (!isset($this->paths[$key])) {
            $this->paths[$key] = $this->generateForController($controller);
        }

        return $this->paths[$key];
    }

    /**
     * @param $controller
     * @return false|string
     */
    protected function keyForController($controller)
    {
        return get_class($controller);
    }

    /**
     * @param $controller
     * @return bool|string
     */
    protected function generateForController($controller)
    {
        if (method_exists($controller, 'generateViewPath')) {
            return $controller->generateViewPath();
        }

        if (defined('MODULES_PATH')) {
            $path = MODULES_PATH . request()->getModuleName() . '/views/';
            if (is_dir($path)) {
                return $path;
            }
        }

        return $this->generateForControllerAutodetect($controller);
    }

    /**
     * @param $controller
     * @return bool|string
     */
    protected function generateForControllerAutodetect($controller)
    {
        $path = dirname(Path::basePath($controller));
        $path .= DIRECTORY_SEPARATOR . 'views';
        if (is_dir($path)) {
            return $path;
        }
        return false;
    }

    protected function initFromCache()
    {
//        $this->paths;
    }
}
