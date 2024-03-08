<?php

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\NoReturn;
use src\Models\Product;
use src\Services\Parser;
use src\Services\XmlParser;

require_once 'vendor/autoload.php';

initCustomErrorHandling();
run();


function run(): void
{
    $params = setParams();

    $parser = new Parser(new XmlParser());
    $parser->read($params['file']);
    unset($params['file']);
    $result = [
        'success' => 0,
        'failed' => 0,
        'total' => 0
    ];

    $product = new Product($params);
    $total_items = $parser->getData()->count();
    foreach ($parser->getData()->item as $item) {
        $parsed_data = $parser->parseItem($item);
        $product->createFromArray($parsed_data);

        $saved = $product->save();

        $saved ? $result['success']++ : $result['failed']++;
        $result['total']++;

        updateProgressBar($result['total'], $total_items);
    }

    echoStatistics($result);
}

function echoStatistics($result): void
{
    echo PHP_EOL . "Completed - Overview:" . PHP_EOL;
    echo "Total: " . $result['total'] . PHP_EOL;
    echo "Success: " . $result['success'] . PHP_EOL;
    echo "Failed: " . $result['failed'] . PHP_EOL;
    echo "Runtime: " . microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"] . "s" . PHP_EOL;
}

function updateProgressBar($progress, $total, $bar_length = 50): void
{
    $progress = max(0, $progress);
    $total = max(1, $total);

    $percent = intval(($progress / $total) * 100);
    $bar = str_repeat("=", intval(($percent / 100) * $bar_length));
    $bar .= ">";
    $bar .= str_repeat(" ", $bar_length - strlen($bar) + 1);

    echo "\r[$bar] $percent% Completed";
}

function initCustomErrorHandling(): void
{
    $log_config = parse_ini_file("config.ini", true)['Logs']['error'];

    set_error_handler(function ($errno, $error_str, $error_file, $error_line) use ($log_config) {
        customErrorHandler($errno, $error_str, $error_file, $error_line, $log_config);
    });

    set_exception_handler(function ($exception) use ($log_config) {
        customExceptionHandler($exception, $log_config);
    });
}

#[NoReturn] function customErrorHandler($errno, $error_str, $error_file, $error_line, $error_log): void
{
    $timestamp = date("Y-m-d H:i:s");
    $error_message = "[$timestamp] Error: [$errno] $error_str in $error_file on line $error_line" . PHP_EOL;
    error_log($error_message, 3, $error_log);
    exit("\nAn error occurred. Please check the logs.\n");
}

#[NoReturn] function customExceptionHandler($exception, $error_log): void
{
    $timestamp = date("Y-m-d H:i:s");
    $error_message = "[$timestamp] Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine() . PHP_EOL;
    error_log($error_message, 3, $error_log);
    exit("\nAn exception occurred. Please check the logs.\n");
}

/**
 * @throws Exception
 */
#[ArrayShape(['file' => "mixed", 'user' => "mixed", 'password' => "mixed", 'host' => "mixed", 'Database' => "mixed"])] function setParams(): array
{
    $params = getopt("f:u:p:h:D:", ["file:", "user:", "password:", "host:", "Database:", "help"]);

    if (isset($params['help'])) {
        displayHelp();
        exit;
    }

    $config = parse_ini_file("config.ini", true);
    $final_params = [
        'file' => $params['file'] ?? $params['f'] ?? $config['File']['path'] ?? null,
        'user' => $params['user'] ?? $params['u'] ?? $config['Database']['user'] ?? null,
        'password' => $params['password'] ?? $params['p'] ?? $config['Database']['password'] ?? null,
        'host' => $params['host'] ?? $params['h'] ?? $config['Database']['host'] ?? null,
        'Database' => $params['Database'] ?? $params['D'] ?? $config['Database']['dbname'] ?? null,
    ];

    foreach ($final_params as $k => $v) {
        if (is_null($v)) {
            exit('Parameter \'' . $k . '\' has not been provided and cannot be found in the default config!' . PHP_EOL);
        }
    }

    return $final_params;
}

function displayHelp(): void
{
    echo "Usage: php script.php" . PHP_EOL;
    echo "  -f, --file              Overwrite the configs file path (optional)" . PHP_EOL;
    echo "  -u, --user              Overwrite the configs database user (optional)" . PHP_EOL;
    echo "  -p, --password          Overwrite the configs database password (optional)" . PHP_EOL;
    echo "  -h, --host              Overwrite the configs database host (optional)" . PHP_EOL;
    echo "  -D, --Database          Overwrite the configs name (optional)" . PHP_EOL;
    echo "  --help                  Display this help message" . PHP_EOL;
}