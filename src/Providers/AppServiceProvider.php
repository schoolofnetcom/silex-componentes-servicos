<?php

namespace SON\Providers;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AppServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['injector'] = function() use($pimple){
            $injector = new \SON\Service\InjectorController($pimple);
            foreach ($pimple['injector.interfaces'] as $service => $interface){
                $injector->addInterface($service,$interface);
            }
            return $injector;
        };

        $pimple['posts.controller'] = function() use($pimple){
            $controller = new \SON\Controllers\PostsController();
            $pimple['injector']->inject($controller);
            return $controller;
        };
    }

    public function registerServices($pimple){

    }

    public function registerControllers($pimple){

    }
}