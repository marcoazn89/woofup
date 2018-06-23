<?php
namespace Roadbot\Libraries\Authentication;

class OAuth2Middleware extends Oauth2
{
    /**
     * Method used for the middleware layer in Slim
     * @param  \Psr\Http\Message\ServerRequestInterface $request  Request object
     * @param  \Psr\Http\Message\ResponseInterface      $response Response object
     * @param  Callable                                 $next     The next method to call
     * @return \Psr\Http\Message\ResponseInterface                The response object
     */
    public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, $next)
    {
        // If authentication failed
        if ($this->validateToken($request, $response)) {
            // Authentication suceeded, call next method
            return $next($request, $response);
        }
    }
}
