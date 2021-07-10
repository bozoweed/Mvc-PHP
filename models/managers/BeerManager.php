<?php
class BeerManager extends Model{

   private $_recipes;

   private function getAll(){
      if(!isset($this->_recipes))
         $this->_recipes = $this->fetch("select * from beer", "beer",[]);      
      return $this->_recipes;
   }    

   public function create($label, $recipeId, $price, $description, $alcoolLevel){
      $this->insert("insert into beer ( Label, RecipeId, Price, Description, ProductDate, AlcoolLevel, Archived) values( ?, ?, ?, ?, ?, ?, 0)", [$label, $recipeId, $price ,$description, date("d/m/y"), $alcoolLevel]);
   }

   public function archive($id){
      $this->update("update beer set Archived=1 where Id=?", [$id]);
   }

   public function unarchive($id){
      $this->update("update beer set Archived=0 where Id=?", [$id]);
   }

   public function isValid($id){
      foreach($this->getAll() as $beer)
          if($beer->id() == $id)
              return true;
      return false;
   }

   public function getBuild($_recipes){
      foreach($this->getAll() as $beer)
         $beer->setRecipe($_recipes);
      return $this->getAll();
   } 

}