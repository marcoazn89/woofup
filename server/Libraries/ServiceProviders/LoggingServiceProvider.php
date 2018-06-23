<?php
namespace Roadbot\Libraries\ServiceProviders;

use Pimple\{ServiceProviderInterface, Container};

/**
 * This sets up logging using the standards specified in http://tools.ietf.org/html/rfc5424
 *
 * Levels:
 *     - DEBUG: Use it for debugging. Will go to the debug file.
 *     - INFO: Use it for debugging. Will go to the debug file.
 *     - NOTICE: Use it for debugging. Will go to the debug file.
 *     - WARNING: Client generated errors. Typically these will result in a 400s error response.
 *                Will go to the client-error file and client-error-detail file. The latter one
 *                will include all the logs that the occured before the error.
 *     - ERROR: Non-fatal system errors (PHP errors). Will go to the error log file.
 *     - CRITICAL: Fatal system errors (PHP errors). Will go to the error, client-error, and client-error-detail files.
 *     - ALERT: Use it for crucial alerts. Will go to the the error, client-error, and client-error-detail files.
 *     - EMERGENCY: Use it for emergencies. Will go to the error, client-error, and client-error-detail files.
 */
class LoggingServiceProvider implements ServiceProviderInterface
{

    public function register(Container $container)
    {
       $container['logger'] = function($c) {
            $logger = new \Monolog\Logger($c['settings']['logs']['name']);

            $formatter = new \Monolog\Formatter\LineFormatter($c['settings']['logs']['format'], null, true);

            // Create a handler for errors
            $errorHandler = new \Monolog\Handler\StreamHandler(
                $c['settings']['logs']['paths']['error'],
                400
            );

            $errorHandler->setFormatter($formatter);

            // Log ERROR or higuer
            $logger->pushHandler($errorHandler);

            // Create a handler for client errors
            $clientErrorHandler = new \Monolog\Handler\StreamHandler(
                $c['settings']['logs']['paths']['client-error'],
                100
            );

            $clientErrorHandler->setFormatter($formatter);

            // Log only WARNING or higuer
            $logger->pushHandler(new \Monolog\Handler\FilterHandler($clientErrorHandler, [
                \Monolog\Logger::WARNING,
                \Monolog\Logger::CRITICAL,
                \Monolog\Logger::ALERT,
                \Monolog\Logger::EMERGENCY
            ]));

            // Create a handler for client errors details
            $clientErrorDetailHandler = new \Monolog\Handler\StreamHandler(
                $c['settings']['logs']['paths']['client-error-detail'],
                100
            );

            $clientErrorDetailHandler->setFormatter($formatter);

            // Log triggered by WARNING or higher but not ERROR
            $logger->pushHandler(new \Monolog\Handler\FingersCrossedHandler($clientErrorDetailHandler, new \Marcoazn89\IgnoreStrategy(\Monolog\Logger::WARNING, [\Monolog\Logger::ERROR])));

            // Create a handler for debugging
            $debugHandler = new \Monolog\Handler\StreamHandler(
                $c['settings']['logs']['paths']['debug'],
                100
            );

            $debugHandler->setFormatter($formatter);

            // Log only DEBUG, INFO, AND NOTICE
            $logger->pushHandler(new \Monolog\Handler\FilterHandler($debugHandler, \Monolog\Logger::DEBUG, \Monolog\Logger::NOTICE));

            return $logger;
        };
    }
}
