<?php

namespace Nip\Controllers\Response;

/**
 * Class ResponsePayload
 * @package Nip\Controllers\Response
 */
class ResponsePayload
{
    use ResponsePayload\HasDataTrait;
    use ResponsePayload\HasFormatTrait;

    /**
     * ResponsePayload constructor.
     */
    public function __construct()
    {
        $this->initData();
    }
}
