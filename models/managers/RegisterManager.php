<?php
class RegisterManager extends Model{
    
    public function checkEmail($email){
        $accounts = $this->fetch("select * from user where Email=?", "User", array($email));
        return count($accounts)>0;
    }
    
    public function register($email, $password, $name, $lastName,  $phoneNumber){       
        return $this->insert("insert into user (Email, Password, Name, LastName, PhoneNumber) values(?, ?, ?, ?, ?)",  array($email, md5($password), $name, $lastName,  $phoneNumber));
    }   

}