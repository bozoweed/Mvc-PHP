<?php

class BeerController
{
    private $_loginManager;
    private $_beerManager;
    private $_recipeManager;
    private $_typeManager;
    private $_beers;
    private $_recipes;
    private $_types;
    private $_view;

    public function __construct($url){
        if(isset($url)){      
            $this->_loginManager = new LoginManager;
            $this->_beerManager = new BeerManager;
            $this->_recipeManager = new RecipeManager;
            $this->_typeManager = new TypeManager;
            $this->_view = new View("Beer");            
            $this->_loginManager->kickOffIfLoginState(false);        
            $this->verifyGet($url);
            $error =$this->verifyPost();
            $this->generate( $error);
        }else
            throw new Exception("Page introuvable");
    }

    private function generate($error){ 
        $this->_types = $this->_typeManager->getAll();
        $this->_recipes = $this->_recipeManager->getBuild($this->_types);//les recettes vont completer leur Type toutes seul pour éviter toutes fail
        $this->_beers = $this->_beerManager->getBuild($this->_recipes);//les bières vont completer leur recette toutes seul pour éviter toutes fail
        $this->_view->generate(array( "recipes"=>$this->_recipes, "beers"=>$this->_beers, "error"=> $error!="" ? $error: null));    
    }
   
    private function verifyPost(){
        if(isset($_POST["submit"]) ){
            if(!isset($_POST["description"]) && $_POST["description"] =="")
                return "Merci de saisir une description de bière.";                
            if(!isset($_POST["recipe"]) && $_POST["recipe"] =="")
                return "Merci de saisir une Recette de bière.";
            if(!isset($_POST["price"]) && $_POST["price"] =="")
                return "Merci de saisir un prix.";
            if(!isset($_POST["alcoolLevel"]) && $_POST["alcoolLevel"] =="")
                return "Merci de saisir un degrè d'alcool.";
            if(!$this->_recipeManager->isValid((int)$_POST["recipe"]))
                return 'Recette de bière invalid';
            if(isset($_POST["label"]) && strlen($_POST["label"]) >0){                
                $this->_beerManager->create($_POST["label"], $_POST["recipe"], $_POST["price"], $_POST["description"], $_POST["alcoolLevel"]); 
                return '';
            }
            else{                
                return "Merci de saisir un label.";
            } 
        }
        return '';
    }

    private function verifyGet($url){        
        if(isset($url[1]) && isset($url[2]) && ((int) $url[2] )>0){
            if($this->_beerManager->isValid($url[2])){
                if($url[1] == "archive"){
                    $this->_beerManager->archive($url[2]);
                }else if ($url[1] == "unarchive"){
                    $this->_beerManager->unarchive($url[2]);
                }
            }
            header('Location: '.URL.$url[0]);
        }
    }
}
