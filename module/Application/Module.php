<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
//Adicionales Pakage
use Zend\Config\Reader\Ini;
use Zend\Validator\AbstractValidator;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        //Inicializaciones 
//         $this->initConfig($e);
//         $this->initViewRender($e);
//         $this->initEnviroment($e);

        $app = $e->getApplication()->getEventManager();
        $app->attach('dispatch', array($this, 'initLayout'), -100);
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
        );
    }

    //Adicionales

    protected function initConfig($e)
    {
        $application = $e->getApplication();
        $services = $application->getServiceManager();
        $services->setFactory('ConfigIni', function ($services) {
            $reader = new Ini();
            $data = $reader->fromFile(__DIR__ . '/config/config.ini');
            return $data;
        });
    }

    protected function initViewRender($e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $viewRender = $sm->get('ViewManager')->getRenderer();
        $config = $sm->get('ConfigIni');

        $viewRender->headTitle($config['params']['titulo']);
    }

    public function initLayout($e)
    {
//        $matches = $e->getRouteMatch();
//        $module = $matches->getParams();
        $routeMatchParams = array();
       
        $routeMatchParams = $e->getRouteMatch()->getParams();

        (!isset($routeMatchParams['__NAMESPACE__'])) ? $routeMatchParams['__NAMESPACE__'] = "Application\Controller" :  NULL ;
        $moduleName = substr($routeMatchParams['__NAMESPACE__'], 0, strpos($routeMatchParams['__NAMESPACE__'], '\\'));
        $controllerName = str_replace('\\Controller\\', '/', $routeMatchParams['controller']);
        $actionName = $routeMatchParams['action'];

        $config = $e->getApplication()->getServiceManager()->get('config');
        $controller = $e->getTarget();

        if (isset($config['module_layouts'][$moduleName])) {
            $controller->layout($config['module_layouts'][$moduleName]);
        }
        if (isset($config['controller_layouts'][$controllerName])) {
            $controller->layout($config['controller_layouts'][$controllerName]);
        }
        if (isset($config['action_layouts'][$controllerName . '/' . $actionName])) {
            $controller->layout($config['action_layouts'][$controllerName . '/' . $actionName]);
        }

        
//        if ($matches->getParam('__NAMESPACE__') == 'Admin\Controller') {
//            $layout = $e->getViewModel();
//            $layout->setTemplate('layout/admin');
//        }
//        if ($module['controller'] == 'Admin\Controller\Login') {
//            $layout = $e->getViewModel();
//            $layout->setTemplate('layout/layout');
//        }
    }

    protected function initEnviroment($e)
    {

        error_reporting(E_ALL | E_STRICT);
        ini_set("display_errors", TRUE);

        $application = $e->getApplication();
        $config = $application->getServiceManager()->get('ConfigIni');

        $timeZone = (string) $config['params']['timezone'];

        if (empty($timeZone)) {
            $timeZone = 'America/Caracas';
        }
        date_default_timezone_set($timeZone);

        //Translator Formulario
        $serviceManager = $e->getApplication()->getServiceManager();
        $translator = $serviceManager->get('translator');

        $locale = $config['application']['locale'];
        $translator->setLocale(\Locale::acceptFromHttp($locale));
        $translator->addTranslationFile(
                'phpArray', __DIR__ . '/language/formValidator/es.php', 'default', 'es_ES'
        );
        AbstractValidator::setDefaultTranslator($translator);
    }

}
