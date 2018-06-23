<?php
/**
* Middlewares
* More info:   http://docs-new.slimframework.com/concepts/middleware/
*              http://www.sitepoint.com/working-with-slim-middleware/
*/

// Log everything!
$app->add(function($request, $response, $next) use ($app) {
    \Exception\BooBoo::addVars([
        'requestParams'     =>  $request->getParams()
    ]);


    // Call the next middleware
    return $next($request, $response);
});

$app->add(new \SlimBooboo\Middleware(
    $app,
    $settings['errorTemplates']['default'],
    $app->getContainer()['logger'],
    true
));
