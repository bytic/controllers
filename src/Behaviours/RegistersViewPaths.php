<?php

namespace Nip\Controllers\Behaviours;

use Nip\View\View;

interface RegistersViewPaths
{
    public function registerViewPaths(View $view): void;
}