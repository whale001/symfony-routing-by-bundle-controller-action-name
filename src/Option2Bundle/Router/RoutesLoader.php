<?php
/**
 * Created by PhpStorm.
 * User: Whale
 * Date: 16.07.2016
 * Time: 23:18
 */

namespace Option2Bundle\Router;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RoutesLoader implements LoaderInterface
{
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    /**
     * @var boolean
     *
     * Route is loaded
     */
    private $loaded = false;

    /**
     * Loads a resource.
     *
     * @param mixed  $resource The resource
     * @param string $type     The resource type
     *
     * @return RouteCollection
     *
     * @throws \RuntimeException Loader is added twice
     */
    public function load($resource, $type = null)
    {
        if ($this->loaded) {
            throw new \RuntimeException('Already loaded');
        }
        $routes = new RouteCollection();
        $logic_names = $this->getLogicActionNames();
        foreach ($logic_names as $logic_name) {
            $route = str_replace([':', 'bundle'], ['/', ''], strtolower($logic_name));
            $routes->add($route, new Route($route, array(
                '_controller'   =>  $logic_name,
            )));
        }

        $this->loaded = true;
        return $routes;
    }

    /**
     * remove this, only for demonstration
     */
    private function validateBundle($bundle) {
        return in_array($bundle, ['Option2Bundle', 'Option2case2Bundle'], true);
    }

    private function getLogicActionNames() {
        $logic_names = [];
        $path = $this->container->get('kernel')->getRootDir() . "/../src/";
        foreach (new \DirectoryIterator($path) as $bundle) {
            if ($bundle->isDir() && strpos($bundle->getFilename(), 'Bundle') !== false && $this->validateBundle($bundle->getFilename())) {
                $controller_dir_path = $path . $bundle->getFilename() . '/Controller/';
                if (is_dir($controller_dir_path)) {
                    $logic_names = array_merge($logic_names, $this->parseControllerDir($bundle->getFilename(), $controller_dir_path));
                }
            }
        }
        return $logic_names;
    }

    private function parseControllerDir($bundle, $controller_dir_path) {
        $logic_names = [];
        foreach (new \DirectoryIterator($controller_dir_path) as $controller) {
            if ($controller->isFile() && strpos($controller, 'Controller') !== false) {
                $controller_name = str_replace('.php', '', $controller->getFilename());
                $class_name = "$bundle\\Controller\\$controller_name";
                foreach (get_class_methods($class_name) as $method) {
                    if (strpos($method, 'Action') !== false) {
                        $controller_logic_name = str_replace('Controller', '', $controller_name);
                        $method_logic_name = str_replace('Action', '', $method);
                        $logic_names[] = "$bundle:$controller_logic_name:$method_logic_name";
                    }
                }
            }
        }
        return $logic_names;
    }

    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return boolean This class supports the given resource
     */
    public function supports($resource, $type = null)
    {
        return 'option2' === $type;
    }

    /**
     * Gets the loader resolver.
     *
     * @return LoaderResolverInterface A LoaderResolverInterface instance
     */
    public function getResolver()
    {
    }

    /**
     * Sets the loader resolver.
     *
     * @param LoaderResolverInterface $resolver A LoaderResolverInterface
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
    }
}
