<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 17/07/2017
 * Time: 19:13
 */

namespace SON\Service;


use Silex\Application;

class InjectorController
{
    private $interfaces = [];
    private $app;

    /**
     * InjectorController constructor.
     * @param $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    public function inject($controller){
        foreach ($this->interfaces as $service => $interface){
            if($controller instanceof $interface){
                $interfaceRef = new \ReflectionClass($interface);
                $methods = $interfaceRef->getMethods();
                /** @var \ReflectionMethod $method */
                foreach ($methods as $method){
                    if(strpos('Injector',$method->getName())!=-1){
                        $controller->{$method->getName()}($this->app[$service]);
                    }
                }
            }
        }
    }

    public function addInterface($key, $interface){
        $this->interfaces[$key] = $interface;
        return $this;
    }
}