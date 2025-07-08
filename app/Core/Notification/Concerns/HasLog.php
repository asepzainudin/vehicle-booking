<?php

namespace App\Core\Notification\Concerns;

use Throwable;

trait HasLog
{
    /**
     * @param  Throwable  $throw
     * @param  string|null  $title
     *
     * @return void
     */
    public function logThrow(Throwable $throw, string|null $title = null): void
    {
        self::logError($title, [], $throw);
    }

    /**
     * @param  string  $title
     * @param  array  $extra
     *
     * @return void
     */
    public static function logEmergency(string $title = 'notif log', array $extra = []): void
    {
        self::addLog($title, $extra, 'emergency');
    }

    /**
     * @param  string  $title
     * @param  array  $extra
     *
     * @return void
     */
    public static function logAlert(string $title = 'notif log', array $extra = []): void
    {
        self::addLog($title, $extra, 'alert');
    }

    /**
     * @param  string  $title
     * @param  array  $extra
     *
     * @return void
     */
    public static function logCritical(string $title = 'notif log', array $extra = []): void
    {
        self::addLog($title, $extra, 'critical');
    }

    /**
     * @param  string  $title
     * @param  array  $extra
     * @param  Throwable|null  $throw
     *
     * @return void
     */
    public static function logError(string $title = 'notif log', array $extra = [], Throwable|null $throw = null): void
    {
        self::addLog($title, $extra, 'error', $throw);
    }

    /**
     * @param  string  $title
     * @param  array  $extra
     *
     * @return void
     */
    public static function logWarning(string $title = 'notif log', array $extra = []): void
    {
        self::addLog($title, $extra, 'warning');
    }

    /**
     * @param  string  $title
     * @param  array  $extra
     *
     * @return void
     */
    public static function logNotice(string $title = 'notif log', array $extra = []): void
    {
        self::addLog($title, $extra, 'notice');
    }

    /**
     * @param  string  $title
     * @param  array  $extra
     *
     * @return void
     */
    public static function logInfo(string $title = 'notif log', array $extra = []): void
    {
        self::addLog($title, $extra, 'info');
    }

    /**
     * @param  string  $title
     * @param  array  $extra
     * @param  Throwable|null  $throw
     *
     * @return void
     */
    public static function logDebug(string $title = 'notif log', array $extra = [], Throwable|null $throw = null): void
    {
        self::addLog($title, $extra, 'debug', $throw);
    }

    /**
     * @param  string  $title
     * @param  array  $extra
     * @param  string  $type
     * @param  Throwable|null  $throw
     *
     * @return void
     */
    private static function addLog(
        string $title = 'notif log',
        array $extra = [],
        string $type = 'info',
        Throwable|null $throw = null
    ): void {
        $context = $extra;
        if ($throw instanceof Throwable) {
            $context = array_merge($context, [
                'code' => $throw->getCode(),
                'message' => $throw->getMessage(),
                'traces' => explode(PHP_EOL, $throw->getTraceAsString()),
            ]);
        }

        $type = self::validateLogType($type);

        app('notifLog')->{$type}($title, $context);
    }

    private static function validateLogType(string $type): string
    {
        $validTypes = [
            'emergency',
            'alert',
            'critical',
            'error',
            'warning',
            'notice',
            'info',
            'debug',
        ];

        return in_array($type, $validTypes) ? $type : 'info';
    }
}
