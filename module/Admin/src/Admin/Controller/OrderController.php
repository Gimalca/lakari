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

            // solo una foto

            $sm = $this->getServiceLocator();
            $helper = $sm->get('viewhelpermanager')->get('basePath');
            $path = $helper('assets/images/products/catalog/');

            $products = array_map(function ($product) use($path) {
                $product['image'] = $path . $product['image'][0];
                $product['description'] = $product['description'][0];
                return $product;
            }, $orderDao->getOrderProducts($id));

            $order['products'] = $products;
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
                $order = [
                    'order_id' => $saved,
                    'order_status_id' => 0,
                    'invoice_no' => 0
                ];

                $response = $this->getResponse();

                if ($saved) {
                    $response->setStatusCode(200);
                    $response->setContent(Json::encode($order));

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

                $sm = $this->getServiceLocator();
                $helper = $sm->get('viewhelpermanager')->get('basePath');
                $path = $helper('assets/images/products/catalog/');

                $product['name'] = $description->getName();
                $product['description'] = $description->getDescription();
                $product['image'] = $path . $result->getProductImage()[0]->image;
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
                $product['product_id'] = $saved;

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

    public function deleteAction() {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $postData = $request->getPost();
            $orderDao = $this->getServiceDao('Model\Dao\OrderDao');
            $id = $postData['id'];
            $order = array_filter($orderDao->getById($id)->getArrayCopy());
            $response = $this->getResponse();
            $deleted = $orderDao->deleteOrder($id);
                if ($deleted) {
                    $response->setStatusCode(200);
                    $response->setContent(Json::encode($order));
                    return $response;
                }
        }
        return false;
    }

    public function deleteProductAction() {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $postData = $request->getPost();
            $orderDao = $this->getServiceDao('Model\Dao\OrderDao');
            $id = $postData['id'];
            $orderProduct = array_filter($orderDao->getOrderProductById($id)->getArrayCopy());
            $response = $this->getResponse();

            if ($orderProduct) {
                $deleted = $orderDao->deleteOrderProduct($id);
                if ($deleted) {
                    $response->setStatusCode(200);
                    $response->setContent(Json::encode($orderProduct));
                    return $response;
                }
            }
        }
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
