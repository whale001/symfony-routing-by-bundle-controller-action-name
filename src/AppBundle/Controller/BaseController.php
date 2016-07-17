<?php
/**
 * Created by PhpStorm.
 * User: Whale
 * Date: 16.07.2016
 * Time: 23:36
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseController extends Controller
{
    public function dispatcherAction($bundle = '', $controller = '', $action = '')
    {
        if ($logical_name = $this->verifyRoute($bundle, $controller, $action)) {
            return $this->forward($logical_name, []);
        }
        throw new NotFoundHttpException();
    }

    public function verifyRoute($bundle, $controller, $action) {
        if ($bundle === 'app' && $controller === 'base') {
            return false;
        }
        $ucfirst_bundle = ucfirst($bundle);
        $ucfirst_controller = ucfirst($controller);
        $class_name =  "{$ucfirst_bundle}Bundle\\Controller\\{$ucfirst_controller}Controller";
        if (is_a($class_name, 'Symfony\Bundle\FrameworkBundle\Controller\Controller', true)
        && in_array("{$action}Action", get_class_methods($class_name), true)) {
            return "{$ucfirst_bundle}Bundle:$controller:$action";
        }
        return false;
    }
}