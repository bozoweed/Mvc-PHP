<?php

class Order {
    private $_id;
    private $_billId;
    private $_bill;
    private $_createDate;
    private $_archived;

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

    private function setBillId($billId){       
        $billId = (int)$billId; 
        if($billId >0)
            $this->_billId = $billId;        
    }

    private function setCreateDate($createDate){      
        if(is_string($createDate))
            $this->_createDate = $createDate;        
    }

    private function setArchived($archived){       
        $archived = (int)$archived; 
        if($archived >0)
            $this->_archived = $archived;        
    }

    public function setBill($bills){        
        foreach($bills as $bill)
            if($bill->id() == $this->_billId)
                $this->_bill = $bill;
    }
    

    //Getter

    public function id(){
        return $this->_id;
    }    

    public function bill(){
        return  $this->_bill;
    }

    public function createDate(){
        return  $this->_createDate;
    }    
   
    public function archived(){
        return $this->_archived;
    }    
}