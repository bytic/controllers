<?php

declare(strict_types=1);

namespace Nip\Controllers;

use Nip\Controllers\Traits\BaseControllerTrait;
use Nip\Utility\Traits\CanBootTraitsTrait;

/**
 * Class Controller.
 */
class Controller
{
    use BaseControllerTrait;
    use CanBootTraitsTrait;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->bootTraits();
//        $this->inflectName();
    }

    /**
     * @return bool|mixed
     */
    public function __call($name, $arguments)
    {
        if ($name === ucfirst($name)) {
            return $this->getHelper($name);
        }

        return trigger_error("Call to undefined method [$name] in controller [{$this->getClassName()}]", \E_USER_ERROR);
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
