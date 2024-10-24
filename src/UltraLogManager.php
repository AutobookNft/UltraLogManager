<?php

namespace Fabio\UltraLogManager;

use Fabio\PerfectConfigManager\ConfigManager;
use Illuminate\Support\Facades\Log;

/**
 * Class UltraLogManager
 *
 * Provides a convenient interface to manage logs across different channels,
 * with consistent formatting and support for various logging levels.
 *
 * @package Fabio\UltraLogManager
 */
class UltraLogManager
{
    /**
     * Log a message to the given channel at the desired level.
     *
     * @param string $channel The log channel to use.
     * @param string $level The level of the log (e.g., 'info', 'debug', 'error').
     * @param string $message The message to log.
     * @param array $context Additional context information.
     * @return void
     */
    public static function log(string $channel, string $level, string $message, array $context = []): void
    {
        // Set up log parameters in a structured way
        $encodedLogParams = json_encode([
            'Class' => 'UltraLogManager',
            'Level' => $level,
        ]);

        // Append encoded parameters to the context to keep structure consistent
        $context['encoded_log_params'] = $encodedLogParams;

        // Log to the specified channel with the provided level
        Log::channel($channel)->{$level}($message, $context);
    }

    /**
     * Log an informational message.
     *
     * @param string $message The message to log.
     * @param array $context Additional context information.
     * @return void
     */
    public static function info(string $message, array $context = []): void
    {
        $channel = ConfigManager::getConfig('log_channel', 'log_manager');
        self::log($channel, 'info', $message, $context);
    }

    /**
     * Log a debug message.
     *
     * @param string $message The message to log.
     * @param array $context Additional context information.
     * @return void
     */
    public static function debug(string $message, array $context = []): void
    {
        $channel = ConfigManager::getConfig('log_channel', 'log_manager');
        self::log($channel, 'debug', $message, $context);
    }

    /**
     * Log an error message.
     *
     * @param string $message The message to log.
     * @param array $context Additional context information.
     * @return void
     */
    public static function error(string $message, array $context = []): void
    {
        $channel = ConfigManager::getConfig('log_channel', 'log_manager');
        self::log($channel, 'error', $message, $context);
    }

    /**
     * Set log parameters for detailed structured logging.
     *
     * @param string $class The class where the log originates.
     * @param string $method The method where the log originates.
     * @return array
     */
    public static function setLogParams(string $class, string $method): array
    {
        return [
            'Class' => $class,
            'Method' => $method,
            'Timestamp' => now()->toDateTimeString(),
        ];
    }
}
