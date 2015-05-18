<?php
namespace Admin\Model\Entity;

class Quantity
{

    protected $quantity_id;

    protected $number;

    function __construct($quantity_id = null, $number = null)
    {
        $this->quantity_id = $quantity_id;
        $this->number = $number;
    }

    /**
     *
     * @return the $quantity_id
     */
    public function getQuantity_id()
    {
        return $this->quantity_id;
    }

    /**
     *
     * @return the $number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     *
     * @param string $quantity_id            
     */
    public function setQuantity_id($quantity_id)
    {
        $this->quantity_id = $quantity_id;
    }

    /**
     *
     * @param string $number            
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}