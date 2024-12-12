<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests\Events;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\Controllers\BaseControllerWithEvents;

/**
 * Class HasLifecycleTraitTest.
 */
class HasLifecycleTraitTest extends AbstractTest
{
    public function testOnParseRequest()
    {
        $controller = new BaseControllerWithEvents();
        $controller->invokeStageTest('parseRequest');

        self::assertSame(2, $controller->eventsTest['parseRequest']);
    }
}
