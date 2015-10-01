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
use Admin\Model\Entity\ProductDescription;
use Admin\Model\Entity\ProductImage;
use Catalog\Model\Entity\ProductRelated;


class ProductDao implements IProductDao {

    protected $tableGateway;
    private $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getAll() {

        $query = $this->tableGateway->getSql()->select();

        $query->join(array(
            'pd' => 'lk_product_description'
                ), 'pd.product_id = lk_product.product_id');
        $query->join(array(
            'url' => 'lk_url_alias'
                ), "lk_product.product_id = url.id");
        $query->join(array(
            'img' => 'lk_product_image'
                ), "lk_product.product_id = img.product_id");
        $query->where(array(
            'url.type' => 'product',
            'img.sort_order' => 1
        ));

        $query->order("lk_product.product_id DESC");
        // echo $query->getSqlString();die;

        $resultSet = $this->tableGateway->selectWith($query);
        //var_dump($resultSet->current()); die;

        return $resultSet;
    }

    public function getProductsByCategory($categoryId)
    {
        $query = $this->tableGateway->getSql()->select();
        $query->join(array(
            'pd' => 'lk_product_description'
                ), 'pd.product_id = lk_product.product_id');
        $query->join(array(
            'phc' => 'lk_product_has_category'
                ), 'phc.product_id = lk_product.product_id');
        $query->join(array(
            'c' => 'lk_category'
                ), 'c.category_id = phc.category_id');
        /* $query->join(array(
          'cd' => 'lk_category_description'
          ),  'c.category_id = cd.category_id'); */
        $query->join(array(
            'pm' => 'lk_product_image'
                ), 'pm.product_id = lk_product.product_id');
        $query->join(array(
            'url' => 'lk_url_alias'
                ), 'lk_product.product_id = url.id');

        $query->where(array(
            'c.category_id' => $categoryId,
            'url.type' => 'product',
            'pm.sort_order' => 1
        ));

        $query->order("lk_product.product_id DESC");
        // echo $query->getSqlString();die;

        $resultSet = $this->tableGateway->selectWith($query);
        // var_dump($resultSet);
        if (!$resultSet) {
            throw new \Exception("Could not find row $id");
        }
        return $resultSet;
    }

    public function getImages($productId = null, $columns=null)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $query = $sql->select();
        $query->from('lk_product_image');

        if ($columns && is_array($columns)) {
            $query->columns($columns);
        }

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

    public function getCategories($productId, $columns)
    {
        $table = $this->getTable('lk_product_has_category');
        $query = $table->getSql()->select();

        if ($productId) {
            $query->where('product_id = ' . $productId);
        }

        if ($columns && is_array($columns)) {
            $query->columns($columns);
        }

        $resultSet = $table->selectWith($query);

        $categories = array();
        foreach ($resultSet as $row) {
            $categories[] = $row->category_id;
        }

        return $categories;
    }

