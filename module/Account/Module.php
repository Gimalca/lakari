<?php
namespace Account;

use Account\Form\LoginForm;
use Account\Form\RegisterForm;
use Account\Model\LoginAccount;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $this->initRegister($e);
    }
    
    public function init(ModuleManager $moduleManager) 
    {
        $events = $moduleManager->getEventManager();
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach(array(__NAMESPACE__, 'Application','Account'), 'dispatch', array($this, 'initAuth'), 100);
    }
    
    public function initAuth(MvcEvent $e)
    {
        
        $app = $e->getApplication();
        $routerMatch = $e->getRouteMatch();
        $controller = $routerMatch->getParam('controller');
        $action = $routerMatch->getParam('action');
       
        $sm = $app->getServiceManager();
        $auth = $sm->get('Account\Model\LoginAccount');
        
       
        if($controller === 'Account\Controller\Index' && !$auth->isLoggedIn()){       
            $controller = $e->getTarget();
            return $controller->redirect()->toRoute('account', array('controller' => 'register', 'action' => 'add'));
        }
        
        
        if($auth->isLoggedIn()){
            
            $viewModel = $e->getViewModel();
            $viewModel->userIdentity = $auth->getIdentity();
            
        }
    }
    
    protected function initRegister($e)
    {
        $viewModel = $e->getViewModel();
        $viewModel->registerForm= new RegisterForm();
    }
    
        protected function initLogin($e)
    {
        $viewModel = $e->getViewModel();
        $viewModel->loginForm= new LoginForm();
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
                'Account\Model\LoginAccount' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new LoginAccount($dbAdapter);
                }               
            )
        );
    }
}
