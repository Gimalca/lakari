<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

use Sales\Form\OrderAddCustomerForm;
use Sales\Model\Entity\Order;
Use Sales\Form\Validator\OrderAddCustomerValidator;
use Sales\Form\OrderAddProductForm;

class OrderController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }

    public function listAction() {
        $orderDao = $this->getServiceDao('Model\Dao\OrderDao');
        $view['orders'] = $orderDao->getAll();

        return new ViewModel($view);
    }

    public function userinfoAction() {

        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {

            $id = $request->getQuery('id');
            $customerDao = $this->getServiceDao('Model\Dao\CustomerDao');

            $columns = array (
                'customer_id',
                'firstname',
                'lastname',
                'email',
                'telephone',
                'fax',
            );

            $customer = $customerDao->getById($id, $columns)->getArrayCopy();

            //mientras el modelo no tenga cel
            $customer['cellphone'] = $customer['telephone'];
            $response = $this->getResponse();
            $response->setStatusCode(200);
            $response->setContent(Json::encode(array_filter($customer)));
            return $response;
        }

        return false;
    }

    public function addAction() {

        $request = $this->getRequest();
        $form = new OrderAddCustomerForm;

        if ($request->isXmlHttpRequest() && $request->isPost()) {

            $postData = $request->getPost('user');
            $form->setInputFilter(new OrderAddCustomerValidator);
            $form->setData($postData);
            if ($form->isValid()) {
                $orderData = $form->getData();

                //TODO BUSCAR ORDEN EN ESTADO DE PENDIENTE

                $orderEntity = New Order;
                $orderEntity->exchangeArray($orderData);
                $dataOrder = $orderEntity->getArrayCopy();
                $orderDao = $this->getServiceDao('Model\Dao\OrderDao');
                $saved = $orderDao->savedOrderAddCustomer($this->formatInsert($orderEntity));

                //TODO Busco el carrito del cliente para mostrar
                //los items ya cargados

                $customerDao = $this->getServiceDao('Model\Dao\CustomerDao');
                $id = $dataOrder['customer_id'];
                $customer = $customerDao->getById($id, array('cart'))->getArrayCopy();
                $cart = (isset($customer['cart']) && $customer['cart'])? $customer['cart']:[];
                $response = $this->getResponse();

                if ($saved) {
                    $response->setStatusCode(200);
                    $response->setContent(Json::encode(array('order_id' => $saved, 'cart' => $cart)));

                } else {
                    throw new \Exception("Not Save Row");
                }
            } else {
                $messages = $form->getMessages();
                $response->setStatusCode(400);
                $response->setContent(Json::encode($messages));
            }
            return $response;
        }

        $view['customers'] = JSON::encode($this->getCustomerSelect());
        //print_r($view['customers']);die;
        $view['products'] = JSON::encode($this->getProductSelect());
        return new ViewModel($view);
    }

    public function addProductAction() {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $postData = $request->getPost();
            $form = new OrderAddProductForm;

            //TODO AGREGAR EL PRODUCTO AL CARRITO
            $productDao = $this->getServiceDao('Admin\Model\Dao\ProductDao');
            $result = $productDao->getProductById($postData['product_id']);

            $product['name'] = $result->getProductDescription()->getName();
            $product['description'] = $result->getProductDescription()->getDescription();
            $product['image'] = $result->getProductImage()[0]->image;
            $product['price'] = $result->getPrice();
            $product['quantity'] = $result->getQuantity();

            $response = $this->getResponse();
            $response->setStatusCode(200);
            $response->setContent(Json::encode($product));
            return $response;
        };
        return false;
    }

    private function getServiceDao($service) {
        $sm = $this->getServiceLocator();
                $tableGateway = $sm->get($service);

                return $tableGateway;
    }

    private function formatInsert($order) {
        $order->order_status_id = 0;
        $order->date_added = date("Y-m-d H:i:s");
        $order->invoice_no = 0;
        return $order;
    }

    private function getProductSelect() {

        $productDao = $this->getServiceDao('Admin\Model\Dao\ProductDao');
        $results = $productDao->getAll();

        $products = array_map(function ($product) {
        $description = $product['productDescription'];

            return array(
                'id' => $product['product_id'],
                'name' => $description->getName(),
                'description' => $description->getDescription(),
            );

        }, $results->toArray());

        return $products;
    }

    private function getCustomerSelect() {

        $customerDao = $this->getServiceDao('Model\Dao\CustomerDao');
        $results = $customerDao->getAll();

        $customers = array_map(function ($customer) {
            return array(
                'id' => $customer['customer_id'],
                'name' => $customer['firstname'],
                'email' => $customer['email'],
                'lastname' => $customer['lastname'],
            );
        }, $results->toArray());

        return $customers;
    }
}
