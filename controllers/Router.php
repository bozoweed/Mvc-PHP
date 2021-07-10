<?php
class Router{

    private $_ctrl;
    private $_view;

    public function __construct()
    {
        
        session_start();
        try
        {
            
            spl_autoload_register(function($class){//charge automatiquement les classes
                try{
                    $File ="";
                    //on défini les emplacements de chargement des class 
                    switch($class){
                        case'Config'://cas spécial
                            $File='config/'.$class.'.php';
                            break;
                        case'View'://cas spécial
                            $File='views/'.$class.'.php';
                            break;
                        default:
                            if(str_contains($class, "Controller")){
                                $File='controllers/'.$class.'.php';
                            }else if(str_contains($class, "Manager")){
                                $File='models/managers/'.$class.'.php';
                            }else{
                                $File='models/'.$class.'.php';
                            }
                            break;
                    }
                    
                    if(!file_exists( $File ))
                        throw new Exception("Impossible de charger la class ".$class ." a l'emplacement ".$File);
                    require_once($File);  
                }catch(Exception $e)
                {
                    $this->_view = new View("Error");
                    $this->_view->generate(array("errorMSG"=> $e->getMessage() ));
                    exit;
                }
                
            });

            $url = "";
            $controller = "Accueil";
            // on inclus le controller selon l'action souhaiter
            if(isset($_GET["url"]))
            {
                
                $url = explode('/', filter_var($_GET["url"], FILTER_SANITIZE_URL));

                $controller = ucfirst(strtolower($url[0]));
            }
            $this->loadController( $controller, $url);
            
        }
        catch(Throwable  $e)
        {
            $this->_view = new View("Error");
            $this->_view->generate(array("errorMSG"=> $e->getMessage().' dans '.$e->getFile() .' a la ligne '.$e->getLine() ));
            exit;
        }
    }

    // fonction de charge de controlleur
    private function loadController($controller, $url=""){     
        $controllerClass = $controller."Controller";
        $this->_ctrl = new $controllerClass($url);
    }
}