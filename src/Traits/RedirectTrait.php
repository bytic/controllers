<?php

namespace Nip\Controllers\Traits;

use Nip_Flash_Messages as FlashMessages;

/**
 * Trait NameWorksTrait
 * @package Nip\Controllers\Traits
 */
trait RedirectTrait
{

    /**
     * @param $message
     * @param $url
     * @param string $type
     * @param bool   $name
     */
    protected function flashRedirect($message, $url, $type = 'success', $name = false)
    {
        $name = $name ? $name : $this->getName();
        FlashMessages::instance()->add($name, $type, $message);
        $this->redirect($url);
    }

    /**
     * @param $url
     * @param null $code
     */
    protected function redirect($url, $code = null)
    {
        switch ($code) {
            case '301':
                header("HTTP/1.1 301 Moved Permanently");
                break;
        }
        header("Location: ".$url);
        exit();
    }
}
