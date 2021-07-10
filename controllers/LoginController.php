<?php

class LoginController
{
    private $_loginManager;
    private $_view;

    public function __construct($url){
        if(isset($url)){      
            $this->_loginManager = new LoginManager;
            $this->_view = new View("Login");
            if($this->_loginManager->isFirstAccount()){
                header('Location: '.URL.'register');
                exit;
            }
            if(isset($url[1]) && $url[1]=="logout")  {
                $this->_loginManager->logout();
                header('Location: '.URL);
                exit;
            }     
            $this->_loginManager->kickOffIfLoginState(true);
            $this->verifyPost();
            $this->generate($url);
        }else
            throw new Exception("Page introuvable");
    }

    private function generate($url){        
        $this->_view->generate();
    }

    private function verifyPost(){        
        if(isset($_POST["submit"])){
            $this->login($_POST["email"], $_POST["password"]);            
            exit;
        }
    }

    private function login($email, $password){
        $this->_loginManager->login($email, $password);
        if($this->_loginManager->isLogged()){
            header('Location: '.URL);
            exit;
        }else
            $this->_view->generate(array("error"=> "identifiant/mot de pass invalid"));
    }
}
