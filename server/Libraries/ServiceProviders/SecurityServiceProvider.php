<?php
namespace Roadbot\Libraries\ServiceProviders;

use \Roadbot\Libraries\Repositories\AuthRepository;
use \OAuth2Password\OAuth2;
use \RouteProtection\Guard;

class SecurityServiceProvider implements \Pimple\ServiceProviderInterface
{
    public function register(\Pimple\Container $container)
    {

        $container['authRepository'] = function ($c) {
            return new AuthRepository($c['mysql']);
        };

        $container['oauth2'] = function ($c) {
            return new OAuth2($c['authRepository'], $c['settings']['auth']);
        };

        $container['guard'] = function ($c) {
            return new Guard($c['request'], $c['settings']['auth-routes']);
        };
    }
}
