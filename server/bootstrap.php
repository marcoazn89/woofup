<?php
/**
 * Bootstrap
 *
 * Assemble the app here.
 */
require __DIR__ .'/../vendor/autoload.php';
// This will go away after done testing
//require __DIR__ . '/../messenger-api/vendor/autoload.php';
// This will go away after done testing
//require __DIR__ . '/../chat-flow/vendor/autoload.php';

date_default_timezone_set('UTC');

// Use Dotenv to parse the .env file
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');

// Load variables from the .env file and overload existing
// environment variables if they overlap
$dotenv->overload();


$settings = require __DIR__ .'/config.php';

// Create a new instance of the Slim application and pass
// the loaded settings
$app = new \Slim\App(['settings' => $settings]);

// Register dependencies
require __DIR__ .'/dependencies.php';

// Register middlewares
require __DIR__ .'/middlewares.php';

// Register routes
require __DIR__ .'/routes.php';

return $app;

// EOF
