<?php

declare(strict_types=1);

namespace Nip\Controllers\Traits;

use Nip\Config\Config;
use Nip\Http\Response\Response;
use Nip\Records\RecordManager;
use Nip\Request;
use Nip\View;

/**
 * Trait AbstractControllerTrait.
 */
trait AbstractControllerTrait
{
    /**
     * @param bool $autoInit
     *
     * @return Response
     */
    abstract public function getResponse($autoInit = false);

    /**
     * @param bool $autoInit
     *
     * @return Request
     */
    abstract public function getRequest($autoInit = false);

    /**
     * Return Config Object.
     *
     * @return Config
     */
    abstract public function getConfig();

    /**
     * @return View
     */
    abstract public function getView();

    /**
     * @return string
     */
    abstract public function getAction();

    /**
     * @return RecordManager
     */
//    abstract public function getModelManager();

    /**
     * @param null $code
     *
     * @return mixed
     */
    abstract protected function redirect($url, $code = null);

    /**
     * @param string $type
     * @param bool   $name
     *
     * @return mixed
     */
    abstract protected function flashRedirect($message, $url, $type = 'success', $name = false);
}
