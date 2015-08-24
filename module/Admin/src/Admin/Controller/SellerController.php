<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\RemoteAddress;
//
use Sales\Form\SellerForm;
use Sales\Form\Validator\SellerValidator;
use Sales\Model\Entity\Seller;

class SellerController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function listAction()
    {
        //Get Resulset DB CUSTOMER Table
        $sellerDao = $this->getServiceDao('Model\Dao\sellerDao');
        $view['sellers'] = $sellerDao->getAll();

        //Get Form Seller
         $sellerForm = new SellerForm;
         $view['form'] = $sellerForm;
        
//        $form = $this->params()->fromRoute('form', false);
//        if ($form) {
//            $view['form'] = $form;
//        } 
        //Fordward ADD ACTION 
        $add = $this->params()->fromRoute('add', false);
        $view['add'] = $add;

        return new ViewModel($view);
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $postData = $request->getPost();
            $sellerForm = New SellerForm;
            $sellerForm->setInputFilter(new SellerValidator($this->getServiceLocator()));
            $sellerForm->setData($postData);

            if ($sellerForm->isValid()) {
                $sellerData = $sellerForm->getData();
                $sellerPrepareData = $this->prepareSellerData($sellerData);

                $sellerEntity = new Seller();
                $sellerEntity->exchangeArray($sellerPrepareData);
                $sellerDataArray = $sellerEntity->getArrayCopy();

                $sellerDao = $this->getServiceDao('Model\Dao\sellerDao');
                $saved = $sellerDao->savedSeller($sellerDataArray);

                if ($saved) {

                    return $this->forward()->dispatch('Admin\Controller\Seller', array(
                                'action' => 'list',
                                'add' => 1,
                    ));
                } else {
                    throw new \Exception("Not Save Row");
                }
            } else {
                $messages = $sellerForm->getMessages();
                //print_r($messages);die;               
                $sellerForm->populateValues($postData);
                //Set View
                return $this->forward()->dispatch('Admin\Controller\Seller', array(
                                'action' => 'list',                             
                                'form' => $sellerForm
                    ));
            }
        }

        return $this->redirect()->toRoute('admin', array('controller' => 'seller', 'action' => 'list'));
    }

    private function prepareSellerData($sellerData)
    {
        $remote = new RemoteAddress;
        $ipClient = $remote->getIpAddress();
        $sellerData['ip'] = $ipClient;
        $sellerData['status'] = 0;
        $sellerData['approved'] = 0;
        $sellerData['salt'] = time();
        $sellerData['password'] = md5($sellerData['password'] . $sellerData['salt']);
        $sellerData['token'] = md5(uniqid(mt_rand(), true));
        $sellerData['date_added'] = date("Y-m-d H:i:s");

        return $sellerData;
    }

    public function deleteAction()
    {
        return new ViewModel();
    }

    public function updateAction()
    {
        return new ViewModel();
    }

    public function getServiceDao($service)
    {
        $sm = $this->getServiceLocator();
        $tableGateway = $sm->get($service);

        return $tableGateway;
    }

}
