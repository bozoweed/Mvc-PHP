<?php

class QuoteController
{
    private $_loginManager;
    private $_billManager;
    private $_quoteManager;
    private $_lineManager;
    private $_clientManager;
    private $_beerManager;
    private $_recipeManager;
    private $_typeManager;
    private $_quotes;
    private $_bills;
    private $_quote;
    private $_lines;
    private $_clients;
    private $_beers;
    private $_recipes;
    private $_types;
    private $_viewMode="Quote";
    private $_view;

    public function __construct($url){
        if(isset($url)){      
            $this->_loginManager = new LoginManager;
            $this->_clientManager = new ClientManager;
            $this->_quoteManager = new QuoteManager;
            $this->_lineManager = new LineManager;
            $this->_beerManager = new BeerManager;
            $this->_recipeManager = new RecipeManager;
            $this->_typeManager = new TypeManager;   
            $this->_billManager = new BillManager;   
            $this->_loginManager->kickOffIfLoginState(false);     
            $this->_types = $this->_typeManager->getAll();
            $this->_clients = $this->_clientManager->getAll();
            $this->_recipes = $this->_recipeManager->getBuild($this->_types);//les recettes vont completer leur Type toutes seul pour éviter toutes fail
            $this->_beers = $this->_beerManager->getBuild($this->_recipes);//les bières vont completer leur recette toutes seul pour éviter toutes fail
            $this->_lines = $this->_lineManager->getBuild($this->_beers);//les bières vont completer leur recette toutes seul pour éviter toutes fail 
            $this->_quotes = $this->_quoteManager->getBuild($this->_lines, $this->_clients);//les bières vont completer leur recette toutes seul pour éviter toutes fail   
            $this->_bills = $this->_billManager->getBuild($this->_lines, $this->_clients, $this->_quotes);//les bières vont completer leur recette toutes seul pour éviter toutes fail   
            $this->verifyGet($url);
            $error =$this->verifyPost();
            
            $this->_view = new View($this->_viewMode);         
            $this->generate( $error);
        }else
            throw new Exception("Page introuvable");
    }

    private function generate( $error){         
        if($this->_viewMode == "Quote")
            $this->_view->generate(array( "quotes"=>$this->_quotes, "clients"=>$this->_clients, "error"=> $error!="" ? $error: null));
        else
            $this->_view->generate(array("quote"=> $this->_quote, "beers"=> $this->_beers, "error"=> $error!="" ? $error: null))    ;
    }
   
    private function verifyPost(){
        if($this->_viewMode=="QuoteEdit")
        {
            if(isset($_POST["submit"]) ){
                $bill =$this->_billManager->getByQuoteId( $this->_quote->id());
                if($bill != null){
                    header('Location: '.URL."quote/edit/".$this->_quote->id());
                    exit;
                }
                if(!isset($_POST["beer"]) && $_POST["beer"] =="")
                    return "Merci de saisir une bière."; 
                if(!isset($_POST["quantity"]) && $_POST["quantity"] ==""  || (int)$_POST["quantity"] <=0)
                    return "Merci de saisir une quantité.";                           
                if(! $this->_beerManager->isValid($_POST["beer"]))
                    return "Bière Invalid.";    
                $lineId= $this->_lineManager->create($_POST["beer"], $_POST["quantity"], $_POST["discount"]);           
                if(!$this->_quoteManager->addLineToQuote($lineId, $this->_quote->id())){
                    $this->_lineManager->delete($lineId);
                }
                header('Location: '.URL."quote/edit/".$this->_quote->id());
                exit;
            }
        }else{
            if(isset($_POST["submit"]) ){
                if(!isset($_POST["client"]) && $_POST["client"] =="")
                    return "Merci de saisir un client.";                
                if(! $this->_clientManager->isValid($_POST["client"]))
                    return "Client Invalid.";                     
                $id = $this->_quoteManager->create($_POST["client"]);
                header('Location: '.URL."quote/edit/".$id);
                exit;
            }
        }
        return '';
    }

    private function verifyGet($url){        
        if(isset($url[1]) && isset($url[2])){
            if($this->_quoteManager->isValid($url[2])){
                switch($url[1]){
                    case "archive":
                        $this->_quoteManager->archive($url[2]);
                        header('Location: '.URL.$url[0]);
                        break;
                    case "unarchive":
                        $this->_quoteManager->unarchive($url[2]);
                        header('Location: '.URL.$url[0]);
                        break;
                    case "edit":
                        if($this->_quoteManager->isValid($url[2])){
                            $this->_quote = $this->_quoteManager->getById($url[2]);
                            $bill =$this->_billManager->getByQuoteId( $this->_quote->id());
                            if($bill == null && isset($url[3]) && isset($url[4]))
                            {
                                if($url[3]=="delete" && $this->_lineManager->isValid($url[4]))
                                {

                                    if($this->_quoteManager->removeLineToQuote($url[4], $this->_quote->id())){
                                        $this->_lineManager->delete($url[4]);
                                        header('Location: '.URL."quote/edit/".$this->_quote->id());
                                        exit;
                                    };
                                    
                                }
                            }
                            $this->_viewMode = "QuoteEdit";
                        }
                        break;
                    case "bill":
                        if($this->_quoteManager->isValid($url[2])){
                            $bill =$this->_billManager->getByQuoteId($url[2]);
                            $billId=0;
                            if($bill != null){
                                $billId = $bill->id();
                            }else{
                                $quote =$this->_quoteManager->getById($url[2]);
                                $billId = $this->_billManager->create($quote->client()->id(), $quote->id(), $quote->formatDbLine());
                            }
                            if($billId>0){
                                header('Location: '.URL."bill/edit/".$billId);
                                exit;
                            }
                        }
                        break;
                }  
            }
        }
    }
}
