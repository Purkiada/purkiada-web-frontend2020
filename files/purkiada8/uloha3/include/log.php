<?php

function add_to_log($text, $logFilePath = null) {
    if ($logFilePath == null) $logFilePath = __DIR__ . '/../log/main.log';
    file_put_contents($logFilePath, date('Y-m-d H:i:s') . ' -> ' . $text . "\n", FILE_APPEND);
}

function overrideErrorHandler() {
    set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
        // error was suppressed with the @-operator
        if (0 === error_reporting()) {
            return false;
        }

        $exception = new ErrorException($errstr, 0, $errno, $errfile, $errline);
        add_to_log($exception->__toString());

        return true;
    });
    set_exception_handler(function ($exception) {
        add_to_log($exception->__toString());
    });
}

function restoreErrorHandler() {
    restore_exception_handler();
    restore_error_handler();
}
