<?php

class Beer {
    private $_id;
    private $_label;
    private $_recipeId;
    private $_description;
    private $_productDate;
    private $_alcoolLevel;
    private $_recipe;
    private $_archived;

    //constructeur
    public function __construct(array $data){
        $this->hydrate($data);
    }

    //hydratation (on vas vérifier si nos setter exist qui eux apporteront un controle sur la donnée)
    private function hydrate(array $data){
        foreach($data as $key => $value){
            $method = "set".ucfirst($key);
            if(method_exists($this, $method))
                $this->$method($value);
        }
    }

    //setter
    private function setId($id){
        $id = (int)$id;
        if($id >0)
            $this->_id = $id;
        
    }

    private function setLabel($label){        
        if(is_string($label))
            $this->_label = $label;        
    }

    private function setRecipeId($recipeId){      
        $recipeId = (int)$recipeId;   
        if($recipeId > 0)
            $this->_recipeId = $recipeId;        
    }

    private function setDescription($description){        
        if(is_string($description))
            $this->_description = $description;        
    }

    private function setProductDate($productDate){        
        if(is_string($productDate))
            $this->_productDate = $productDate;        
    }
    
    private function setAlcoolLevel($alcoolLevel){           
        $alcoolLevel = (double)$alcoolLevel;    
        if($alcoolLevel >0)
            $this->_alcoolLevel = $alcoolLevel;        
    }
    
    private function setPrice($price){           
        $price = (double)$price;    
        if($price >0)
            $this->_price = $price;        
    }
    
    public function setRecipe($recipes){
        foreach($recipes as $recipe)
            if($recipe->Id() == $this->_recipeId){
                $this->_recipe = $recipe;
                break;
            }
    }

    private function setArchived($archived){      
        $archived = (int)$archived;  
        if($archived >0)
            $this->_archived = $archived;        
    }   

    //Getter

    public function id(){
        return $this->_id;
    }

    public function label(){
        return  $this->_label;
    }

    public function description(){
        return  $this->_description;
    }

    public function productDate(){
        return  $this->_productDate;
    }

    public function alcoolLevel(){
        return  $this->_alcoolLevel;
    }

    public function price(){
        return  $this->_price;
    }

    public function recipeId(){
        return  isset($this->_recipe) ? $this->_recipe->id() : $this->_recipeId;
    }

    public function recipe(){
        return  $this->_recipe;
    }

    public function archived(){
        return $this->_archived;
    }

    public function avaible(){
        return !$this->_archived && $this->_recipe->avaible();
    }

}