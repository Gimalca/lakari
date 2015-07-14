<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Provider\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Provider\Form\RegisterProvider;
use Provider\Form\Validator\RegisterProviderValidator;
use Admin\Model\Entity\Provider;
use Zend\Mail\Message;
use \Zend\Http\PhpEnvironment\RemoteAddress;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {

        return new ViewModel();
    }

    public function registerAction()
    {
        $request = $this->getRequest();       
        $registerForm = New RegisterProvider();

        if ($request->isPost()) {
            $postData = $request->getPost();

            $registerForm->setInputFilter(new RegisterProviderValidator());
            $registerForm->setData($postData);

            if ($registerForm->isValid()) {
                $providerData = $registerForm->getData();
                $providerEntity = New Provider();
                $providerData = $this->prepareDataProvider($providerData);
                $providerEntity->exchangeArray($providerData);
                $providerData = $providerEntity->getArrayCopy();


                $providerDao = $this->getServiceDao('Model\Dao\ProviderDao');
                // $saved = $providerDao->saveProvider($providerData);

                if (!$saved) {
                    print_r($providerData);
                    echo 'registrado';
                    die;
                } else {
                    throw new \Exception("Not Save Row");
                }
            } else {
                $messages = $registerForm->getMessages();
                //print_r($messages);die;
                $registerForm->populateValues($postData);
            }
        }


        $view['providerForm'] = $registerForm;

        return new ViewModel($view);
    }

    private function prepareDataProvider($providerData)
    {
        $remote = new RemoteAddress;
        $ipClient =  $remote->getIpAddress();
        $providerData['status'] = 0; 
        $providerData['categories'] = '0';
        $providerData['ip'] = $ipClient;
        $providerData['token'] = md5(uniqid(mt_rand(), true));
        
        return $providerData;  
    }
   

    private function sendMailRegisterConfirm($providerData)
    {
        $mailer = $this->getServiceLocator()->get('Mailer');
        $menssage = new Message();
        $this->getRequest()->getServer();  //Server vars
        $message->addTo($providerData->usr_email)
                ->addFrom('praktiki@coolcsn.com')
                ->setSubject('Please, confirm your registration!')
                ->setBody("Please, click the link to confirm your registration => " .
                        $this->getRequest()->getServer('HTTP_ORIGIN') .
                        $this->url()->fromRoute('auth/default', array(
                            'controller' => 'registration',
                            'action' => 'confirm-email',
                            'id' => $providerData->usr_registration_token)));
        $transport->send($message);
    }

    public function getServiceDao($service)
    {

        $sm = $this->getServiceLocator();
        $tableGateway = $sm->get($service);

        return $tableGateway;
    }

}
