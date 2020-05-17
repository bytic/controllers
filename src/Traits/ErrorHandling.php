<?php

namespace Nip\Controllers\Traits;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Trait ErrorHandling
 * @package Nip\Controllers\Traits
 */
trait ErrorHandling
{
    protected function dispatchAccessDeniedResponse()
    {
        throw $this->createAccessDeniedException();
    }

    protected function dispatchNotFoundResponse()
    {
        throw $this->createNotFoundException();
    }

    /**
     * Returns a NotFoundHttpException.
     *
     * This will result in a 404 response code. Usage example:
     *
     *     throw $this->createNotFoundException('Page not found!');
     */
    protected function createNotFoundException(
        string $message = 'Not Found',
        \Throwable $previous = null
    ): NotFoundHttpException {
        return new NotFoundHttpException($message, $previous);
    }

    /**
     * Returns an AccessDeniedException.
     *
     * This will result in a 403 response code. Usage example:
     *
     *     throw $this->createAccessDeniedException('Unable to access this page!');
     *
     * @throws \LogicException If the Security component is not available
     */
    protected function createAccessDeniedException(
        string $message = 'Access Denied.',
        \Throwable $previous = null
    ): AccessDeniedException {
        if (!class_exists(AccessDeniedException::class)) {
            throw new \LogicException('You can not use the "createAccessDeniedException" method if the Security component is not available. Try running "composer require symfony/security-bundle".');
        }

        return new AccessDeniedException($message, $previous);
    }
}
