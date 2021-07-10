<?php
class View{

    private $_file;
    private $_t;
    private $_content;
    private $_view;
    private $_loginManager;
    private $_creditential;

    public function __construct($action){
        $this->_file = "views/View".$action.".php";    
        $this->_t = ucfirst($action);    
    }

    //génération de la view
    public function generate($data =[]){
        //partie spécifique
        $this->_content = $this->generateFile($this->_file, $data);

        //partie générale
        $this->_loginManager= new LoginManager;// on prépar la vérification si le user est connecter
        $this->_view = $this->generateFile('views/Template.php', array("t"=> $this->_t, "content"=>$this->_content,  "isLogged"=>$this->_loginManager->isLogged(), "siteName"=> (new Config)->getSiteName()));
        echo $this->_view;
    }

    //génére le fichier vue et renvoie le resultat
    private function generateFile($file, $data){
        if(file_exists($file)){
            extract($data);
            ob_start();
            //on inclue la view
            require $file;

            return ob_get_clean();
        }else
            throw new Exception("fichier ".$file." introuvable");
    }
}