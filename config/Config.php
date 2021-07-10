<?php

class Config{
    private $_host = "localhost";
    private $_database = "mon_site";
    private $_username = "root";
    private $_password = "";
    private $_siteName = "La Brasserie 420";

    public function getDdbConnexion()
    {
        return new PDO("mysql:host=".$this->_host.";dbname=".$this->_database.";charset=utf8", $this->_username, $this->_password);
    }

    public function getSiteName()
    {
        return $this->_siteName;
    }
}
