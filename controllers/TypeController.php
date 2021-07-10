<?php

class TypeController
{
    private $_loginManager;
    private $_typeManager;
    private $_types;
    private $_view;

    public function __construct($url){
        if(isset($url)){      
            $this->_loginManager = new LoginManager;
            $this->_typeManager = new TypeManager;
            $this->_view = new View("Type");
            
            $this->_loginManager->kickOffIfLoginState(false);     
            $this->verifyGet($url);
            $error =$this->verifyPost();
            $this->generate( $error);
        }else
            throw new Exception("Page introuvable");
    }
    private function generate($error){   
        $this->_types = $this->_typeManager->getAll();   
        $this->_view->generate(array("types"=>$this->_types, "error"=> $error!="" ? $error: null));    
    }

    private function verifyPost(){        
        if(isset($_POST["submit"]) ){
            if(isset($_POST["label"]) && strlen($_POST["label"]) >0){
                $this->_typeManager->create($_POST["label"]); 
                return '';
            }
            else{                
                return "Merci de saisir un label pour votre nouveau type.";
            } 
        }
        return '';
    }

    private function verifyGet($url){        
        if(isset($url[1]) && isset($url[2]) && ((int) $url[2] )>0){
            if($this->_typeManager->isValid($url[2])){
                if($url[1] == "archive"){
                    $this->_typeManager->archive($url[2]);
                }else if ($url[1] == "unarchive"){
                    $this->_typeManager->unarchive($url[2]);
                }
            }
            header('Location: '.URL.$url[0]);
        }
    }    
}
