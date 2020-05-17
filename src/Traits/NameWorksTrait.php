<?php

namespace Nip\Controllers\Traits;

use Nip\Utility\Traits\NameWorksTrait as UtilityNameWorksTrait;

/**
 * Trait NameWorksTrait
 * @package Nip\Controllers\Traits
 */
trait NameWorksTrait
{
    protected $fullName = null;

    protected $name = null;

    use UtilityNameWorksTrait;

//    protected function inflectName()
//    {
//        $name = str_replace("Controller", "", get_class($this));
//        $this->name = inflector()->unclassify($name);
//    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return str_replace("Controller", "", get_class($this));
    }


    /**
     * @return string
     */
    public function getName()
    {
        if ($this->name === null) {
            $this->initName();
        }

        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function initName()
    {
        $this->setName($this->generateName());
    }

    /**
     * @return mixed
     */
    protected function generateName()
    {
        return $this->getRequest()->getControllerName();
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        if ($this->fullName === null) {
            $this->fullName = inflector()->unclassify($this->getClassName());
        }

        return $this->fullName;
    }
}
