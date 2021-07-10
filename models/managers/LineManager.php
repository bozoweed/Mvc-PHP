<?php
class LineManager extends Model{

   private $_lines;

   private function getAll(){
      if(!isset($this->_lines))
         $this->_lines = $this->fetch("select * from line", "Line",[]);      
      return $this->_lines;
   }    

   public function create($beerId, $quantity, $discount){
      return $this->insert("insert into line ( BeerId, Quantity, Discount) values( ?, ?, ?)", [$beerId, $quantity, $discount]);
   }

   public function delete($id){
      $this->update("delete from line where Id=?", [$id]);
   }

   public function getBuild($_beers){
      foreach($this->getAll() as $line)
         $line->setBeer($_beers);      
      return $this->getAll();
   } 
   
   public function isValid($id){
      foreach($this->getAll() as $_line)
          if($_line->id() == $id)
              return true;
      return false;
   }

}