<?php

class Order{
    private $itemID;
    private $title;
    private $price;
    private $color;
    private $size;
    private $qty;

    public function __construct($itemID, $title, $color, $size, $qty, $price)
    {
        $this->itemID = $itemID;
        $this->title = $title;
        $this->color = $color;
        $this->size = $size;
        $this->qty = $qty;
        $this->price = $price;
    }


    public function getItemID()
    {
        return $this->itemID;
    }
    public function setItemID($itemID)
    {
        $this->itemID = $itemID;
    }


    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }


    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }


    public function getColor()
    {
        return $this->color;
    }
    public function setColor($color)
    {
        $this->color = $color;
    }


    public function getSize()
    {
        return $this->size;
    }
    public function setSize($size)
    {
        $this->size = $size;
    }


    public function getQty()
    {
        return $this->qty;
    }

    public function setQty($qty)
    {
        $this->qty = $qty;
    }


    public function calculateTotalPrice(){
        $total = $this->price * $this->qty;
        return $total;
    }

}


?>