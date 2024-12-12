<?php

declare(strict_types=1);

namespace Nip\Controllers\Utility;

/**
 * Class Path.
 */
class Path
{
    /**
     * @return bool|string
     *
     * @noinspection PhpDocMissingThrowsInspection
     */
    public static function basePath($controller)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $reflection = new \ReflectionClass($controller);
        $path = \dirname($reflection->getFileName());
        $parts = explode(\DIRECTORY_SEPARATOR, $path);
        while (\count($parts) > 1) {
            $lastPart = end($parts);
            if ('controllers' == strtolower($lastPart)) {
                return implode(\DIRECTORY_SEPARATOR, $parts);
            }
            array_pop($parts);
        }

        return false;
    }
}
