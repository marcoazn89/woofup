<?php
namespace ParkAlong\Controllers\Interfaces;

abstract class Controller
{
    protected $app;

    /**
    * Create an instance of a Controller
    *
    * Using the servie locator pattern here it's okay because it's at the business logic level
    *
    * @param \Interop\Container\ContainerInterface\ $container  An instance of the container interface
    */
    public function __construct(\Interop\Container\ContainerInterface $container)
    {
        $this->app = $container;
    }
}
