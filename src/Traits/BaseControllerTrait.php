<?php

namespace Nip\Controllers\Traits;

use Nip\Config\ConfigAwareTrait;

/**
 * Trait BaseControllerTrait
 * @package Nip\Controllers\Trait
 */
trait BaseControllerTrait
{
    use NameWorksTrait;
    use HasHelpersTrait;
    use HasViewTrait;
    use HasResponseTrait;
    use ConfigAwareTrait;
    use RequestAwareTrait;
    use ActionCallTrait;
    use DispatcherAwareTrait;
    use ErrorHandling;
    use RedirectTrait;
    use HttpsTrait;
}
