<?php

class Config{
    private $_host = "localhost";// url de la bdd
    private $_database = "mon_site";// nom de la database
    private $_username = "root";// utilisateur de la databes
    private $_password = "";// mot de passe de l'utilisateur de la databes
    private $_siteName = "La Brasserie 420";// nom du site
    private $_displayArchived = false; // on défini si le site affiche ou pas tous ce qui seras archiver (true/false)

    public function getDdbConnexion()
    {
        return new PDO("mysql:host=".$this->_host.";dbname=".$this->_database.";charset=utf8", $this->_username, $this->_password);
    }

    public function getSiteName()
    {
        return $this->_siteName;
    }

    public function displayArchived()
    {
        return $this->_displayArchived;
    }
}
