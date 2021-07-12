<?php

class OrderController
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
    private $_order;
    private $_lines;
    private $_clients;
    private $_beers;
    private $_recipes;
    private $_types;
    private $_viewMode="Order";
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
        if($this->_viewMode == "Order")
            $this->_view->generate(array( "orders"=>$this->_orders,  "error"=> $error!="" ? $error: null));
        else
            $this->_view->generate(array( "order"=> $this->_order, "error"=> $error!="" ? $error: null));
    }
   
    private function verifyPost(){        
        return '';
    }

    private function verifyGet($url){        
        if(isset($url[1]) && isset($url[2])){
            if($this->_orderManager->isValid($url[2])){
                switch($url[1]){
                    case "archive":
                        $this->_orderManager->archive($url[2]);
                        header('Location: '.URL.$url[0]);
                        break;
                    case "unarchive":
                        $this->_orderManager->unarchive($url[2]);
                        header('Location: '.URL.$url[0]);
                        break;
                    case "view":
                        $this->_order = $this->_orderManager->getById($url[2]);                      
                        $this->_viewMode = "OrderEdit";                        
                        break;                   
                }  
            }
        }
    }
}