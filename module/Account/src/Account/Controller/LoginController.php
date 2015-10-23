<?php

namespace Account\Controller;

use Account\Form\LoginForm;
use Account\Form\Validator\LoginValidator;
use Account\Model\Dao\UserDao;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{

    public function indexAction()
    {
        $request = $this->getRequest();
        $loginForm = new LoginForm();

        if ($request->isPost()) {

            $postData = $request->getPost();

            $loginValidator = $loginForm->setInputFilter(new LoginValidator());
            $loginValidator->setData($postData);
//            print_r($postData);            print_r($loginValidator->isValid());            print_r($loginValidator->getMessages());die;

            if ($loginValidator->isValid()) {
                
                $loginData = $loginValidator->getData();
                
                $email = $loginData['email'];
                $password = $loginData['password'];
                
                $customerTableGateway = $this->getService('CustomerTableGateway');
                $customerDao = new UserDao($customerTableGateway);
                $customerData = $customerDao->getByEmail($email, array('customer_id', 'salt'));
                //var_dump($customerData->salt);die;
                $passwordEncript = md5($password . $customerData->salt);
                //var_dump($passwordEncript); die;
                $loginAccount = $this->getService('Account\Model\LoginAccount');                
//                print_r($loginAccount);die;
                try {
                    //print_r('antes del login');
                    
                    $loginAccount->login($email, $passwordEncript);
                    //print_r('pase');
                     $this->flashMessenger()->addMessage('Login Correcto!', 'success');
                    
                     return $this->redirect()->toRoute('account');
                     
                } catch (\Exception $e) {
                    $this->layout()->mensaje = $e->getMessage();die;
                    $this->flashMessenger()->addMessage( $e->getMessage(), 'error');
                    //var_dump('mori');die;
                    return $this->forward()->dispatch('Account\Controller\Register', array('action' => 'index'));
                }

            } else {
                $messages = $loginForm->getMessages();
//                print_r($messages);die;
                $this->flashMessenger()->addMessage('Login incorrecto verifique sus datos!', 'error');
                 return $this->forward()->dispatch('Account\Controller\Register', array(
                            'action' => 'index',
                            'forwardLogin' => true,
                            'loginForm' => $loginForm
                ));
            }
        }
        return new ViewModel();
    }

    public function logoutAction()
    {
        $loginAccount = $this->getService('Account\Model\LoginAccount');
        $loginAccount->logout();
        //seteamos el mesanje de registro exitoso
        $this->flashMessenger()->addMessage("Session Finalizada", 'success');

        return $this->redirect()->toRoute('account', array(
                    'controller' => 'register',
                    'action' => 'add'
        ));
    }

    public function getService($serviceName)
    {
        $sm = $this->getServiceLocator();
        $service = $sm->get($serviceName);

        return $service;
    }

}
