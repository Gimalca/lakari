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
        $matches = $e->getRouteMatch();
        $module = $matches->getParams();
        
       
        //print_r($module);die;
        if ($matches->getParam('__NAMESPACE__') == 'Admin\Controller') {
            $layout = $e->getViewModel();
            $layout->setTemplate('layout/admin');
        }
        if ($module['controller'] == 'Admin\Controller\Login') {
            $layout = $e->getViewModel();
            $layout->setTemplate('layout/layout');
        }
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
//     public function getViewHelperConfig()
//     {
//         return array(
//             'factories' => array(
//                 'myhelper' => function($sm) {
//                     $helper = new View\Helper\MyHelper ;
//                     return $helper;
//                 }
//             )
//         );
//     }

}
