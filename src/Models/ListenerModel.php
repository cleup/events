<?php

namespace Cleup\Components\Events\Models;

use Cleup\Components\Events\Handlers\EventHandler;
use Exception;

class ListenerModel
{
    /**
     * Event name
     * 
     * @var string
     */
    private $name;

    /**
     * Event callback
     * 
     * @var string|array|callable
     */
    private $callback;

    /**
     * Callback position
     * 
     * @var int
     */
    private $position = 0;

    /**
     * Use once
     * 
     * @var bool
     */
    private $once = false;

    /**
     * Callback ID
     * 
     * @var int|string
     */
    private $id;

    public function __construct($name, $callback)
    {
        $this->callback = $callback;
        $this->name = $name;
    }

    /**
     * Event registration
     */
    public function __destruct()
    {
        EventHandler::register(
            $this->name,
            $this->callback,
            $this->position,
            $this->once,
            $this->id
        );
    }

    /**
     * Use once
     * 
     * @return ListenerModel
     */
    public function once(): ListenerModel
    {
        $this->once = true;

        return $this;
    }

    /**
     * Set callback execution position
     * 
     * @param int $postion
     * 
     * @return ListenerModel
     */
    public function position($position = 0): ListenerModel
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Set callback ID
     * 
     * @param int|string $id
     * 
     * @return ListenerModel
     */
    public function id($id): ListenerModel
    {
        $this->id = $id;

        return $this;
    }

    public function __call($name, $arguments)
    {
        if (EventHandler::isDev())
            throw new Exception("Invalid '{$name}' method in the '" . static::class . "' class.");
    }
}
