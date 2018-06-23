<?php
/**
 * Post credentials and get authorization token
 * - test catching errors for full flexibility
 * - test for user defined errors...allow users to replace oauth2exception or templates
 */

$app->any('/', function () {
    die("Welcome to the Woofup API!!");
});

// actual stuff
//$app->post('/webhook/fb[/]', 'facebookctrl:handleEvents');

$app->get('/profile[/]', 'profileCtrl:getProfile');