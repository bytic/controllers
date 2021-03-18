<?php

namespace Nip\Controllers\Events;

use Bytic\Scheduler\Runner\Invoker;
use Closure;

/**
 * Class StageCallbacks
 * @package Nip\Controllers\Lifecycle
 */
class StageCallbacks
{
    /**
     * The array of callbacks to be run
     *
     * @var array
     */
    protected $callbacks = [];

    /**
     * Register a callback to be called before the operation.
     *
     * @param Closure $callback
     * @return $this
     */
    public function add(callable $callback)
    {
        $this->callbacks[] = $callback;
        return $this;
    }

    /**
     * @return string
     */
    public function run()
    {
        $output = '';
        foreach ($this->callbacks as $callback) {
//            /** @var Closure $callback */
//            if ($callback instanceof Closure) {
//                $callback = Closure::bind($callback, $this);
//            }
            // Invoke the callback with buffering enabled
            $output .= \call_user_func_array($callback, []);
        }
        return $output;
    }
}
