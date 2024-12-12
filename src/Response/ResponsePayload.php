<?php

declare(strict_types=1);

namespace Nip\Controllers\Response;

/**
 * Class ResponsePayload.
 */
class ResponsePayload implements \ArrayAccess
{
    use ResponsePayload\Traits\HasDataTrait;
    use ResponsePayload\Traits\HasFormatTrait;
    use ResponsePayload\Traits\HasHeadersTrait;
    public const REQUEST_PARAM_FORMAT = '_format';

    /**
     * ResponsePayload constructor.
     */
    public function __construct()
    {
        $this->initData();
        $this->initHeaders();
    }
}
