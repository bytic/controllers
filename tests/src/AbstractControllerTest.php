<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests;

use Nip\Controllers\AbstractController;
use Nip\Http\Response\JsonResponse;
use Nip\Http\Response\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class AbstractControllerTest.
 */
class AbstractControllerTest extends AbstractTest
{
    public function testJsonResponse()
    {
        $controller = new class extends AbstractController {
            public function testAction()
            {
                return $this->json(['status' => 'success', 'data' => 'test']);
            }
        };

        $response = $controller->testAction();

        self::assertInstanceOf(JsonResponse::class, $response);
        $content = $response->getContent();
        self::assertStringContainsString('"status":"success"', $content);
        self::assertStringContainsString('"data":"test"', $content);
    }

    public function testJsonResponseWithCustomStatus()
    {
        $controller = new class extends AbstractController {
            public function testAction()
            {
                return $this->json(['error' => 'not found'], 404);
            }
        };

        $response = $controller->testAction();

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(404, $response->getStatusCode());
    }

    public function testRedirectResponse()
    {
        $controller = new class extends AbstractController {
            public function testAction()
            {
                return $this->redirectResponse('/test-url');
            }
        };

        $response = $controller->testAction();

        self::assertInstanceOf(RedirectResponse::class, $response);
        self::assertEquals('/test-url', $response->getTargetUrl());
        self::assertEquals(302, $response->getStatusCode());
    }

    public function testRedirectResponseWithCustomStatus()
    {
        $controller = new class extends AbstractController {
            public function testAction()
            {
                return $this->redirectResponse('/test-url', 301);
            }
        };

        $response = $controller->testAction();

        self::assertInstanceOf(RedirectResponse::class, $response);
        self::assertEquals(301, $response->getStatusCode());
    }

    public function testCreateNotFoundException()
    {
        $controller = new class extends AbstractController {
            public function testAction()
            {
                throw $this->createNotFoundException('Test not found');
            }
        };

        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);
        $this->expectExceptionMessage('Test not found');

        $controller->testAction();
    }

    public function testCreateAccessDeniedException()
    {
        $controller = new class extends AbstractController {
            public function testAction()
            {
                throw $this->createAccessDeniedException('Access denied test');
            }
        };

        $this->expectException(\Symfony\Component\Security\Core\Exception\AccessDeniedException::class);
        $this->expectExceptionMessage('Access denied test');

        $controller->testAction();
    }

    public function testGenerateUrlBasic()
    {
        $controller = new class extends AbstractController {
            public function testAction()
            {
                return $this->generateUrl('test-route', ['id' => 123]);
            }
        };

        $url = $controller->testAction();

        // Without router service, should fallback to basic URL construction
        self::assertStringContainsString('test-route', $url);
        self::assertStringContainsString('id=123', $url);
    }
}
