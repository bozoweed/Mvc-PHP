<?php
abstract class Model{
    private static $_bdd;
    //instance de connexion bdd
    private static function setBdd(){
        self::$_bdd = (new Config)->getDdbConnexion();
        self::$_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    //récupérer la connexion;
    protected function getBdd(){
        if(self::$_bdd == null)
            self::setBdd();
        return self::$_bdd;
    }
    //fonction utile pour tous les select
    protected function fetch($request, $object ,$arguments =[]){
        $var = [];
        $requestPrepare = self::getBdd()->prepare($request);
        $requestPrepare->execute($arguments);
        while($data = $requestPrepare->fetch(PDO::FETCH_ASSOC)){
            $var[] = new $object($data);
        }
        $requestPrepare->closeCursor();
        return $var;
    }
    
    //fonction utile pour tous les insert
    protected function insert($request, $arguments =[] ){
        $requestPrepare = self::getBdd()->prepare($request);
        $requestPrepare->execute($arguments);
        $id= self::getBdd()->lastInsertId();
        $requestPrepare->closeCursor();
        return $id;
    }
    
    //fonction utile pour tous les update
    protected function update($request, $arguments =[] ){
        $requestPrepare = self::getBdd()->prepare($request);
        $requestPrepare->execute($arguments);
        $requestPrepare->closeCursor();
    }
}
