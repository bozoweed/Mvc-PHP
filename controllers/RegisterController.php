<?php

class RegisterController
{
    private $_loginManager;
    private $_registerManager;
    private $_view;

    public function __construct($url){
        if(isset($url)){    
            $this->_loginManager = new LoginManager;        
            $this->_registerManager = new RegisterManager;  
            $this->_view = new View("Register");
            if(!$this->_loginManager->isLogged()  && !$this->_loginManager->isFirstAccount()){
                header('Location: '.URL);
                exit;
            }   
            $this->verifyPost();
            $this->generate();
        }else
            throw new Exception("Page introuvable");
    }

    private function generate(){   
        $this->_view->generate();
    }    

    private function verifyPost(){
        if(isset($_POST["submit"])){
            if(strlen($_POST["password"]) >7){
                if($_POST["password"] == $_POST["password2"]){
                    if(!$this->_registerManager->checkEmail($_POST["email"])){
                        $this->_registerManager->register($_POST["email"], $_POST["password"], $_POST["name"], $_POST["lastName"], $_POST["phoneNumber"]);
                            $this->_view->generate(array("success"=>"Compte Créer."));             
                    }else               
                        $this->_view->generate(array("error"=>"Email déjà utilsé."));
                }else               
                    $this->_view->generate(array("error"=>"Le mot de passe et la confirmation du mot de passe sont différents."));
            }else               
                $this->_view->generate(array("error"=>"Le mot de passe doit faire au moins 8 characters"));
           
            exit;
        }        
    }
}
