<?php

declare(strict_types=1);

namespace Nip\Controllers\Traits;

use Nip\Config\ConfigAwareTrait;
use Nip\Controllers\Events\HasLifecycleTrait;

/**
 * Trait BaseControllerTrait.
 */
trait BaseControllerTrait
{
    use ActionCallTrait;
    use ConfigAwareTrait;
    use DispatcherAwareTrait;
    use ErrorHandling;
    use HasHelpersTrait;
    use HasLifecycleTrait;
    use HasResponseTrait;
    use HttpsTrait;
    use NameWorksTrait;
    use RedirectTrait;
    use RequestAwareTrait;
}
