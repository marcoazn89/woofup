<?php
use ChatFlow\{StateManager, State, StateRepositoryInterface};
use Messenger\Objects\{Message, Recipient, Text, QuickReply, Template, Element, DefaultAction, Interfaces\Receivable};

/**
 * Dependencies
 *
 * Add the app dependencies here.
 *
 * $app is the Slim 3 applicarettion. Check the links for documentation
 * Slim 2:  http://www.slimframework.com/
 * Slim 3:  http://docs-new.slimframework.com/
 *          http://dev.slimframework.com/
 * Github:  https://github.com/slimphp/Slim/tree/develop/Slim
 * Slides:
 *                  https://secure.newmediacampaigns.com/slim/nomadphp/slim3-nomadphp-presentation.pdf
 *                  http://www.slideshare.net/vvaswani/creating-rest-applications-with-the-slim-microframework
 *
 * DIC configuration
 * $container is a container built on top of Pimple. Check the links for documentation.
 *
 * Pimple:
 *                  website:    http://pimple.sensiolabs.org/
 *                  github:     https://github.com/silexphp/Pimple
 *                  Examples:
 *                                      -   Lazy loading slim controllers using Pimple: http://nesbot.com/2012/11/5/lazy-loading-slim-controllers-using-pimple
 *                                      -   Dependency Injection with Pimple:   http://www.sitepoint.com/dependency-injection-with-pimple/
 */

// Get the container
$container = $app->getContainer();

/**
 * Authentication
 * The class that deals with authentication
 */

$container->register(new Woofup\Libraries\ServiceProviders\LoggingServiceProvider());

$container->register(new Woofup\Libraries\ServiceProviders\SecurityServiceProvider());

$container->register(new Woofup\Libraries\ServiceProviders\StorageServiceProvider());

/**
 * Client
 * Object that contains information about the client's browser
 *
 * @link https://github.com/WhichBrowser/WhichBrowser
 */
$container['client'] = function () {
    return new WhichBrowser\Parser(getallheaders());
};

/**
 *  HTTP Response
 *  This overrides Slim's response object
 *  http-wrapper:
 *  @link https://github.com/marcoazn89/http-wrapper/tree/dev
 */
$container['response'] = function ($c) {
    return new HTTP\Response();
};

$container['http-client'] = function () {
    return new GuzzleHttp\Client();
};

$container['profileCtrl'] = function($c) {
    return new Woofup\Controllers\ProfileCtrl($c['logger']);
};

/**==
 * Common
 * All the common methods used by the system
 *
$container['common'] = function($c) use ($app) {
    return new Woofup\Libraries\Common($app);
};

$container['token'] = function ($c) {
    return new Woofup\Controllers\Token($c);
};
	
$container['fbwebhook'] = function ($c) {
	return new Messenger\WebhookService();
};

$container['graphapi'] = function ($c) {
	return new Messenger\GraphApi($c['http-client'], [
		'api' => getenv('FB_GRAPH_API'),
        'version' => getenv('FB_GRAPH_VERSION'),
        'token' => getenv('FB_PAGE_ACCESS_TOKEN')
	]);
};*/