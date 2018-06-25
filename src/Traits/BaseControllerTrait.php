<?php

namespace Nip\Controllers\Traits;

use Nip\Config\ConfigAwareTrait;
use Nip\Http\Response\ResponseAwareTrait;

/**
 * Trait BaseControllerTrait
 * @package Nip\Controllers\Trait
 */
trait BaseControllerTrait
{
    use NameWorksTrait;
    use HasHelpersTrait;
    use ResponseAwareTrait;
    use ConfigAwareTrait;
    use RequestAwareTrait;
    use ActionCallTrait;
    use DispatcherAwareTrait;
    use RedirectTrait;
}
