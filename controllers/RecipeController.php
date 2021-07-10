<?php

class RecipeController
{
    private $_loginManager;
    private $_recipeManager;
    private $_typeManager;
    private $_recipes;
    private $_types;
    private $_view;

    public function __construct($url){
        if(isset($url)){      
            $this->_loginManager = new LoginManager;
            $this->_recipeManager = new RecipeManager;
            $this->_typeManager = new TypeManager;
            $this->_view = new View("Recipe");
            
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
        $this->_view->generate(array("types"=>$this->_types, "recipes"=>$this->_recipes, "error"=> $error!="" ? $error: null));    
    }
   
    private function verifyPost(){
        if(isset($_POST["submit"]) ){
            if(!isset($_POST["description"]) && $_POST["description"] =="")
                return "Merci de saisir une description de recette.";                
            if(!isset($_POST["type"]) && $_POST["type"] =="")
                return "Merci de saisir un type de bière.";
            if(!$this->_typeManager->isValid((int)$_POST["type"]))
                return 'Type de bière invalid';
            if(isset($_POST["label"]) && strlen($_POST["label"]) >0){
                $this->_recipeManager->create($_POST["label"], $_POST["type"], $_POST["description"]); 
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
            if($this->_recipeManager->isValid($url[2])){
                if($url[1] == "archive"){
                    $this->_recipeManager->archive($url[2]);
                }else if ($url[1] == "unarchive"){
                    $this->_recipeManager->unarchive($url[2]);
                }
            }
            header('Location: '.URL.$url[0]);
        }
    }    
}
