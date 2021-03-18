<?php

namespace Nip\Controllers\Events;

use Closure;

/**
 * Trait HasLifecycleTrait
 * @package Nip\Controllers\Traits
 */
trait HasLifecycleTrait
{
    /**
     * @var StageCallbacks[]
     */
    protected $stages = [];

    /**
     * @param $stage
     * @param callable $callback
     */
    protected function on(string $stage, callable $callback)
    {
        $this->stage($stage)->add($callback);
    }

    /**
     * @param Closure $callback
     */
    protected function onParseRequest(callable $callback)
    {
        $this->on('parseRequest', $callback);
    }

    /**
     * @param Closure $callback
     */
    protected function before(callable $callback)
    {
        $this->on('beforeAction', $callback);
    }

    /**
     * @param Closure $callback
     */
    protected function after(callable $callback)
    {
        $this->on('afterAction', $callback);
    }

    /**
     * @param string $stage
     */
    protected function invokeStage(string $stage)
    {
        if (method_exists($this, $stage)) {
            $this->{$stage}();
        }
        $this->stage($stage)->run();
    }

    /**
     * @param string $name
     * @return StageCallbacks
     */
    protected function stage($name)
    {
        if (!isset($this->stages[$name])) {
            $this->stages[$name] = $this->generateStage($name);
        }
        return $this->stages[$name];
    }

    /**
     * @param $name
     * @return StageCallbacks
     */
    protected function generateStage($name)
    {
        return new StageCallbacks();
    }
}
