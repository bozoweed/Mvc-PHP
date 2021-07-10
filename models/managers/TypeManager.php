<?php
class TypeManager extends Model{

   private $_types;
   
   public function getAll(){
      if(!isset($this->_types))
         $this->_types= $this->fetch("select * from type", "Type",[]);      
      return $this->_types;
   }
    

   public function create($label){
      $this->insert("insert into type ( Label, Archived) values( ?, 0)", [$label]);
   }

   public function archive($id){
      $this->update("update type set Archived=1 where Id=?", [$id]);
   }

   public function unarchive($id){
      $this->update("update type set Archived=0 where Id=?", [$id]);
   }

   public function isValid($id){
      foreach($this->getAll() as $_type)
          if($_type->id() == $id)
              return true;
      return false;
  }

}