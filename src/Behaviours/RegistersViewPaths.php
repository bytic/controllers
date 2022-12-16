<?php

declare(strict_types=1);

namespace Nip\Controllers\Behaviours;

use Nip\View\View;

interface RegistersViewPaths
{
    public function registerViewPaths(View $view): void;
}
