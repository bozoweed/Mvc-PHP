<?php

class Line {
    private $_id;
    private $_beerId;
    private $_quantity;
    private $_discount;
    private $_beer;

    //constructeur
    public function __construct(array $data){
        $this->hydrate($data);
    }

    //hydratation (on vas vérifier si nos setter exist qui eux apporteront un controle sur la donnée)
    private function hydrate(array $data){
        foreach($data as $key => $value){
            $method = "set".ucfirst($key);
            if(method_exists($this, $method))
                $this->$method($value);
        }
    }

    //setter
    private function setId($id){
        $id = (int)$id;
        if($id >0)
            $this->_id = $id;        
    }

    private function setBeerId($beerId){       
        $beerId = (int)$beerId; 
        if($beerId >0)
            $this->_beerId = $beerId;        
    }

    private function setQuantity($quantity){       
        $quantity = (int)$quantity; 
        if($quantity >0)
            $this->_quantity = $quantity;        
    }

    private function setDiscount($discount){       
        $discount = (double)$discount; 
        if($discount >0)
            $this->_discount = $discount;        
    }

    public function setBeer($beers){        
        foreach($beers as $beer)
            if($beer->Id() == $this->_beerId){
                $this->_beer = $beer;
                break;
            }       
    }

    //Getter

    public function id(){
        return $this->_id;
    }

    public function beer(){
        return $this->_beer;
    }

    public function quantity(){
        return  $this->_quantity;
    }

    public function discount(){
        return $this->_discount;
    }  

    public function price()
    {
        return (($this->_beer->price() * $this->_quantity) - $this->_discount);
    }
}