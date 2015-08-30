<?php

namespace Sales\Model\Dao;

/**
 * Description of CustomerDao
 *
 * @author Pedro
 */
use Sales\Model\Entity\Order;
use Sales\Model\Entity\OrderProduct;

use Zend\Db\TableGateway\TableGateway;

class OrderDao {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

     public function getAll() {

        $query = $this->tableGateway->getSql()->select();

        $query->order("order_id DESC");
        //echo $query->getSqlString();die;

        $resultSet = $this->tableGateway->selectWith($query);
        //var_dump($resultSet);die;
        return $resultSet;
    }

    public function getById($id) {

        $id = (int) $id;

        $sql = $this->tableGateway->getSql();
        $query = $sql->select()
            ->columns(array('order_id','order_status_id','invoice_no'), true)
            ->where(array('order_id'=> $id));

        $rowset = $this->tableGateway->selectWith($query);
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getOrderProductById($id) {
        $id = (int) $id;
        $orderProduct = $this->getTable('lk_order_product');
        $sql = $orderProduct->getsql();
        $query = $sql->select()
                ->columns(array('name', 'model', 'quantity'))
                ->where(array('order_product_id' => $id));
        $rowSet = $orderProduct->selectWith($query);
        $row = $rowSet->current();
        if(!$row) {
            throw new \Exception("Coulndt Find row {$id}");
        } else {
            return $row;
        }
    }

    public function getOrderProducts($id) {

        $id = (int) $id;
        $sql = $this->getTable('lk_order_product')->getSql();

        $query = $sql->select()
            ->columns(array('order_product_id as product_id','name','price', 'quantity'), true)
            ->join(array('pro' => 'lk_product'),
                'pro.product_id = lk_order_product.product_id')
            ->join(array('pi' => 'lk_product_image'),
                'pro.product_id = pi.product_id', array('image'))
            ->join(array('pd' => 'lk_product_description'),
                'pd.product_id = pro.product_id', array('name','description'))
            ->where(array('order_id'=> $id));

        $resultSet = $this->getTable('lk_order_product')->selectWith($query);
        $buffer = $resultSet->buffer();
        $result = $this->formatOrderProduct($buffer);
        return $result;
    }

    private function formatOrderProduct($orderProducts) {
        $products = [];
        foreach($orderProducts->toArray() as $orderProduct) {
            $product = [];
            foreach($orderProduct as $key => $value) {
                if ($key === 'description' || $key === 'image') {
                    if(!isset($product[$key])) {
                        $product[$key] = [];
                    }
                    array_push($product[$key], $value);
                } else {
                    $product[$key] = $value;
                }
            }
            $products[] =  $product;
        }
        return $products;
    }

    public function savedOrderAddCustomer(Order $order) {

         $this->tableGateway->insert($order->getArrayCopy());
         return $this->tableGateway->getLastInsertValue();
    }

    public function deleteOrder($id) {
        $id = (int) $id;
        $result = $this->tableGateway->delete(array('order_id' => $id));
        return $result;
    }

    public function deleteOrderProduct($id) {
        $id = (int) $id;
        $delete = $this->getTable('lk_order_product')
            ->delete(array('order_product_id' => $id));
        return $delete;
    }

    public function forCustomer($id, $columns) {

        $sql = $this->tableGateway->getSql();
        $query = $sql->select()
            ->columns($columns, true)
            ->where(array('lk_order.customer_id' => $id));
        return $this->tableGateway->selectWith($query);
    }


    public function saveOrderProduct(OrderProduct $product) {
        $insert = $product->getArrayCopy();
        $orderProduct = $this->getTable('lk_order_product');
        $orderProduct->insert($insert);
        return $orderProduct->getLastInsertValue();
    }

    private function getTable($tableName) {
        $adapter = $this->tableGateway->getAdapter();
        return new TableGateway($tableName, $adapter);
    }
}
