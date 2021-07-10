<?php
class AccueilController
{
    private $_loginManager;
    private $_view;
    private $_acceuil;

    public function __construct($url){
        if(isset($url)){
            $this->_loginManager = new LoginManager;
            if($this->_loginManager->isFirstAccount()){
                header('Location: '.URL.'register');
                exit;
            }
            //$this->_acceuil = $this-> _AcceuilManager->getAcceuil();
            $this->_view = new View("Accueil");
            $this->acceuil();
        }else
            throw new Exception("Page introuvable");
    }

    private function acceuil(){
        $this->_view->generate();
    }
}