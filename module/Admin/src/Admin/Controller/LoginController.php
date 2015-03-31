<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//Adicionales
use Admin\Model\Dao\UsuarioDao;
use Admin\Form\Login as LoginForm;
use Admin\Form\LoginValidator;

class LoginController extends AbstractActionController
{

    private $config;
    private $usuarioDao;
    private $loginForm;

    function __construct($config, UsuarioDao $usuarioDao)
    {
        $this->config = $config;
        $this->usuarioDao = $usuarioDao;
    }

    public function indexAction()
    {
        $this->loginForm = new LoginForm;
        // $email = $this->loginForm->get()
        $this->loginForm->setInputFilter(new LoginValidator());
        
        if ($this->getRequest()->isPost()) {
            
            $postParams = $this->request->getPost();
            $this->loginForm->setData($postParams);
            
            if (!$this->loginForm->isValid()) {
                //$this->loginForm->bind($postParams);
                // Falla la validación; volvemos a generar el formulario 
                $modelView = new ViewModel(array('loginForm' => $this->loginForm));
                //$modelView->setTemplate('admin/login/index');
                return $modelView;
            }
        }

        return new ViewModel(array('loginForm' => $this->loginForm));
    }

    public function autenticarAction()
    {
        $form = $this->getLoginForm();
        $form->setInputFilter(new LoginValidator());

        $postParams = $this->request->getPost();

        $form->setData($postParams);

        if (!$form->isValid()) {
            // Falla la validación; volvemos a generar el formulario 
            $modelView = new ViewModel(array('loginForm' => $this->loginForm));
            $modelView->setTemplate('admin/login/index');
            return $modelView;
        }

        $view = array();
        $email = $this->getRequest()->getPost("email");
        $password = $this->getRequest()->getPost("password");

        //echo $email.' - '.$password;exit();

        $resultado = $this->usuarioDao->aunteticar($email, $password);

//        return new ViewModel(array('listaUsuario' => $resultado,
//            'titulo' => $titulo));
        if ($resultado) {
            $view['login'] = true;
        }
        $view['titulo'] = 'Admin Autenticacion';


        return new ViewModel($view);
    }

    private function getLoginForm()
    {
        $this->loginForm = new LoginForm;
        
        return $this->loginForm;
    }

}
