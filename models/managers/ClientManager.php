<?php
class ClientManager extends Model
{

    private $_clients;

    public function getAll(){
        if(!isset($this->_clients))
            $this->_clients= $this->fetch("select * from client", "Client");
       return $this->_clients;
    }
    
    public function create($email, $name, $lastName,  $phoneNumber, $society, $deliveryAddress){       
        return $this->insert("insert into client (Email, Name, LastName, PhoneNumber, Society, DeliveryAddress, Archived) values(?, ?, ?, ?, ?, ?, 0)",  array($email, $name, $lastName,  $phoneNumber, $society, $deliveryAddress));
    }   

    public function archive($id){
        $this->update("update client set Archived=1 where Id=?", [$id]);
     }
  
    public function unarchive($id){
       $this->update("update client set Archived=0 where Id=?", [$id]);
    }

    public function isValid($id){
       foreach($this->getAll() as $_client)
           if($_client->id() == $id)
               return true;
       return false;
    }
}