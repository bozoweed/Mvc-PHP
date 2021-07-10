<?php

class Type {
    private $_id;
    private $_label;
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

    private function setLabel($label){        
        if(is_string($label))
            $this->_label = $label;        
    }

    private function setArchived($archived){    
        $archived = (int)$archived;     
        if($archived >0)
            $this->_archived = $archived;        
    }    

    //Getter

    public function id(){
        return $this->_id;
    }

    public function label(){
        return $this->_label;
    }

    public function archived(){
        return $this->_archived == 1;
    }

}