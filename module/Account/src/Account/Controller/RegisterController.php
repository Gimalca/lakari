<?php

namespace Account\Controller;

use Account\Form\RegisterForm;
use Account\Form\Validator\RegisterValidator;
use Sales\Model\Dao\CustomerDao;
use Sales\Model\Entity\Customer;
use Zend\Http\PhpEnvironment\RemoteAddress;
use Zend\Mail\Message;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $registerForm = new RegisterForm();
        
        if ($request->isPost()) {
            //recibimos los datos del form
            $postData = $request->getPost();
           
            //validamos los datos enviados
            $registerValidator = $registerForm->setInputFilter(New RegisterValidator($this->getServiceLocator()));
            $registerValidator->setData($postData);
            //print_r($registerValidator);die;
           
            if ($registerValidator->isValid()) {  //si son validados continuamos
            
                //obtenemos los datos validados y filtrados 
                $registerData = $registerValidator->getData();
                //seteamos los campos requeridos en la Tabla
                $customerPrepareData = $this->prepareDataCustomer($registerData);
                //print_r($customerPrepareData);die;
                
                //incializamos la clase Entity Customer y le inyectamos los datos
                $customerEntity = new Customer($customerPrepareData);
                //print_r($customerEntity);die;
                //traemos el servicio CustomerTableGateway el cual nos trae el Adapter de la DB
                $customerTableGateway = $this->getService('CustomerTableGateway');
                //inicializamos la clase CustomerDao y le inyectamos el Adapter
                $customerDao = new CustomerDao($customerTableGateway);
                //print_r($customerDao);die;
                //Salvamos el registro en la bd
                $customerData = $customerEntity->getArrayCopy();
                //print_r($customerData);die;
                $saved = $customerDao->savedCustomer($customerData);
                //print_r($saved);die;
                if ($saved) { //si se guardo la fila en la BD continuamos
                    //enviamos el mail con
                    $sendMail = $this->sendMailRegisterConfirm($customerEntity);
                    //seteamos el mesanje de registro exitoso
                    $this->flashMessenger()->addMessage("Registro exitoso!!. Acabamos de enviarle un correo para confirmar su cuenta", 'success');
                    //$this->flashMessenger()->addMessage("Bienvenido $customerEntity->firstname $customerEntity->lastname !!. Acabamos de enviarle un correo de confirmacion ", 'success');
                } else {
                    $this->flashMessenger()->addMessage("Disculpe no pudimos procesar su registro ", "error");
                    // throw new \Exception("Not Save Row");
                }
                
            } else {
                $messages = $registerValidator->getMessages();
                //print_r($messages);die;
                $this->flashMessenger()->addMessage($messages, 'error');
            }
        }
        
        $view['registerForm'] = $registerForm; 

        return new ViewModel($view);
    }

    private function prepareDataCustomer($customerData)
    {
        $remote = new RemoteAddress;
        $ipClient = $remote->getIpAddress();

        $customerData['address_id'] = 0;
        $customerData['ip'] = $ipClient;
        $customerData['status'] = 0;
        $customerData['approved'] = 0;
        $customerData['newsletter'] = 1;
        $customerData['salt'] = time();
        $customerData['password'] = md5($customerData['password'] . $customerData['salt']);
        $customerData['token'] = md5(uniqid(mt_rand(), true));
        $customerData['date_added'] = date("Y-m-d H:i:s");

        return $customerData;
    }
    
    private function sendMailRegisterConfirm($registerData)
    {
        $mailer = $this->getServiceLocator()->get('Mailer');
                $message = new Message();
                $this->getRequest()->getServer();  //Server vars
                $message->addTo( $registerData->email)
                        ->addFrom('no-reply@lakari.com')
                        ->setSubject('Please, confirm your registration!')
                        ->setBody("Please, click the link to confirm your registration => " .
                                $this->getRequest()->getServer('HTTP_ORIGIN') .
                                $this->url()->fromRoute('account', array(
                                    'controller' => 'registration',
                                    'action' => 'confirm-email',
                                    'id' => $registerData->token)));
                
              $sendMail =  $mailer->send($message);
           
       return $sendMail;         
    }

    public function getService($serviceName)
    {
        $sm = $this->getServiceLocator();
        $service = $sm->get($serviceName);

        return $service;
    }

}
