<?php

declare(strict_types=1);

namespace Nip\Controllers;

use Nip\Http\Response\JsonResponse;
use Nip\Http\Response\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * AbstractController provides Symfony-compatible methods while extending the base Controller.
 *
 * This class maintains backwards compatibility with the existing Controller class
 * while adding Symfony-style methods to facilitate migration to Symfony patterns.
 */
abstract class AbstractController extends Controller
{
    /**
     * Returns a JsonResponse that uses the serializer component if enabled, or json_encode.
     *
     * @param mixed $data    The response data
     * @param int   $status  The HTTP status code (200 "OK" by default)
     * @param array $headers An array of response headers
     * @param array $context Options normalizers/encoders have access to
     *
     * @return JsonResponse
     */
    protected function json(
        mixed $data,
        int $status = 200,
        array $headers = [],
        array $context = []
    ): JsonResponse {
        return $this->getResponseFactory()->json($data, $status, $headers);
    }

    /**
     * Renders a view and returns a Response object.
     *
     * @param string        $view       The view name
     * @param array         $parameters An array of parameters to pass to the view
     * @param Response|null $response   A response instance
     *
     * @return Response
     */
    protected function render(
        string $view,
        array $parameters = [],
        ?Response $response = null
    ): Response {
        $response = $response ?? new Response();

        // Set view parameters on payload
        $this->payload()->with($parameters);

        // Load the view content
        $content = $this->renderView($view, $parameters);

        $response->setContent($content);

        return $response;
    }

    /**
     * Renders a view and returns the rendered content as a string.
     *
     * @param string $view       The view name
     * @param array  $parameters An array of parameters to pass to the view
     *
     * @return string
     */
    protected function renderView(string $view, array $parameters = []): string
    {
        // Set view parameters
        $viewObj = $this->getView();
        foreach ($parameters as $key => $value) {
            $viewObj->set($key, $value);
        }

        // Load the view and return content
        return $this->loadView(true);
    }

