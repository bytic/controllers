<?php

declare(strict_types=1);

namespace Nip\Controllers\Traits;

use Nip\Utility\Traits\NameWorksTrait as UtilityNameWorksTrait;

/**
 * Trait NameWorksTrait.
 */
trait NameWorksTrait
{
    use UtilityNameWorksTrait;
    protected $fullName = null;

    protected $name = null;

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
        return str_replace('Controller', '', static::class);
    }

    /**
     * @return string
     */
    public function getName()
    {
        if (null === $this->name) {
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
        if ($this->hasRequest()) {
            return $this->getRequest()->getControllerName();
        }
        $class = $this->getClassFirstName();

        return str_replace('Controller', '', $class);
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        if (null === $this->fullName) {
            $this->fullName = inflector()->unclassify($this->getClassName());
        }

        return $this->fullName;
    }
}
