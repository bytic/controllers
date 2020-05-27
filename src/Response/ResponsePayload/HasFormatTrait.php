<?php

namespace Nip\Controllers\Response\ResponsePayload;

/**
 * Trait HasFormatTrait
 * @package Nip\Controllers\Response\ResponsePayload
 */
trait HasFormatTrait
{

    /**
     * @var string
     */
    protected $defaultFormat = null;

    /**
     * @var string
     */
    protected $format = null;

    public function withDefaultFormat(string $format): self
    {
        $this->defaultFormat = $format;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format ?? $this->defaultFormat;
    }
}