<?php

namespace Provider\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Provider\Form\RegisterProvider;



class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function registerAction()
    {
        $request = $this->getRequest();       
                $registerForm = new RegisterProvider();

                if ($request->isPost()) {
                    $postData = $request->getPost();

                    $registerForm->setInputFilter(new RegisterProviderValidator($this->getServiceLocator()));
                    $registerForm->setData($postData);

                    if ($registerForm->isValid()) {
                        $providerData = $registerForm->getData();              
                        $providerData = $this->prepareDataProvider($providerData); 
                        
                        $providerEntity = New Provider();
                        $providerEntity->exchangeArray($providerData);
                        $providerData = $providerEntity->getArrayCopy();

                        $providerDao = $this->getServiceDao('Model\Dao\ProviderDao');
                        $saved = $providerDao->saveProvider($providerData);

                        if ($saved) {                
                            $this->sendMailRegisterConfirm($providerData);
                            $this->flashMessenger()->addMessage($providerData['email']);
                            print_r($providerData);
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
        $ipClient = $remote->getIpAddress();
        $providerData['status'] = 0;
        $providerData['categories'] = '0';
        $providerData['approved'] = 0;
        $providerData['active'] = 0;
        $providerData['ip'] = $ipClient;
        $providerData['token'] = md5(uniqid(mt_rand(), true));

        return $providerData;
    }

    private function sendMailRegisterConfirm($providerData)
    {
        $mailer = $this->getServiceLocator()->get('Mailer');
                $message = new Message();
                $this->getRequest()->getServer();  //Server vars
                $message->addTo( $providerData['email'])
                        ->addFrom('praktiki@coolcsn.com')
                        ->setSubject('Please, confirm your registration!')
                        ->setBody("Please, click the link to confirm your registration => " .
                                $this->getRequest()->getServer('HTTP_ORIGIN') .
                                $this->url()->fromRoute('provider', array(
                                    'controller' => 'registration',
                                    'action' => 'confirm-email',
                                    'id' => $providerData['token'])));
                $mailer->send($message);
    }

    public function getServiceDao($service)
    {
        $sm = $this->getServiceLocator();
                $tableGateway = $sm->get($service);

                return $tableGateway;
    }

    public function confirmRegisterAction()
    {
        return new ViewModel();
    }


}

