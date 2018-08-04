<?php

namespace alash3al\tix;

/**
 * Tix
 *
 * A very tiny event loop that emulates node.js main loop
 */
final class Tix extends \stdClass
{
    const RESOLUTION=200000;
    private $queue;
    private $shutdown = false;

    /**
     *  Constructor
     */
    public function __construct() {
        $this->queue = new \SplQueue;
        $this->shutdown = false;
    }

    public function isActive() {
        return ($this->shutdown == false);
    }

    /**
     *  Push a new function into the main loop
     *
     * @param   \Closure  $fn
     * @return  void
     */
    public function push(\Closure $fn): void {
        $this->queue->enqueue($fn);
    }

    /**
     * Run a php file within scope
     *
     * @param   string  $filename
     * @return  void
     */
    public function loadScript($filename): void {
        ((function() {
            require($filename);
            return $this;
        })->bindTo($this))();
    }

    /**
     * Exit from script
     */
    public function exit() {
        $this->shutdown = true;
        // empty the queue
        while(!$this->queue->isEmpty()) {
            $this->queue->pop();
        }
    }

    /**
     * Loop
     *
     * @return void
     */
    public function loop(): void {
        while ( $this->shutdown == false ) {
            while (! $this->queue->isEmpty()) {
                (($this->queue->pop())->bindTo($this))();
            }
            usleep(self::RESOLUTION);
        }
    }
}
