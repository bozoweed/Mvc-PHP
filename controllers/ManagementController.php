<?php

class ManagementController
{
    private $_loginManager;
    private $_view;

    public function __construct($url){
        if(isset($url)){
            $this->_loginManager = new LoginManager;
            $this->_view = new View("Management");
            
            $this->_loginManager->kickOffIfLoginState(false);     
            $this->generate();
        }else
            throw new Exception("Page introuvable");
    }

    private function generate(){
       
        $this->_view->generate();
    }
}
