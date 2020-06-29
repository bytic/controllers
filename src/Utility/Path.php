<?php

namespace Nip\Controllers\Utility;

/**
 * Class Path
 * @package Nip\Controllers\Utility
 */
class Path
{
    /**
     * @param $controller
     * @return bool|string
     * @noinspection PhpDocMissingThrowsInspection
     */
    public static function basePath($controller)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $reflection = new \ReflectionClass($controller);
        $path = dirname($reflection->getFileName());
        $parts = explode(DIRECTORY_SEPARATOR, $path);
        while (count($parts) > 1) {
            $lastPart = end($parts);
            if (strtolower($lastPart) == 'controllers') {
                return implode(DIRECTORY_SEPARATOR, $parts);
            }
            array_pop($parts);
        }
        return false;
    }
}
