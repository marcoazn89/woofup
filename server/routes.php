<?php
use Messenger\{WebhookService, GraphApi};
use Messenger\Objects\{Recipient, Message, QuickReply, Button, Template, Element, Text, Location, Image};

/**
 * Post credentials and get authorization token
 * - test catching errors for full flexibility
 * - test for user defined errors...allow users to replace oauth2exception or templates
 */

$app->any('/', function () {
    die("Welcome to the Roadbotapp API!");
});

// verification of webhook
$app->get('/webhook/fb[/]', function ($request, $response, $args) {
    $this->logger->debug('FB Webhook Verify: ' . json_encode($request->getParams()));

    if ($request->getParam('hub_mode') === 'subscribe'
        && $request->getParam('hub_verify_token') === getenv('FB_VERIFY_TOKEN')) {
        $this->logger->debug('Verification succeded');
        return $response->write($request->getParam('hub_challenge'))->withStatus(200);
    } else {
        $this->logger->critical('Verification failed');
        return $response->withStatus(403);
    }
});

// actual stuff
//$app->post('/webhook/fb[/]', 'facebookctrl:handleEvents');

$app->post('/webhook/fb[/]', 'facebookctrl:handleEvents');