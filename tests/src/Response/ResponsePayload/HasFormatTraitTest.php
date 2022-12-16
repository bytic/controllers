<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests\Response\ResponsePayload;

use Nip\Controllers\Response\ResponsePayload;
use Nip\Controllers\Tests\AbstractTest;

/**
 * Class HasFormatTraitTest.
 */
class HasFormatTraitTest extends AbstractTest
{
    public function testGetFormat()
    {
        $payload = new ResponsePayload();

        self::assertNull($payload->getFormat());
    }

    public function testGetFormatWithDefaultFormat()
    {
        $payload = new ResponsePayload();
        $payload->withDefaultFormat('html');

        self::assertSame('html', $payload->getFormat());
    }
}
