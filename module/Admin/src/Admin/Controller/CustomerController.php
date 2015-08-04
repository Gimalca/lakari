<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//FORMS USE
use Sales\Form\CustomerForm;
use Sales\Form\Validator\CustomerValidator;
use Sales\Model\Entity\Customer;
//Others Libs
use Zend\Http\PhpEnvironment\RemoteAddress;

class CustomerController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function listAction()
    {
        //Decalaramos la variable view como array para enviarlo a la vista
        $view = array();
        
        //Llamamos al servicio de la clase CustomerDao
        $customerDao = $this->getService('Model\Dao\CustomerDao');
        
        //Asignamos al indice Customer Todo los Registros de la tabla customer
        $view['customers'] = $customerDao->getAll();
      
        //Get Form Customer si no existe
        $form = $this->params()->fromRoute('form', false);
        if ($form) {
            $view['form'] = $form;
        } else {
            $customerForm = new CustomerForm;
            $view['form'] = $customerForm;
        }


        //Fordward ADD ACTION si no se redirige
        $add = $this->params()->fromRoute('add', false);
        $view['add'] = $add;
       // print_r($view);die;
        return new ViewModel($view);
    }

    public function addAction()
    {
        $request = $this->getRequest();
       
        if ($request->isPost()) {

            $postData = $request->getPost();

            $customerForm = New CustomerForm;
            $customerForm->setInputFilter(new CustomerValidator($this->getServiceLocator()));
            $customerForm->setData($postData);

            if ($customerForm->isValid()) {
                $customerData = $customerForm->getData();
                //
                $customerPrepareData = $this->prepareDataCustomer($customerData);
                //print_r($customerPrepareData);die;
                $customerEntity = new Customer;
                $customerEntity->exchangeArray($customerPrepareData);
                $customerDataArray = $customerEntity->getArrayCopy();
                 
                $customerDao = $this->getService('Model\Dao\CustomerDao');
                $saved = $customerDao->savedCustomer($customerDataArray);

                if ($saved) {
                    return $this->forward()->dispatch('Admin\Controller\Customer', array(
                                'action' => 'list',
                                'add' => 1,
                    ));
                } else {
                    throw new \Exception("Not Save Row");
                }
            } else {
                $messages = $customerForm->getMessages();
                //print_r($messages);die;               
                $customerForm->populateValues($postData);
                return $this->forward()->dispatch('Admin\Controller\Customer', array(
                            'action' => 'list',
                            'form' => $customerForm
                ));
            }
        }

        return $this->redirect()->toRoute('admin', array('controller' => 'customer', 'action' => 'list'));
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

    public function deleteAction()
    {
        return new ViewModel();
    }

    public function getService($serviceName)
    {
        $sm = $this->getServiceLocator();
        $service = $sm->get($serviceName);

        return $service;
    }

}
