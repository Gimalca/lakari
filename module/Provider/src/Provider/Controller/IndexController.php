<?php

namespace Provider\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\RemoteAddress;

use Provider\Model\Entity\Provider;
use Provider\Form\RegisterProvider;
use Admin\Form\Validator\RegisterProviderValidator;
use Provider\Model\Dao\ProviderDao;

use Zend\Mail\Message;


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

                        $providerTableGateway = $this->getService('providerTableGateway');
                        $providerDao = new ProviderDao($providerTableGateway);
                        
                         $saved = $providerDao->saveProvider($providerData);
                         $sendMail = $this->sendMailRegisterConfirm($providerData);
                         
                          print_r($saved); print_r($sendMail);die;
                        if ($saved && $sendMail) {    
                             $email = $providerData['email'];
                             $this->flashMessenger()->addMessage("Registro satisfactorio Por favor revise su correo: $email", 'success' );
                        } else {
                            $this->flashMessenger()->addMessage("Disculpe no pudimos procesar su registro ", "error");
                           // throw new \Exception("Not Save Row");
                        }
                    } else {
                        $this->flashMessenger()->addMessage("Revise los datos del formulario ", 'error');
                        $messages = $registerForm->getMessages();
                        $this->flashMessenger()->addMessage($messages, 'error');
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
        
        $providerData['logo'] = 'no-logo.jpg';
        $providerData['status'] = 0;
        $providerData['categories'] = '0';
        $providerData['approved'] = 0;
        $providerData['active'] = 0;
        $providerData['salt'] = time();
        $providerData['ip'] = $ipClient;
        $providerData['token'] = md5(uniqid(mt_rand(), true));
        $providerData['date_added'] = date("Y-m-d H:i:s");
        
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
                
              $sendMail =  $mailer->send($message);
           
              if($sendMail){
                 $this->flashMessenger()->addMessage("Email enviado con exito." , 'success' );
                 
              }  else {
                 $this->flashMessenger()->addMessage("No se pudo enviar el mail", 'error' );
                 
              }
       return $sendMail;         
    }

    public function getService($serviceName)
    {
        $sm = $this->getServiceLocator();
        $service = $sm->get($serviceName);

        return $service;
    }

    public function confirmRegisterAction()
    {
        return new ViewModel();
    }


}

