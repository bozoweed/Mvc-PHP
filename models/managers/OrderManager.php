<?php
class OrderManager extends Model{

   private $_orders;

   private function getAll(){
      if(!isset($this->_orders))
         $this->_orders = $this->fetch("select * from orders", "Order",[]);      
      return $this->_orders;
   }    

   public function create( $billId){
      return $this->insert("insert into orders (BillId, CreateDate, Archived) values( ?, ?, 0)", [$billId, date("d/m/y")]);
   }

   public function archive($id){
      $this->update("update orders set Archived=1 where Id=?", [$id]);
   }

   public function unarchive($id){
      $this->update("update orders set Archived=0 where Id=?", [$id]);
   }

   public function getBuild($_bills){
      foreach($this->getAll() as $order)
         $order->setBill($_bills);      
      return $this->getAll();
   }

   public function getById($id){
      foreach($this->getAll() as $order)
         if($order->id() == $id)
            return $order;
   }

   public function getByBillId($id){
      foreach($this->getAll() as $order)
         if($order->bill()->id() == $id)
            return $order;
   }  

   public function isValid($id){
      foreach($this->getAll() as $order)
          if($order->id() == $id)
              return true;
      return false;
   }

}