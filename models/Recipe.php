<?php

class Recipe {
    private $_id;
    private $_label;
    private $_description;
    private $_typeId;
    private $_type;
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

    private function setDescription($description){        
        if(is_string($description))
            $this->_description = $description;        
    }

    private function setTypeId($typeId){ //seul la création de l'object permet de changer ce champ pour des raison de sécurité      
        $typeId = (int)$typeId; 
        if($typeId > 0)
            $this->_typeId = $typeId;        
    }
    
    public function setType($types){
        foreach($types as $type)
            if($type->Id() == $this->_typeId){
                $this->_type = $type;
                break;
            }
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
        return  $this->_label;
    }

    public function description(){
        return  $this->_description;
    }

    public function typeId(){
        return  isset($this->_type) ? $this->_type->id() : $this->_typeId;
    }

    public function type(){
        return  $this->_type;
    }

    public function archived(){
        return $this->_archived;
    }

    public function avaible(){
        return !$this->_archived && !$this->_type->archived();
    }

}