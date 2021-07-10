<?php
class RecipeManager extends Model{

   private $_recipes;

   private function getAll(){
      if(!isset($this->_recipes))
         $this->_recipes = $this->fetch("select * from recipe", "Recipe",[]);      
      return $this->_recipes;
   }    

   public function create($label, $typeId, $description){
      $this->insert("insert into recipe ( Label, TypeId, Description, Archived) values( ?, ?, ?, 0)", [$label, $typeId, $description]);
   }

   public function archive($id){
      $this->update("update recipe set Archived=1 where Id=?", [$id]);
   }

   public function unarchive($id){
      $this->update("update recipe set Archived=0 where Id=?", [$id]);
   }

   public function isValid($id){
      foreach($this->getAll() as $_recipe)
          if($_recipe->id() == $id)
              return true;
      return false;
   }

   public function getBuild($_types){
      foreach($this->getAll() as $recipe)
         $recipe->setType($_types);
      return $this->getAll();
   } 

}