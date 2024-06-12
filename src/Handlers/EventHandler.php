<?php

namespace Cleup\Components\Events\Handlers;

use Cleup\Components\Events\Models\ListenerModel;

class EventHandler
{

    /**
     * Use Developer Mode
     * 
     * @var bool $devMode
     */
    private static $devMode = true;

    /**
     * The place where event data is stored
     * 
     * @var array
     */
    protected static $store = array();

    /**
     * If the event exists
     * 
     * @param string - Event name
     * 
     * @return bool
     */
    public static function is($name)
    {
        return !!isset(static::$store[$name]);
    }

    /**
     * Add a new event
     * 
     * @param string                  $name     - Event name
     * @param array|string|callable   $callback - Intercept a callback
     * 
     * @return ListenerModel
     */
    public static function add($name, $callback)
    {
        return new ListenerModel($name, $callback);
    }

    /**
     * Delete event
     * 
     * @param string     $name - Event name
     * @param string|int $id   - The callback ID
     */
    public static function delete($name, $id = 0)
    {
        if (static::is($name)) {
            if ($id) {
                foreach (static::get($name) as $key => $scheme) {
                    if (!empty($scheme['id']) && $scheme['id'] == $id) {
                        if (!empty(static::$store[$name][$key])) {
                            unset(static::$store[$name][$key]);
                        }
                    }
                }
            } else
                unset(static::$store[$name]);
        }
    }

    /**
     * Register event
     * 
     * @param string                $name     - Event name
     * @param array|string|callable $callback - Intercept a callback
     * @param int                   $position - Callback position
     * @param bool                  $once     - Execute once
     * @param int|string            $id       - Callback ID
     */
    public static function register($name, $callback, $position = 0, $once = false, $id = 0)
    {
        if (!static::is($name))
            static::$store[$name] = array();

        $eventScheme = array(
            'id' => $id,
            'once' => $once,
            'eventName' => $name,
            'callback' => $callback,
            'position' => $position
        );

        if ($position != 0) {
            $num = static::calcPosition($name, $position);
            static::$store[$name][$num] = $eventScheme;
        } else
            array_push(static::$store[$name], $eventScheme);
    }

    /**
     * Apply event
     * 
     * @param string $name - Event name
     * @param mixed  $keys - Any variable keys
     * 
     * @return bool
     */
    public static function apply($name, &...$keys)
    {
        if (!static::is($name))
            return false;

        foreach (static::get($name, true) as $key => $scheme) {
            if (!empty($scheme['callback'])) {
                if ($keys)
                    $scheme['callback'](...$keys);
                else
                    $scheme['callback']();

                if (!empty($scheme['once']) && !empty(static::$store[$name][$key]))
                    unset(static::$store[$name][$key]);
            }
        }

        return true;
    }

    /**
     * Get the event schema
     * 
     * @param string $name - Event name
     * @param bool   $sort - Sort according to the positions
     * 
     * @return array
     */
    public static function get($name, $sort = false)
    {
        if (!static::is($name))
            return array();

        $eventData = static::$store[$name];

        if ($sort)
            ksort($eventData);

        return $eventData;
    }

    /**
     * Calculation of callback positions
     * 
     * @param string $name - Event name
     * @param int    $position
     * 
     * @return int
     */
    private static function calcPosition($name, $position = 0)
    {
        if (isset(static::$store[$name][$position])) {
            $position++;
            $position = static::calcPosition($position);
        }

        return $position;
    }

    /**
     * Set the developer mode
     * 
     * @param bool - Event name
     */
    protected static function setDevMode($status)
    {
        static::$devMode = !!$status;
    }

    /**
     * Get Developer Mode status
     * 
     * @param bool - Event name
     * 
     * @return bool
     */
    public static function isDev()
    {
        return !!static::$devMode;
    }
}
