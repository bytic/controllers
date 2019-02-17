<?php

namespace Nip\Controllers\Tests\Fixtures;

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

    public function afterAction()
    {
        $this->getResponse()->headers->set('afterAction', 'value');
    }
}
