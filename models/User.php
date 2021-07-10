<?php

class User {
    private $_id;
    private $_name;
    private $_last_Name;
    private $_email;
    private $_phone_Number;

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

    private function setName($name){        
        if(is_string($name))
            $this->_name = $name;        
    }

    private function setLastName($lastName){        
        if(is_string($lastName))
            $this->_last_Name = $lastName;        
    }

    private function setEmail($email){        
        if(is_string($email))
            $this->_email = $email;        
    }

    private function setPhoneNumber($number){        
        if(is_string($number))
            $this->_phone_Number = $number;        
    }

    //Getter

    public function id(){
        return $this->_id;
    }

    public function name(){
        return $this->_name;
    }

    public function lastName(){
        return  $this->_last_Name;
    }

    public function email(){
        return $this->_email;
    }

    public function phoneNumber(){
        return $this->_phone_Number;
    }
}