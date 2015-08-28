<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

use Sales\Form\OrderAddCustomerForm;
use Sales\Model\Entity\Order;
use Sales\Model\Entity\OrderProduct;
Use Sales\Form\Validator\OrderAddCustomerValidator;
use Sales\Form\OrderAddProductForm;

class OrderController extends AbstractActionController {

    public function indexAction() {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $id = $request->getQuery('id', 0);
            $orderDao = $this->getServiceDao('Model\Dao\OrderDao');
            $order = array_filter($orderDao->getById($id)->getArrayCopy());
            $order['products'] = $orderDao->getOrderProducts($id);
            $response = $this->getResponse();
            $response->setStatusCode(200);
            $response->setContent(Json::encode($order));
            return $response;
        } else {
            return new ViewModel();
        }
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
            $orderDao = $this->getServiceDao('Model\Dao\OrderDao');

            $columns = array (
                'customer_id',
                'firstname',
                'lastname',
                'email',
                'telephone',
                'fax'
            );

            $product = [ 'order_id','order_status_id','invoice_no','total' ];

            $customer = array_filter($customerDao->getById($id, $columns)->getArrayCopy());
            //TODO Agregar cellphone al modelo
            $customer['cellphone'] = $customer['telephone'];

            $customer['orders'] = array_map(function ($product) {
                return [
                    'order_id' => $product['order_id'],
                    'invoice_no' => $product['invoice_no'],
                    'order_id' => $product['order_id'],
                    'total'    => $product['total']
                ];
            }, $orderDao->forCustomer($id, $product)->toArray());

            //mientras el modelo no tenga cel
            $response = $this->getResponse();
            $response->setStatusCode(200);
            $response->setContent(Json::encode($customer));
            return $response;
        }
        return false;
    }

    public function addAction() {

        $request = $this->getRequest();

        if ($request->isXmlHttpRequest() && $request->isPost()) {

            $postData = $request->getPost('user');
            $form = new OrderAddCustomerForm;
            $form->setInputFilter(new OrderAddCustomerValidator);
            $form->setData($postData);

            if ($form->isValid()) {
                $orderData = $form->getData();
                $orderEntity = New Order;
                $orderEntity->exchangeArray($orderData);
                $dataOrder = $orderEntity->getArrayCopy();
                $orderDao = $this->getServiceDao('Model\Dao\OrderDao');
                $saved = $orderDao->savedOrderAddCustomer($this->formatInsert($orderEntity));

                $id = $dataOrder['customer_id'];
                $response = $this->getResponse();

                if ($saved) {
                    $response->setStatusCode(200);
                    $response->setContent(Json::encode(array('order_id' => $saved, 'products' => [])));

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
            $form->setData($postData);

            if ($form->isValid()) {

                $formData = $form->getData();

                $productDao  = $this->getServiceDao('Admin\Model\Dao\ProductDao');
                $result      = $productDao->getProductById($postData['product_id']);
                $description = $result->getProductDescription();

                $product['name'] = $description->getName();
                $product['description'] = $description->getDescription();
                $product['image'] = $request->getBasePath() . $result->getProductImage()[0]->image;
                $product['price'] = $result->getPrice();
                $product['model'] = $result->getModel();
                $product['quantity'] = $result->getQuantity();

                $mixedData = array(
                    'order_id'    => $formData['order_id'],
                    'product_id'  => $formData['product_id'],
                    'name'        => $product['name'],
                    'model'       => $product['model'],
                    'quantity'    => 1,
                    'price'       => $product['price'],
                    'total'       => $product['price'],
                    'tax'         => 0,
                    'reward'      => 0
                );

                $orderProduct = new OrderProduct($mixedData);
                $orderDao = $this->getServiceDao('Model\Dao\OrderDao');
                $saved    = $orderDao->saveOrderProduct($orderProduct);

                $response = $this->getResponse();

                if ($saved) {
                    $response->setStatusCode(200);
                    $response->setContent(Json::encode($product));
                } else {
                    $response->setStatusCode(400);
                }
                return $response;

            }
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
