<?php

namespace Ultra\UltraLogManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for the UltraLogManager
 *
 * This facade exposes a rich logging API to route logs across custom channels,
 * append class/method context, and fallback gracefully in production environments.
 *
 * @method static void log(string $level, string $type, string $message, array $context = [], ?string $channel = null, bool $debug = false)
 * @method static void info(string $type, string $message, array $context = [], ?string $channel = null)
 * @method static void warning(string $type, string $message, array $context = [], ?string $channel = null)
 * @method static void error(string $type, string $message, array $context = [], ?string $channel = null)
 * @method static void debug(string $category, string $message, array $context = [])
 * @method static void critical(string $category, string $message, array $context = [])
 * 
 * @see \Ultra\UltraLogManager\UltraLogManager
 */
class UltraLog extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'ultralogmanager';
    }

    /**
     * Log a message with the given level and context.
     *
     * @param string $level   Log level (info, error, warning, debug, etc.)
     * @param string $type    Logical operation or category of the log
     * @param string $message Descriptive message to log
     * @param array $context  Additional context to include
     * @param string|null $channel Optional log channel override
     * @param bool $debug     If true, forces logging even in production
     * @return void
     */
    public static function log(string $level, string $type, string $message, array $context = [], ?string $channel = null, bool $debug = false): void
    {
        static::getFacadeRoot()->log($level, $type, $message, $context, $channel, $debug);
    }

    public static function info(string $type, string $message, array $context = [], ?string $channel = null): void
    {
        static::getFacadeRoot()->info($type, $message, $context, $channel);
    }

    public static function warning(string $type, string $message, array $context = [], ?string $channel = null): void
    {
        static::getFacadeRoot()->warning($type, $message, $context, $channel);
    }

    public static function error(string $type, string $message, array $context = [], ?string $channel = null): void
    {
        static::getFacadeRoot()->error($type, $message, $context, $channel);
    }

    public static function debug(string $category, string $message, array $context = []): void
    {
        static::getFacadeRoot()->debug($category, $message, $context);
    }

    public static function critical(string $category, string $message, array $context = []): void
    {
        static::getFacadeRoot()->critical($category, $message, $context);
    }
}
