<?php

declare(strict_types=1);

namespace Nip\Controllers\Traits;

/**
 * Trait NameWorksTrait.
 */
trait RedirectTrait
{
    /**
     * @param string $type
     * @param bool   $name
     */
    protected function flashRedirect($message, $url, $type = 'success', $name = false)
    {
        $name = $name ?: $this->getName();
        app('flash.messages')->add($name, $type, $message);
        $this->redirect($url);
    }

    /**
     * @param null $code
     */
    protected function redirect($url, $code = null)
    {
        switch ($code) {
            case '301':
                header('HTTP/1.1 301 Moved Permanently');
                break;
        }
        header('Location: ' . $url);
        exit;
    }
}
