<?php

declare(strict_types=1);

namespace Nip\Controllers\Response\ResponsePayload\Traits;

/**
 * Trait HasFormatTrait.
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

    public function withFormat(?string $format): void
    {
        $this->format = $format;
    }

    /**
     * @return ?string
     */
    public function getFormat(): ?string
    {
        return $this->format ?? $this->defaultFormat;
    }
}
