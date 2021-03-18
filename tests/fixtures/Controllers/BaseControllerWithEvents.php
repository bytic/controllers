<?php

namespace Nip\Controllers\Tests\Fixtures\Controllers;

use Nip\Controllers\Controller;

/**
 * Class BaseControllerWithEvents
 * @package Nip\Controllers\Tests\Fixtures
 */
class BaseControllerWithEvents extends Controller
{
    public $eventsTest = [];

    public function __construct()
    {
        parent:: __construct();
        $this->onParseRequest([$this, 'checkParseRequest']);
        $this->onParseRequest(function () {
            $this->eventsTest['parseRequest']++;
        });
    }

    public function invokeStageTest(string $stage)
    {
        $this->invokeStage($stage);
    }

    public function checkParseRequest()
    {
        $this->eventsTest['parseRequest'] = 1;
    }

    public function index()
    {
        return 'index';
    }

    /**
     * @return string
     */
    public function generateViewPath()
    {
        return dirname(__DIR__) . '/views';
    }
}
