<?php

class BillController
{
    private $_loginManager;
    private $_billManager;
    private $_orderManager;
    private $_quoteManager;
    private $_lineManager;
    private $_clientManager;
    private $_beerManager;
    private $_recipeManager;
    private $_typeManager;
    private $_quotes;
    private $_bills;
    private $_orders;
    private $_bill;
    private $_lines;
    private $_clients;
    private $_beers;
    private $_recipes;
    private $_types;
    private $_viewMode="Bill";
    private $_view;

    public function __construct($url){
        if(isset($url)){      
            $this->_loginManager = new LoginManager;
            $this->_loginManager = new LoginManager;
            $this->_clientManager = new ClientManager;
            $this->_quoteManager = new QuoteManager;
            $this->_lineManager = new LineManager;
            $this->_beerManager = new BeerManager;
            $this->_recipeManager = new RecipeManager;
            $this->_typeManager = new TypeManager;   
            $this->_billManager = new BillManager;   
            $this->_orderManager = new OrderManager;   
            $this->_loginManager->kickOffIfLoginState(false);     
            $this->_types = $this->_typeManager->getAll();
            $this->_clients = $this->_clientManager->getAll();
            $this->_recipes = $this->_recipeManager->getBuild($this->_types);//les recettes vont completer leur Type toutes seul pour éviter toutes fail
            $this->_beers = $this->_beerManager->getBuild($this->_recipes);//les bières vont completer leur recette toutes seul pour éviter toutes fail
            $this->_lines = $this->_lineManager->getBuild($this->_beers);//les bières vont completer leur recette toutes seul pour éviter toutes fail 
            $this->_quotes = $this->_quoteManager->getBuild($this->_lines, $this->_clients);//les bières vont completer leur recette toutes seul pour éviter toutes fail   
            $this->_bills = $this->_billManager->getBuild($this->_lines, $this->_clients, $this->_quotes);//les bières vont completer leur recette toutes seul pour éviter toutes fail   
            $this->_orders = $this->_orderManager->getBuild($this->_bills);//les bières vont completer leur recette toutes seul pour éviter toutes fail   
            $this->verifyGet($url);
            $error =$this->verifyPost();
            
            $this->_view = new View($this->_viewMode);         
            $this->generate( $error);
        }else
            throw new Exception("Page introuvable");
    }

    private function generate( $error){         
        if($this->_viewMode == "Bill")
            $this->_view->generate(array( "bills"=>$this->_bills, "clients"=>$this->_clients, "error"=> $error!="" ? $error: null));
        else
            $this->_view->generate(array("bill"=> $this->_bill, "beers"=> $this->_beers, "error"=> $error!="" ? $error: null))    ;
    }
   
    private function verifyPost(){
        if($this->_viewMode=="BillEdit")
        {
            if(isset($_POST["submit"]) ){
                if(!isset($_POST["beer"]) && $_POST["beer"] =="")
                    return "Merci de saisir une bière."; 
                if(!isset($_POST["quantity"]) && $_POST["quantity"] ==""  || (int)$_POST["quantity"] <=0)
                    return "Merci de saisir une quantité.";                           
                if(! $this->_beerManager->isValid($_POST["beer"]))
                    return "Bière Invalid.";    
                $lineId= $this->_lineManager->create($_POST["beer"], $_POST["quantity"], $_POST["discount"]);           
                if(!$this->_billManager->addLineToBill($lineId, $this->_bill->id())){
                    $this->_lineManager->delete($lineId);
                }
                header('Location: '.URL."bill/edit/".$this->_bill->id());
                exit;
            }
        }else{
            if(isset($_POST["submit"]) ){
                if(!isset($_POST["client"]) && $_POST["client"] =="")
                    return "Merci de saisir un client.";                
                if(! $this->_clientManager->isValid($_POST["client"]))
                    return "Client Invalid.";                     
                $id = $this->_billManager->create($_POST["client"]);
                header('Location: '.URL."bill/edit/".$id);
                exit;
            }
        }
        return '';
    }

    private function verifyGet($url){        
        if(isset($url[1]) && isset($url[2])){
            if($this->_billManager->isValid($url[2])){
                switch($url[1]){
                    case "archive":
                        $this->_billManager->archive($url[2]);
                        header('Location: '.URL.$url[0]);
                        break;
                    case "unarchive":
                        $this->_billManager->unarchive($url[2]);
                        header('Location: '.URL.$url[0]);
                        break;
                    case "edit":
                        $this->_bill = $this->_billManager->getById($url[2]);

                        if(isset($url[3]) && isset($url[4]))
                        {
                            if($url[3]=="delete" && $this->_lineManager->isValid($url[4]))
                            {

                                if($this->_billManager->removeLineToBill($url[4], $this->_bill->id())){
                                    $this->_lineManager->delete($url[4]);
                                    header('Location: '.URL."bill/edit/".$this->_bill->id());
                                    exit;
                                };
                                
                            }
                        }
                        $this->_viewMode = "BillEdit";
                        
                        break;
                    case "payed":
                        $bill =$this->_billManager->getById($url[2]);
                        
                        $order =$this->_orderManager->getByBillId($bill->id());                        
                        $orderId=0;
                        if($order != null){
                            $orderId = $order->id();
                        }else{
                            if(!$bill->payed()){
                                $this->_billManager->payed($url[2]);
                                $orderId = $this->_orderManager->create($bill->id());
                            }
                        }
                        if($orderId>0){
                            header('Location: '.URL."order/view/".$orderId);
                            exit;
                        }
                        
                        break;
                }  
            }
        }
    }
}