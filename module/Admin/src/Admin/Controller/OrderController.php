<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Sales\Form\OrderAddCustomerForm;
use Sales\Model\Entity\Order;
Use Sales\Form\Validator\OrderAddCustomerValidator;
use Sales\Form\OrderAddProductForm;

class OrderController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function listAction()
    {
        $orderDao = $this->getServiceDao('Model\Dao\OrderDao');
        $view['orders'] = $orderDao->getAll();
        
        return new ViewModel($view);
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $form = new OrderAddCustomerForm;

        if ($request->isPost()) {

            $postData = $request->getPost();

            $form->setInputFilter(new OrderAddCustomerValidator);
            $form->setData($postData);

            if ($form->isValid()) {
                $orderData = $form->getData();

                $orderEntity = New Order;
                $orderEntity->exchangeArray($orderData);
                $dataOrder = $orderEntity->getArrayCopy();

                $orderDao = $this->getServiceDao('Model\Dao\OrderDao');
                $saved = $orderDao->savedOrderAddCustomer($dataOrder);

                if ($saved) {
                     
                      return $this->forward()->dispatch('Admin\Controller\Order', array(
                                'action' => 'addProduct',
                                'id' => $saved,
                    ));
                   
                } else {
                    throw new \Exception("Not Save Row");
                }
            } else {
                $messages = $form->getMessages();
                echo 'error filter';
                print_r($messages);
                die;
                $form->populateValues($postData);
            }
        }



        $cus = $this->getCustomerSelect();
        $form->get('customer_id')->setValueOptions($cus);

        $view['form'] = $form;

        return new ViewModel($view);
    }

    private function getCustomerSelect()
    {
        $customerDao = $this->getServiceDao('Model\Dao\CustomerDao');
                $results = $customerDao->getAll();

                $result = array();
                foreach ($results as $cus) {
                    //$result[] = $row->getArrayCopy();
                    $result[$cus->customer_id] = $cus->firstname . ' ' . $cus->lastname . ' - ' . $cus->email;
                }

                return $result;
    } 
    
    public function addProductAction()
    {
        $request = $this->getRequest();
      
        $idOrder = (int) $this->params()->fromRoute('id', 0);
        
//         if (!$idOrder) {
//            return $this->redirect()->toRoute('admin', array('controller' => 'order', 'action' => 'list'));
//        }
        
         if ($request->isPost()) {
              $postData = $request->getPost();
              
             // print_r($postData);die;

         };
        
        $form = new OrderAddProductForm;
        $products = $this->getProductSelect();
        $form->get('product_id')->setValueOptions($products);
       
        
        $view['form'] = $form;
   
        
        
        
        return new ViewModel($view);
    }
    
    private function getProductSelect()
    {
        $productDao = $this->getServiceDao('Admin\Model\Dao\ProductDao');
                $results = $productDao->getAll();
               
                $result = array();
                foreach ($results as $product) {
                    //$result[] = $row->getArrayCopy();
                    $result[$product->getProductId()] = $product->getProductDescription()->getName() . ' - ' . $product->getModel();
                }

                return $result;
    } 

    private function getServiceDao($service)
    {
        $sm = $this->getServiceLocator();
                $tableGateway = $sm->get($service);

                return $tableGateway;
    }

   


}

