<?php
class BillManager extends Model{

   private $_bills;

   private function getAll(){
      if(!isset($this->_bills))
         $this->_bills = $this->fetch("select * from bill", "Bill",[]);      
      return $this->_bills;
   }    

   public function create($clientId, $quoteId=0, $linesId=""){
      return $this->insert("insert into bill ( LinesId, QuoteId, ClientId,  CreateDate, Payed, Archived) values( ?, ?, ?, ?, 0, 0)", [$linesId, $quoteId, $clientId, date("d/m/y")]);
   }

   public function archive($id){
      $this->update("update bill set Archived=1 where Id=?", [$id]);
   }

   public function unarchive($id){
      $this->update("update bill set Archived=0 where Id=?", [$id]);
   }

   public function payed($id){
      $this->update("update bill set Payed=1 where Id=?", [$id]);
   }

   public function getBuild($_lines, $_clients, $_quotes){
      foreach($this->getAll() as $bill){
         $bill->setLines($_lines);
         $bill->setClient($_clients);
         $bill->setQuote($_quotes);
      }
      return $this->getAll();
   }

   public function getById($id){
      foreach($this->getAll() as $bill)
         if($bill->id() == $id)
            return $bill;
   }

   public function getByQuoteId($id){
      foreach($this->getAll() as $bill)
         if($bill->hadQuote()&& $bill->quote()->id() == $id)
            return $bill;
   }
   
   public function addLineToBill($lineId, $billId){
      if(!isset($this->_bills))
         throw new Exception("Bills not define", 1);
      foreach($this->getAll() as $bill)
         if($bill->id() == $billId){
            if($bill->archived() || $bill->payed() || $bill->hadQuote())
               return false;
            $bill->addLineId($lineId);
            $this->update("update bill set LinesId=? where Id=?", [ $bill->formatDbLine(), $bill->id()]);
            return true;
         }
      return false;
   }

   public function removeLineToBill($lineId, $billId){
      if(!isset($this->_bills))
         throw new Exception("Bills not define", 1);
      foreach($this->getAll() as $bill)
         if($bill->id() == $billId){
            if($bill->archived()|| $bill->payed() || $bill->hadQuote())
               return false;
            $bill->removeLineId($lineId);
            $this->update("update bill set LinesId=? where Id=?", [ $bill->formatDbLine(), $bill->id()]);
            return true;
         }
      return false;
   }

   public function isValid($id){
      foreach($this->getAll() as $_bill)
          if($_bill->id() == $id)
              return true;
      return false;
   }

}