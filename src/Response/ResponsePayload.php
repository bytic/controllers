<?php

declare(strict_types=1);

namespace Nip\Controllers\Response;

use ArrayAccess;

/**
 * Class ResponsePayload
 * @package Nip\Controllers\Response
 */
class ResponsePayload implements ArrayAccess
{
    public const REQUEST_PARAM_FORMAT = '_format';

    use ResponsePayload\Traits\HasDataTrait;
    use ResponsePayload\Traits\HasFormatTrait;
    use ResponsePayload\Traits\HasHeadersTrait;

    /**
     * ResponsePayload constructor.
     */
    public function __construct()
    {
        $this->initData();
        $this->initHeaders();
    }
}
