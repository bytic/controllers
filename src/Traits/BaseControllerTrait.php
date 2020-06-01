<?php

namespace Nip\Controllers\Traits;

use Nip\Config\ConfigAwareTrait;
use Nip\Controllers\Events\HasLifecycleTrait;

/**
 * Trait BaseControllerTrait
 * @package Nip\Controllers\Trait
 */
trait BaseControllerTrait
{
    use NameWorksTrait;
    use HasHelpersTrait;
    use HasResponseTrait;
    use ConfigAwareTrait;
    use RequestAwareTrait;
    use ActionCallTrait;
    use HasLifecycleTrait;
    use DispatcherAwareTrait;
    use ErrorHandling;
    use RedirectTrait;
    use HttpsTrait;
}
