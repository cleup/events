<?php

/** 
 * @author Eduard Y, dev@priveted.com, https://priveted.com
 * @version 1.0.1
 * @copyright Copyright (c) 2016-2024, priveted.com
 */

namespace Cleup\Components\Events;

use Cleup\Components\Events\Handlers\EventHandler;

/**
 * @property bool $devMode
 * @property array $store
 * @method static \Cleup\Components\Events\Models\ListenerModel on(string $name, array|string|callable $callback)
 * @method static bool dispatch(string $name, mixed $...$keys)
 * @method static bool is(string $name)
 * @method static void register(string $name, array|string|callable $callback, int $position = 0, bool $once = false)
 * @method static array get(string $name, bool $sort = false)
 * @method void deleteByKey(string $name, int $key)
 * @method int calcPosition(string $name, int $position)
 * @method static int off(string $name, int $id = 0)
 * @method static void devMode(bool $status)
 * @method static bool isDev()
 */

class Event extends EventHandler
{
    /**
     * Component version
     * 
     * @var string 
     */
    public const VERSION = '1.0.1';

    /**
     * Compatibility of the core version of the framework
     * 
     * @var string 
     */
    public const CLEUP_VERSION = '1.0.1';
}
