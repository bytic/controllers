<?php

namespace Nip\Controllers\Tests\Response\ResponsePayload;

use Nip\Controllers\Response\ResponsePayload;
use Nip\Controllers\Tests\AbstractTest;

/**
 * Class HasFormatTraitTest
 * @package Nip\Controllers\Tests\Response\ResponsePayload
 */
class HasFormatTraitTest extends AbstractTest
{
    public function test_getFormat()
    {
        $payload = new ResponsePayload();

        self::assertSame(null, $payload->getFormat());
    }

    public function test_getFormat_withDefaultFormat()
    {
        $payload = new ResponsePayload();
        $payload->withDefaultFormat('html');

        self::assertSame('html', $payload->getFormat());
    }
}
