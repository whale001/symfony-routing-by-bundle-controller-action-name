<?php
#file: Acme\EventListener\DynamicRouterListener.php

namespace Option4Bundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class DynamicRouterListener extends RouterListener
{
    /**
     * @var RouteCollection
     */
    protected $routes;
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $router = $this->container->get('router');
        $this->routes = $router->getRouteCollection();
        parent::__construct(
            new UrlMatcher($this->routes, new RequestContext())
        );
    }

    protected function loadRoutes($path_info)
    {

        if ($logic_name = $this->verifyRoute($path_info)) {
            $route = str_replace([':', 'bundle'], ['/', ''], strtolower($logic_name));
            $this->routes->add($route, new Route($route, array(
                '_controller'   =>  $logic_name,
            )));
            return true;
        }
        return false;
    }

    public function verifyBundle($bundle) {
        return $bundle === 'option4';
    }

    public function verifyRoute($path_info) {
        $path_info = substr($path_info, 1);
        $path_info_arr = explode('/', $path_info);
        if (count($path_info_arr) !== 3) {
            return false;
        }
        list($bundle, $controller, $action) = $path_info_arr;
        if (!$this->verifyBundle($bundle)) {
            return false;
        }
        $ucfirst_bundle = ucfirst($bundle);
        $ucfirst_controller = ucfirst($controller);
        $class_name = "{$ucfirst_bundle}Bundle\\Controller\\{$ucfirst_controller}Controller";
        if (is_a($class_name, 'Symfony\Bundle\FrameworkBundle\Controller\Controller', true)
            && in_array("{$action}Action", get_class_methods($class_name), true)) {
            return "{$ucfirst_bundle}Bundle:$controller:$action";
        }
        return false;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->loadRoutes($event->getRequest()->getPathInfo());
        parent::onKernelRequest($event);
    }
}