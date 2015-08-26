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

    public function savedOrderAddCustomer(Order $order) {

         $this->tableGateway->insert($order->getArrayCopy());
         return $this->tableGateway->getLastInsertValue();
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
        return $this->getTable('lk_order_product')->insert($insert);
    }

    private function getTable($tableName) {
        $adapter = $this->tableGateway->getAdapter();
        return new TableGateway($tableName, $adapter);
    }

}
