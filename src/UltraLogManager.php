<?php

namespace Fabio\UltraLogManager;

use Illuminate\Support\Facades\Log;
use Fabio\PerfectConfigManager\ConfigManager;
use Throwable;

class UltraLogManager
{
    protected static string $routeChannel;

    /**
     * Initialize log channel using ConfigManager.
     *
     * @return void
     */
    private static function initialize(): void
    {
        try {
            // Retrieve the log channel from the config using ConfigManager
            self::$routeChannel = ConfigManager::getConfig('log_channel', 'error_manager');
        } catch (Throwable $e) {
            // Fall back to a default channel if ConfigManager fails
            self::$routeChannel = 'stack';
        }
    }

    /**
     * Log a message.
     *
     * @param string $level The log level (info, error, warning, etc.)
     * @param string $type The action being logged
     * @param string $message The message to log
     * @param array $context Additional context information to log
     * @return void
     */
    public static function log(string $level, string $type, string $message, array $context = []): void
    {
        // Initialize log channel
        self::initialize();

        // Get the calling class and method
        [$callerClass, $callerMethod] = self::getCallerContext();
        $context['Class'] = $callerClass;
        $context['Method'] = $callerMethod;
        $context['Type'] = $type;
        $context['Message'] = $message;

        // Create log with specified channel or fall back to 'stack'
        try {
            Log::channel(self::$routeChannel)->{$level}('', $context);
        } catch (Throwable $e) {
            // If the channel is invalid, use Laravel's default channel
            Log::channel('stack')->{$level}('', array_merge($context, [
                'FallbackChannel' => true, // Indication that fallback channel was used
            ]));
        }
    }

    /**
     * Get the calling class and method.
     *
     * @return array
     */
    private static function getCallerContext(): array
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5);

        // Traverse the backtrace to find the actual calling context, skipping facades and this logger itself
        foreach ($backtrace as $trace) {
            if (isset($trace['class']) && !str_contains($trace['class'], 'Facade') && $trace['class'] !== self::class) {
                return [
                    $trace['class'] ?? 'UnknownClass',
                    $trace['function'] ?? 'UnknownMethod',
                ];
            }
        }

        // Fallback in case the correct caller could not be identified
        return ['UnknownClass', 'UnknownMethod'];
    }
}
