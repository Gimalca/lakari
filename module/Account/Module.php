<?php
namespace Account;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Account\Form\RegisterForm;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $this->initRegister($e);
        
    }
    
    protected function initRegister($e)
    {
        $viewModel = $e->getViewModel();
        $viewModel->registerForm= new RegisterForm();
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
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Mailer' => function ($sm) {
                    $config = $sm->get('Config');      
                    //print_r($config);die;
                    $transport = new Smtp();
                    $transport->setOptions(new SmtpOptions($config['mail']['transport']['options']));
                    return $transport;
                },
                                  
            )
        );
    }
}
