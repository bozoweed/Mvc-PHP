<?php
class QuoteManager extends Model{

   private $_quotes;

   private function getAll(){
      if(!isset($this->_quotes))
         $this->_quotes = $this->fetch("select * from quote", "Quote",[]);      
      return $this->_quotes;
   }    

   public function create($clientId){
      return $this->insert("insert into quote ( ClientId, CreateDate, Archived) values( ?, ?, 0)", [$clientId, date("d/m/y")]);
   }

   public function archive($id){
      $this->update("update quote set Archived=1 where Id=?", [$id]);
   }

   public function unarchive($id){
      $this->update("update quote set Archived=0 where Id=?", [$id]);
   }

   public function getBuild($_lines, $_clients){
      foreach($this->getAll() as $quote){
         $quote->setLines($_lines);
         $quote->setClient($_clients);
      }
      return $this->getAll();
   }

   public function getById($id){
      foreach($this->getAll() as $quote)
         if($quote->id() == $id)
            return $quote;
   }
   
   public function addLineToQuote($lineId, $quoteId){
      if(!isset($this->_quotes))
         throw new Exception("Quotes not define", 1);
      foreach($this->getAll() as $quote)
         if($quote->id() == $quoteId){
            if($quote->archived())
               return false;
            $quote->addLineId($lineId);
            $this->update("update quote set LinesId=? where Id=?", [ $quote->formatDbLine(), $quote->id()]);
            return true;
         }
      return false;
   }

   public function removeLineToQuote($lineId, $quoteId){
      if(!isset($this->_quotes))
         throw new Exception("Quotes not define", 1);
      foreach($this->getAll() as $quote)
         if($quote->id() == $quoteId){
            if($quote->archived())
               return false;
            $quote->removeLineId($lineId);
            $this->update("update quote set LinesId=? where Id=?", [ $quote->formatDbLine(), $quote->id()]);
            return true;
         }
      return false;
   }

   public function isValid($id){
      foreach($this->getAll() as $_quote)
          if($_quote->id() == $id)
              return true;
      return false;
   }

}