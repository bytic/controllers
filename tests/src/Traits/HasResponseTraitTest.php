<?php

namespace Nip\Controllers\Tests\Traits;

use Nip\Controllers\Tests\AbstractTest;
use Nip\Controllers\Tests\Fixtures\Controllers\BaseController;
use Nip\Controllers\Tests\Fixtures\Controllers\ViewController;
use Nip\Http\Response\JsonResponse;
use Nip\Http\Response\Response;

/**
 * Class HasResponseTraitTest
 * @package Nip\Controllers\Tests\Traits
 */
class HasResponseTraitTest extends AbstractTest
{
    public function test_newResponse()
    {
        $controller = new ViewController();
        $controller->setName('base');
        $controller->payload()->withDefaultFormat('view');

        /** @var Response $response */
        $response = $controller->callAction('index');

        self::assertInstanceOf(Response::class, $response);

        $content = $response->getContent();
        self::assertStringContainsString('BASE-INDEX-CONTENT', $content);
    }

    public function test_payload_set()
    {
        $controller = new BaseController();
        $controller->setName('base');
        $controller->payload()->withDefaultFormat('json');
        $controller->payload()->set('var1', 1);
        $controller->payload()['var2'] = 2;
        $controller->payload()->with(['var3' => 3, 'var4' => 4]);
        $controller->payload()->with('var5', 5);

        $response = $controller->getResponse(true);
        self::assertInstanceOf(JsonResponse::class, $response);

        $content = $response->getContent();
        self::assertStringContainsString('{"var1":1,"var2":2,"var3":3,"var4":4,"var5":5}', $content);
    }
}
