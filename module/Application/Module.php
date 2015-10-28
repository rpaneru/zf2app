<?php
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $res = $e->getApplication()->getServiceManager()->get('headerMenu')->getMenu();
        
        $routeArray = array();
        $i = 0;
        $countOuter = count($res);
        while($i < $countOuter)
        {
            $j = 0;
            $countInner = count($res[$i]);
            while($j < $countInner)
            {
                array_push($routeArray, $res[$i][$j]['route']);
                $j++;
            }
        $i++;
        }
        
        $uri = ltrim($_SERVER["REQUEST_URI"], "/");
        
        if( !in_array($uri, $routeArray) && $uri != '' && $uri != 'auth' )
        {            
            echo 'Not Permitted';
        }
        else
        {
            $eventManager        = $e->getApplication()->getEventManager();
            $moduleRouteListener = new ModuleRouteListener();
            $moduleRouteListener->attach($eventManager);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
            'Zend\Loader\ClassMapAutoloader' => array( __DIR__ . '/autoload_classmap.php'),
        );
    }
}
