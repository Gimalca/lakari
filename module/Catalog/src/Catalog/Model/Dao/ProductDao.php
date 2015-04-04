<?php

namespace Catalog\Model\Dao;

/**
 * Description of ProductTable
 *
 * @author Pedro
 */
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Catalog\Model\Entity\Product;
use Catalog\Model\Entity\ProductDescription;
use Catalog\Model\Entity\ProductImage;

class ProductDao implements IProductDao
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getAll()
    {
       
        $query = $this->tableGateway->getSql()->select();
        $query->join(array('pd' => 'lk_product_description'),
                'pd.product_id = lk_product.product_id');
        $query->join(array('url' => 'lk_url_alias'),
                "lk_product.product_id = url.id"
                );
        $query->where(array("url.type = 'product'"));
        
        $query->order("lk_product.product_id");
        //echo $query->getSqlString();
        
        
        $resultSet = $this->tableGateway->selectWith($query);
        //var_dump($resultSet);
       
        return $resultSet;
    }
    
    public function getImages($productId = null)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $query = $sql->select();
        $query->from('lk_product_image');
        
        if ($productId) {
            $query->where('product_id = ' . $productId);
        }
        
        $statement = $sql->prepareStatementForSqlObject($query);
        $resultSet = $statement->execute();

        $images = new \ArrayObject();
        foreach ($resultSet as $row) {
            $productImage = new ProductImage();
            $productImage->exchangeArray($row);
            $images->append($productImage);
        }
        
        return $images;
    }

    public function getProductById($id)
    {
        $id = (int) $id;
        //$rowset = $this->tableGateway->select(array('id' => $ide));
        
        $query = $this->tableGateway->getSql()->select();
        $query->join(array('pd' => 'lk_product_description'),
                'pd.product_id = lk_product.product_id');
        $query->join(array('url' => 'lk_url_alias'),
                "lk_product.product_id = url.id"
                );
        $query->where(array("url.type = 'product'"));
        $query->where(array('lk_product.product_id' => $id));
       
        $rowset = $this->tableGateway->selectWith($query);
 
        //var_dump($rowset);die;
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function getById($id){
        
        $id = (int) $id;
        
        $rowset = $this->tableGateway->select(array('product_id' => $id));

        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        //print_r($row);die;
        return $row;  
    }

    public function saveProduct(Product $product)
    {
        $id =(int) $product->getProduct_id();
        //print_r($product);die;
        $data_product = array(
            'model' => $product->getModel(),
            'price' => $product->getPrice(),
        );
        
        $data_product_description = array(            
            'name' => $product->getProductDescription()->getName(),
            'description' => $product->getProductDescription()->getDescription(),
        );

       
        if($id == 0){
            //insert Product Table
            $data['date_added'] = date("Y-m-d H:i:s");
            $this->tableGateway->insert($data_product);
            $lastProductId = $this->tableGateway->getLastInsertValue();
            //Insert Product Description
            $data_product_description['product_id'] = $lastProductId;
            $table = $this->getTable('lk_product_description');
            $table->insert($data_product_description);
            return $lastProductId;
        }else {
           
            if($this->getById($id)){
                $data['date_modified'] = date("Y-m-d H:i:s");
                $this->tableGateway->update($data,array('product_id' => $id));
                return $id;
            }else {
                throw new \Exception('Form id does not exist');
            }
        }     
       
        
    }

    public function deleteProduct(Product $product)
    {
        return $product;
    }

    //put your code here
    
    public function getTable($table){    
        $adapter = $this->tableGateway->getAdapter();
        $table = new TableGateway($table, $adapter);

        return $table;     
    }
}
