<?php

namespace Nip\Controllers\Tests\Fixtures\Controllers;

use Nip\Controllers\Traits\BaseControllerTrait;

/**
 * Class BaseControllerWithUtilityMethods
 * @package Nip\Controllers\Tests\Fixtures
 */
class BaseControllerWithUtilityMethods
{
    use BaseControllerTrait;

    public function beforeAction()
    {
        $this->getResponse(true)->headers->set('beforeAction', 'value');
    }

    public function index()
    {
    }

    /**
     * @param string $name
     * @return string
     */
    public function hello($name = '')
    {
        return 'hello'
            .(!empty($name) ? ' '.$name : '');
    }

    public function afterAction()
    {
        $this->getResponse()->headers->set('afterAction', 'value');
    }
}
