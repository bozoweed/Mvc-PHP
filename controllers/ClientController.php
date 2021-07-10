<?php

class ClientController
{
    private $_loginManager;
    private $_clientManager;
    private $_clients;
    private $_view;

    public function __construct($url){
        if(isset($url)){      
            $this->_loginManager = new LoginManager;
            $this->_clientManager = new ClientManager;
            $this->_view = new View("Client");
                     
            $this->_loginManager->kickOffIfLoginState(false);       
            $this->verifyGet($url);
            $error =$this->verifyPost();
            $this->generate( $error);
        }else
            throw new Exception("Page introuvable");
    }

    private function generate($error){ 
        $this->_clients = $this->_clientManager->getAll();
        $this->_view->generate(array("clients"=>$this->_clients, "error"=> $error!="" ? $error: null));    
    }
   
    private function verifyPost(){
        if(isset($_POST["submit"]) ){
            if(!isset($_POST["name"]) && $_POST["name"] =="")
                return "Merci de saisir un nom.";                
            if(!isset($_POST["lastName"]) && $_POST["lastName"] =="")
                return "Merci de saisir un prénom.";
            if(!isset($_POST["email"]) && $_POST["email"] =="")
                return "Merci de saisir un email.";
            if(!isset($_POST["phoneNumber"]) && $_POST["phoneNumber"] =="")
                return "Merci de saisir un numéro de téléphone.";
            if(!isset($_POST["deliveryAddress"]) && $_POST["deliveryAddress"] =="")
                return "Merci de saisir une adresse de livraison.";
            
            
            $this->_clientManager->create($_POST["email"], $_POST["name"], $_POST["lastName"],$_POST["phoneNumber"], $_POST["society"], $_POST["deliveryAddress"]);
            return '';
            
            
        }
        return '';
    }

    private function verifyGet($url){        
        if(isset($url[1]) && isset($url[2]) && ((int) $url[2] )>0){
            if($url[1] == "archive"){
                $this->_clientManager->archive($url[2]);
            }else if ($url[1] == "unarchive"){
                $this->_clientManager->unarchive($url[2]);
            }
            
            header('Location: '.URL.$url[0]);
        }
    }    
}
