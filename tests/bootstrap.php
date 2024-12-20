<?php

declare(strict_types=1);

use Nip\Container\Container;

require dirname(__DIR__) . '/vendor/autoload.php';

define('PROJECT_BASE_PATH', __DIR__ . '/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__ . \DIRECTORY_SEPARATOR . 'fixtures');

Container::setInstance(new Container());

Container::getInstance()->share(
    'dispatcher',
    new \Nip\Dispatcher\Dispatcher()
);
