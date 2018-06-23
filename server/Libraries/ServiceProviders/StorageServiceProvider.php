<?php
namespace Roadbot\Libraries\ServiceProviders;

class StorageServiceProvider implements \Pimple\ServiceProviderInterface
{
    public function register(\Pimple\Container $container)
    {
        /**
         * MySQL
         * This mysql implementation is the one used in laravel. Check the links for documentation.
         * Laravel:
         *          website:  http://laravel.com/docs/5.1/database
         *          github:   https://github.com/illuminate/database
         */
        $container['mysql'] = function() use ($container) {
              // Laravel's capsule to use DB stuff outside of laravel
              $capsule = new \Illuminate\Database\Capsule\Manager;

              // MySQL connection
              $capsule->addConnection($container['settings']['database']['mysql'], 'mysql');

              $capsule->bootEloquent();

              // Return the connection for mysql
              return $capsule->getConnection('mysql');
        };
    }
}
