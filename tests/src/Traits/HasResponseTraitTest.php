<?php

namespace Nip\Controllers\Tests\Traits;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\Controllers\BaseController;
use Nip\Http\Response\Response;

/**
 * Class HasResponseTraitTest
 * @package Nip\Controllers\Tests\Traits
 */
class HasResponseTraitTest extends AbstractTest
{
    public function test_newResponse()
    {
        $controller = new BaseController();
        $controller->setName('base');
        $controller->payload()->withDefaultFormat('view');

        /** @var Response $response */
        $response = $controller->callAction('index');
        self::assertInstanceOf(Response::class, $response);

        $content = $response->getContent();
        self::assertStringContainsString('BASE-INDEX-CONTENT', $content);
    }
}
