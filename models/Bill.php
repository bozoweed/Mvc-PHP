<?php

class Bill {
    private $_id;
    private $_linesId = array();
    private $_clientId;
    private $_quoteId;
    private $_createDate;
    private $_lines = array();
    private $_client;
    private $_quote;
    private $_payed;
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

    private function setClientId($clientId){       
        $clientId = (int)$clientId; 
        if($clientId >0)
            $this->_clientId = $clientId;        
    }

    private function setLinesId($linesId){    
        if(is_string($linesId) && strlen($linesId)>0)           
            $this->_linesId = explode(';', $linesId );
    }

    private function setQuoteId($quoteId){       
        $quoteId = (int)$quoteId; 
        if($quoteId >0)
            $this->_quoteId = $quoteId;        
    }


    private function setCreateDate($createDate){      
        if(is_string($createDate))
            $this->_createDate = $createDate;        
    }

    private function setPayed($payed){       
        $payed = (int)$payed; 
        if($payed >0)
            $this->_payed = $payed;        
    }

    private function setArchived($archived){       
        $archived = (int)$archived; 
        if($archived >0)
            $this->_archived = $archived;        
    }

    public function setLines($lines){        
        foreach($lines as $line)
            if(in_array($line->id() , $this->_linesId))
                $this->_lines[] = $line;
    }

    public function setClient($clients){        
        foreach($clients as $client)
            if($client->id() == $this->_clientId)
                $this->_client = $client;
                  
    }

    public function setQuote($quotes){        
        foreach($quotes as $quote)
            if($quote->id() == $this->_quoteId)
                $this->_quote = $quote;
                  
    }

    public function addLineId($lineId){
        $lineId = (int)$lineId; 
        if($lineId >0)
            $this->_linesId[] = $lineId;
    }

    public function removeLineId($lineId){
        $lineId = (int)$lineId; 
        if($lineId >0)
            $this->_linesId = array_diff($this->_linesId , [$lineId]);
    }

    //Getter

    public function id(){
        return $this->_id;
    }

    public function lines(){
        return $this->_lines;
    }

    public function client(){
        return  $this->_client;
    }

    public function quote(){
        return  $this->_quote;
    }

    public function createDate(){
        return  $this->_createDate;
    }

    public function payed(){
        return  $this->_payed;
    }

    public function formatDbLine(){
        return implode(";", $this->_linesId);
    }

    public function totalPrice(){
        $price = 0;
        foreach($this->_lines as $line)
            if($line->beer()->avaible())
                $price = $price + $line->price();
        return $price;        
    }
    
    public function beersAvaible(){
        foreach($this->_lines as $line)
            if(!$line->beer()->avaible())
                return false;
        return true;
    }

    public function hadQuote()
    {
        return isset($this->_quote);
    }

    public function archived(){
        return $this->_archived;
    }
    
    public function avaible(){
        return !$this->_archived && (!$this->hadQuote() || $this->_quote->beersAvaible()) && !$this->_client->archived();
    }
}