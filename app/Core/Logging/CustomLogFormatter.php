<?php

namespace App\Core\Logging;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;

class CustomLogFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param \Illuminate\Log\Logger $logger
     *
     * @return void
     */
    public function __invoke(Logger $logger): void
    {
        $line = '====================================================================================================';
        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor(function ($record) {
                $record['extra']['prefix'] = app("request_id");
                $record['extra']['url'] = request()?->url() ?? '';
                return $record;
            });
            $handler->setFormatter(tap(new LineFormatter(
                "[%datetime%] %extra.prefix%.%channel%.%level_name%: [%extra.url%] %message% %context% %extra%\n{$line}\n\n",
                'Y-m-d H:i:s',
                true,
                true
            ), function ($formatter) {
                $formatter->includeStacktraces()->setJsonPrettyPrint(true);
            }));
        }
    }
}
