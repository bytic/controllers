<?php

declare(strict_types=1);

namespace Nip\Controllers\Events;

/**
 * Trait HasLifecycleTrait.
 */
trait HasLifecycleTrait
{
    /**
     * @var StageCallbacks[]
     */
    protected $stages = [];

    protected function on(string $stage, callable $callback)
    {
        $this->stage($stage)->add($callback);
    }

    /**
     * @param \Closure $callback
     */
    protected function onParseRequest(callable $callback)
    {
        $this->on('parseRequest', $callback);
    }

    /**
     * @param \Closure $callback
     */
    protected function before(callable $callback)
    {
        $this->on('beforeAction', $callback);
    }

    /**
     * @param \Closure $callback
     */
    protected function after(callable $callback)
    {
        $this->on('afterAction', $callback);
    }

    protected function invokeStage(string $stage)
    {
        if (method_exists($this, $stage)) {
            $this->{$stage}();
        }
        $this->stage($stage)->run();
    }

    /**
     * @param string $name
     *
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
     * @return StageCallbacks
     */
    protected function generateStage($name)
    {
        return new StageCallbacks();
    }
}
