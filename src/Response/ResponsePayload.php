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
    use ResponsePayload\HasHeadersTrait;

    /**
     * ResponsePayload constructor.
     */
    public function __construct()
    {
        $this->initData();
        $this->initHeaders();
    }
}