    /**
     * Returns a RedirectResponse to the given URL.
     *
     * @param string $url    The URL to redirect to
     * @param int    $status The HTTP status code (302 "Found" by default)
     *
     * @return RedirectResponse
     */
    protected function redirectResponse(string $url, int $status = 302): RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }

    /**
     * Returns a RedirectResponse to the given route with the given parameters.
     *
     * @param string $route      The name of the route
     * @param array  $parameters An array of parameters
     * @param int    $status     The HTTP status code (302 "Found" by default)
     *
     * @return RedirectResponse
     */
    protected function redirectToRoute(
        string $route,
        array $parameters = [],
        int $status = 302
    ): RedirectResponse {
        $url = $this->generateUrl($route, $parameters);

        return new RedirectResponse($url, $status);
    }

    /**
     * Generates a URL from the given parameters.
     *
     * @param string $route      The name of the route
     * @param array  $parameters An array of parameters
     *
     * @return string The generated URL
     */
    protected function generateUrl(string $route, array $parameters = []): string
    {
        // Check if router service is available
        if (function_exists('app') && app()->has('router')) {
            return app('router')->generate($route, $parameters);
        }

        // Fallback: construct basic URL
        $url = '/' . $route;
        if (!empty($parameters)) {
            $url .= '?' . http_build_query($parameters);
        }

        return $url;
    }

    /**
     * Adds a flash message to the current session for type.
     *
     * @param string $type    The type (e.g., 'success', 'error', 'info')
     * @param mixed  $message The flash message
     *
     * @return void
     */
    protected function addFlash(string $type, mixed $message): void
    {
        if (function_exists('app') && app()->has('flash.messages')) {
            app('flash.messages')->add($this->getName(), $type, $message);
        }
    }

    /**
     * Checks if the attribute is granted against the current authentication token and optionally supplied subject.
     *
     * @param mixed $attribute A single attribute or an array of attributes
     * @param mixed $subject   The subject to secure
     *
     * @return bool
     *
     * @throws \LogicException
     */
    protected function isGranted(mixed $attribute, mixed $subject = null): bool
    {
        if (!function_exists('app') || !app()->has('security.authorization_checker')) {
            throw new \LogicException('Security authorization checker is not available. Register a "security.authorization_checker" service in your application container.');
        }

        return app('security.authorization_checker')->isGranted($attribute, $subject);
    }

    /**
     * Throws an exception unless the attribute is granted against the current authentication token and optionally
     * supplied subject.
     *
     * @param mixed  $attribute A single attribute or an array of attributes
     * @param mixed  $subject   The subject to secure
     * @param string $message   The message passed to the exception
     *
     * @return void
     *
     * @throws AccessDeniedException
     */
    protected function denyAccessUnlessGranted(
        mixed $attribute,
        mixed $subject = null,
        string $message = 'Access Denied.'
    ): void {
        if (!$this->isGranted($attribute, $subject)) {
            $exception = $this->createAccessDeniedException($message);
            // setAttributes and setSubject methods available in Symfony Security 5.0+
            if (method_exists($exception, 'setAttributes')) {
                $exception->setAttributes([$attribute]);
            }
            if (method_exists($exception, 'setSubject')) {
                $exception->setSubject($subject);
            }

            throw $exception;
        }
    }

    /**
     * Get a user from the Security Token Storage.
     *
     * @return mixed|null Returns the user object or null if not authenticated
     *
     * @throws \LogicException If SecurityBundle is not available
     */
    protected function getUser(): mixed
    {
        if (!function_exists('app') || !app()->has('security.token_storage')) {
            throw new \LogicException('Security token storage is not available. Register a "security.token_storage" service in your application container.');
        }

        $token = app('security.token_storage')->getToken();
        if (null === $token) {
            return null;
        }

        return $token->getUser();
    }

    /**
     * Gets a container parameter by its name.
     *
     * @param string $name The parameter name
     *
     * @return array|bool|string|int|float|\UnitEnum|null
     *
     * @throws \LogicException
     */
    protected function getParameter(string $name): array|bool|string|int|float|\UnitEnum|null
    {
        if (function_exists('config')) {
            return config($name);
        }

        if (function_exists('app') && app()->has('config')) {
            return app('config')->get($name);
        }

        throw new \LogicException('Configuration service is not available.');
    }

    /**
     * Returns a BinaryFileResponse object with original or customized file name and disposition header.
     *
     * @param \SplFileInfo|string $file        File object or path to file to be sent as response
     * @param string|null         $fileName    Override the file name
     * @param string              $disposition One of "attachment" or "inline"
     *
     * @return BinaryFileResponse
     */
    protected function file(
        \SplFileInfo|string $file,
        ?string $fileName = null,
        string $disposition = ResponseHeaderBag::DISPOSITION_ATTACHMENT
    ): BinaryFileResponse {
        return $this->getResponseFactory()->file($file, $fileName, $disposition);
    }

    /**
     * Streams a view.
     *
     * @param \Closure            $callback The callback to execute
     * @param int                 $status   The HTTP status code
     * @param array               $headers  An array of response headers
     *
     * @return StreamedResponse
     */
    protected function stream(
        \Closure $callback,
        int $status = 200,
        array $headers = []
    ): StreamedResponse {
        return $this->getResponseFactory()->stream($callback, $status, $headers);
    }

    /**
     * Checks the validity of a CSRF token.
     *
     * @param string      $id    The id used when generating the token
     * @param string|null $token The actual token sent with the request that should be validated
     *
     * @return bool
     *
     * @throws \LogicException
     */
    protected function isCsrfTokenValid(string $id, ?string $token): bool
    {
        if (!function_exists('app') || !app()->has('security.csrf.token_manager')) {
            throw new \LogicException('CSRF protection is not enabled. Register a "security.csrf.token_manager" service in your application container.');
        }

        return app('security.csrf.token_manager')->isTokenValid(
            new \Symfony\Component\Security\Csrf\CsrfToken($id, $token)
        );
    }

    /**
     * Creates and returns a Form instance from the type of the form.
     *
     * @param string $type    The fully qualified class name of the form type
     * @param mixed  $data    The initial data for the form
     * @param array  $options An array of options
     *
     * @return mixed
     *
     * @throws \LogicException
     */
    protected function createForm(string $type, mixed $data = null, array $options = []): mixed
    {
        if (!function_exists('app') || !app()->has('form.factory')) {
            throw new \LogicException('Form factory is not available. Register a "form.factory" service in your application container.');
        }

        return app('form.factory')->create($type, $data, $options);
    }

    /**
     * Creates and returns a form builder instance.
     *
     * @param mixed $data    The initial data for the form
     * @param array $options An array of options
     *
     * @return mixed
     *
     * @throws \LogicException
     */
    protected function createFormBuilder(mixed $data = null, array $options = []): mixed
    {
        if (!function_exists('app') || !app()->has('form.factory')) {
            throw new \LogicException('Form factory is not available. Register a "form.factory" service in your application container.');
        }

        return app('form.factory')->createBuilder(
            \Symfony\Component\Form\Extension\Core\Type\FormType::class,
            $data,
            $options
        );
    }
}
