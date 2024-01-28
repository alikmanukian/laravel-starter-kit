<?php

declare(strict_types=1);

namespace App\Logging;

use Monolog\Handler\TelegramBotHandler;
use Monolog\LogRecord;

class TelegramLogger extends TelegramBotHandler
{
    protected function write(LogRecord $record): void
    {
        // reformat the message to be sent to Telegram
        $msg = $record->formatted;

        $msg .= PHP_EOL .
            $this->getEnv() .
            $this->getProject() .
            $this->getUrl() .
            $this->getUser() .
            $this->getIp() .
            $this->getLine();

        $this->send($msg);
    }

    private function getUrl(): string
    {
        return request() ? "URL: " . request()?->fullUrl() . PHP_EOL : '';
    }

    private function getEnv(): string
    {
        return "ENV: " . config('app.env') . PHP_EOL;
    }

    private function getProject(): string
    {
        return "PROJECT: " . config('app.name') . PHP_EOL;
    }

    private function getUser(): string
    {
        return auth()->user() ? "USER_ID: " . auth()->id() . PHP_EOL : '';
    }

    private function getIp(): string
    {
        return request() ? "IP: " . request()?->ip() . PHP_EOL : '';
    }

    private function getLine(): string
    {
        $trace = debug_backtrace();
        $caller = $trace[7];
        $file = $caller['file'];
        $lineNumber = $caller['line'];

        return "Line: {$file}:{$lineNumber}";
    }
}
