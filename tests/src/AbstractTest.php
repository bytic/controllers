<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest.
 */
abstract class AbstractTest extends TestCase
{
    protected $object;

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }
}