    public function getProductById($id)
    {
        $id = (int) $id;
        // $rowset = $this->tableGateway->select(array('id' => $ide));

        $query = $this->tableGateway->getSql()->select();

        $query->join(array(
            'pd' => 'lk_product_description'
                ), 'pd.product_id = lk_product.product_id');
        $query->join(array(
            'url' => 'lk_url_alias'
                ), "lk_product.product_id = url.id");
        $query->join(array(
            'phc' => 'lk_product_has_category'
                ), "lk_product.product_id = phc.product_id");
        $query->where(array(
            "url.type = 'product'"
        ));
        $query->where(array(
            'lk_product.product_id' => $id
        ));
        // echo $query->getSqlString();die;

        $rowset = $this->tableGateway->selectWith($query);
        //var_dump($rowset);die;

        $row = $rowset->current();

        $images = $this->getImages($id);
        $categories = $this->getCategories($id);

        $row->setProductImage($images);
        $row->setProductCategories($categories);


        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function updateProductStatus($status,$id)
    {

        $id = (int) $id;
        $status = (int) $status;

        $result = $this->tableGateway->update(array('status' => $status), array('product_id' => $id));

        return $result;
    }

    public function getProviderId($id)
    {
        $id = (int) $id;
        // $rowset = $this->tableGateway->select(array('id' => $ide));

        $query = $this->tableGateway->getSql()->select();
        $query->join(array(
            'pd' => 'lk_product_description'
                ), 'pd.product_id = lk_product.product_id');
        $query->join(array(
            'url' => 'lk_url_alias'
                ), "lk_product.product_id = url.id");
        $query->join(array(
            'img' => 'lk_product_image'
                ), "lk_product.product_id = img.product_id");
        $query->where(array(
            'lk_product.provider_id' => $id,
            'url.type' => 'product',
            'img.sort_order' => 1
        ));

        $query->order("lk_product.product_id DESC");
        // echo $query->getSqlString();die;

        $resultSet = $this->tableGateway->selectWith($query);
        // var_dump($resultSet);

        return $resultSet;
    }


    public function limit($limit, $offset=null) {

        if ($limit && is_numeric($limit)) {
            $this->select->limit($limit);
        }

        if($offset && is_numeric($offset)) {
            $this->select->offset($offset);
        }
        return $this;
    }

    public function where($id, $where=null) {

        $id = (int) $id;
        if (is_numeric($id) && $id != 0) {
            $this->select->where(array(
                'lk_product.product_id' => $id
            ));
        }

        if (isset($where) && is_array($where)) {
            $this->select->where($where);
        }
        return $this;
    }

    public function orderBy($by) {
        $this->select->order($by);
        return $this;
    }

    public function products($columns) {
        $this->select = $this->tableGateway->getSql()->select();
        if ($columns) $this->select->columns($columns);
        return $this;
    }

    public function descriptions() {

        $this->select->join(array(
            'pd' => 'lk_product_description'
                ), 'pd.product_id = lk_product.product_id');
        return $this;
    }

    public function images() {
        $this->select->join(array(
            'img' => 'lk_product_image'
                ), "lk_product.product_id = img.product_id");
        return $this;
    }

    public function categories() {
        $this->select->join(array(
            'phc' => 'lk_product_has_category'
                ), "lk_product.product_id = phc.product_id");
        return $this;
    }

    public function fetch($callback=null) {
        $query     = $this->select;
        //echo $query->getSqlString();die;
        $resultSet = $this->tableGateway->selectWith($query);
        $result = $resultSet->buffer()->toArray();
            if (!is_null($callback) && is_callable($callback)) {
                $result = array_map($callback, $result);
            }
        $this->result = new \ArrayObject($result);
        return $this;
    }

    public function withImages($columns, $callback=null) {

        $result = $this->result;
        $products = new \ArrayObject();

        foreach ($result as $product) {
            $id = $product['product_id'];

            $images = $this->getImages($id, $columns);

            if (!is_null($callback) && is_callable($callback)) {
                $images = call_user_func($callback, $images);
            }

            $product['images'] = $images;
            $products->append($product);
        }
        $this->result = $products;
        return $this;
    }

    public function withDescriptions($columns = null, $callback = null) {
        $result = $this->result;
        $products = new \ArrayObject();

        foreach ($result as $product) {
            $id = $product['product_id'];
            $descriptions = $product['productDescription']->getArrayCopy();
            if (!is_null($callback) && is_callable($callback)) {
                $descriptions = call_user_func($callback, $descriptions);
            }

            $product['descriptions'] = $descriptions;
            $products->append($product);
        }
        $this->result = $products;
        return $this;
    }

    public function withCategories($columns) {
        $result = $this->result;

        $products = new \ArrayObject();
        foreach($result as $product) {
            $id = $product['product_id'];
            $categories = $this->getCategories($id, $columns);
            $product['categories']= $categories;
            $products->append($product);
        }
        $this->result = $products;
        return $this;
    }

    public function get() {
        $result = $this->result->getArrayCopy();

        if (sizeof($result) == 1) {
            return $result[0];
        } else {
            return $result;
        }
    }

    public function getJSON() {
        $result = array_filter($this->get());
        return \Zend\Json\Json::encode($result);
    }

    public function getById($id) {
        $id = (int) $id;

        $rowset = $this->tableGateway->select(array(
            'product_id' => $id
        ));
        //var_dump($id);die;

        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        // print_r($row);die;
        return $row;
    }

    protected function saveProductDescription($productId, $data = Null, $update = Null)
    {
        $id = (int) $productId;
        $data['product_id'] = $id;

        $table = $this->getTable('lk_product_description');

        if (!$update) {

            $saved = $table->insert($data);

            if (!$saved) {
                throw new \Exception("Could not find row $id - Insert ProductDescription");
            }
        } else {
            $table->update($data, array(
                'product_id' => $id,
            ));
        }

        return $table->getLastInsertValue();
    }

    public function saveProductImage($productId, $data = Null)
    {
        $id = (int) $productId;

        $table = $this->getTable('lk_product_image');

        foreach ($data as $image) {
            $insertImage = array(
                'product_id' => $id,
                'image' => $image->image,
                'sort_order' => $image->sort_order
            );

            $saved = $table->insert($insertImage);


            if (!$saved) {
                throw new \Exception("Could not find row $id - Insert ProductDescription");
            }
        }

        return $table->getLastInsertValue();
    }

    public function deleteProductImage($imageId)
    {

        $id = (int) $imageId;

        $table = $this->getTable('lk_product_image');
        return $table->delete(array('product_image_id' => $imageId));
    }

    protected function saveProductCategories($productId, $data = Null, $update = Null)
    {
        $id = (int) $productId;

        $table = $this->getTable('lk_product_has_category');

        if ($update == 1) {
            $table->delete(array('product_id' => $id));
        }

        foreach ($data as $category) {
            $insertCategories = array(
                'product_id' => $id,
                'category_id' => $category,
            );

            $saved = $table->insert($insertCategories);
        }

        return $table->getLastInsertValue();
    }

    protected function saveProductProvider($productId, $data = Null, $update = Null)
    {
        $id = (int) $productId;

        $table = $this->getTable('lk_product_provider');

        if ($update == 1) {
            $table->delete(array('product_id' => $id));
        }

        foreach ($data as $provider) {
            $insertProvider = array(
                'provider_id' => $provider,
                'company' => $company,
            );
            print_r($insertProvider);die;

            $saved = $table->insert($insertProvider);
        }

        return $table->getLastInsertValue();
    }

    protected function saveProductRelated($productId, $data = Null, $update = Null)
    {
        $id = (int) $productId;

        $table = $this->getTable('lk_product_related');

        if ($update == 1) {
            $table->delete(array('product_id' => $id));
        }

        foreach ($data as $related) {
            $insertRelated = array(
                'product_id' => $id,
                'related_id' => $related,
            );
            //print_r($insertRelated);die;

            $saved = $table->insert($insertRelated);
        }

        return $table->getLastInsertValue();
    }


    protected function saveUrlAlias($productId, $data = NULL, $update = NULL)
    {
        $id = (int) $productId;
        $data['id'] = $id;

        $table = $this->getTable('lk_url_alias');

        if (!$update) {
            $saved = $table->insert($data);

            if (!$saved) {
                throw new \Exception("Could not find row $id - Insert ProductUrlAlias");
            }
        } else {
            $saved = $table->update($data, array(
                'id' => $id
            ));
        }

        return $table->getLastInsertValue();
    }

    public function saveProduct(Product $product)
    {

        $productId = (int) $product->getProductId();
        // print_r($product);die;
        $data_product = array(
            'provider_id' => $product->getProvider_id(),
            'model' => $product->getModel(),
            'sku' => $product->getSku(),
            'isbn' => $product->getIsbn(),
            'price' => $product->getPrice(),
            'minimum' => $product->getMinimum(),
            'date_available' => date("Y-m-d H:i:s"),
            'date_added' => date("Y-m-d H:i:s"),
        );

        $data_product_description = array(
            'name' => $product->getProductDescription()->getName(),
            'description' => $product->getProductDescription()->getDescription(),
            'meta_description' => $product->getProductDescription()->getMeta_description(),
            'meta_keyword' => $product->getProductDescription()->getMeta_keyword(),
            'meta_tittle' => $product->getProductDescription()->getMeta_tittle()
        );

        $data_product_categories = $product->getProductCategories();

        $data_product_related = $product->getProductRelated();
        //print_r($data_product_related);die;

        $data_product_provider = $product->getProviderId();
        //print_r($data_product_provider);die;
        $data_product_image = $product->getProductImage();

        $data_product_urlAlias = array(
            'type' => $product->getUrlAlias()->type,
            'keyword' => $product->getUrlAlias()->keyword
        );

        if ($productId == 0) {
            // insert Product Table
            $sProduct = $this->tableGateway->insert($data_product);

            if ($sProduct) {

                $productId = $this->tableGateway->getLastInsertValue();
                // Insert Product Description
                $sDescription = $this->saveProductDescription($productId, $data_product_description);
                // Insert Images
                $sImage = $this->saveProductImage($productId, $data_product_image);
                // insert Url Alias
                $sUrlAlias = $this->saveUrlAlias($productId, $data_product_urlAlias);
                // insert Categories
                $sUrlAlias = $this->saveProductCategories($productId, $data_product_categories);
                //insert Related
                $sRelated = $this->saveProductRelated($productId, $data_product_related);


                return $productId;
            } else {
                throw new \Exception('Form id does not exist');
            }
        } else {

            if ($this->getById($productId)) {

                $data_product['date_modified'] = date("Y-m-d H:i:s");
                //print_r($data_product);die;
                $this->tableGateway->update($data_product, array(
                    'product_id' => $productId,
                ));
                // update Product Description
                $sDescription = $this->saveProductDescription($productId, $data_product_description, 1);
                // update Images ( AJAX )
                //$sImage = $this->saveProductImage($productId, $data_product_image);
                // update Url Alias
                $sUrlAlias = $this->saveUrlAlias($productId, $data_product_urlAlias, 1);
                // update Categories
                $sUrlAlias = $this->saveProductCategories($productId, $data_product_categories, 1);
                return $productId;
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteProduct($productId)
    {

        $id = (int) $productId;
        return $this->tableGateway->delete(array('product_id' => $productId));
    }

    // put your code here
    public function getTable($table)
    {
        $adapter = $this->tableGateway->getAdapter();
        $table = new TableGateway($table, $adapter);

        return $table;
    }

    //JOIN de base de datos con productos relacionados

    public function getProductRelated()
    {
        $query = $this->tableGateway->getSql()->select();
        $query->join(array(
            'pr' => 'lk_product_related'
                ), 'pr.product_id = lk_product_related.product_id');
        $query->join(array(
            'pro' => 'lk_product'),
                'pr.related_id = pro.product_id'
        );

        $query->order("lk_product.product_id DESC");
        //echo $query->getSqlString();die;

        $resultSet = $this->tableGateway->selectWith($query);
        //var_dump($resultSet->current()); die;

        return $resultSet;
    }

}
