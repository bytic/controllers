<?php

namespace Nip\Controllers\Tests\Events;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\Controllers\BaseControllerWithEvents;

/**
 * Class HasLifecycleTraitTest
 * @package Nip\Controllers\Tests\Events
 */
class HasLifecycleTraitTest extends AbstractTest
{
    public function test_onParseRequest()
    {
        $controller = new BaseControllerWithEvents();
        $controller->invokeStageTest('parseRequest');

        self::assertSame(2, $controller->eventsTest['parseRequest']);
    }
}
