<?php
class LoginManager extends Model{

    public function login($email, $password){
        $accounts = $this->fetch("select * from user where Password = ? and Email=?", "User", array(md5($password) ,$email));        
        if(count($accounts)>0){
            $_SESSION["Account"] = array(
                'name'=>$accounts[0]->name(),
                'lastName'=>$accounts[0]->lastName(),
                'email'=>$accounts[0]->email(),
                'phoneNumber'=>$accounts[0]->phoneNumber(),
                'id'=>$accounts[0]->id(),
            );
        }
    }
    

    public function isLogged(){
        if(isset($_SESSION["Account"])){
            return true;
        }else{
            return false;
        }
    }
    
    public function isFirstAccount(){
        $accounts = $this->fetch("select * from user", "User", array());
        return count($accounts)==0;
    }

    public function logout(){
        session_destroy();
        session_start();
    }

    public function kickOffIfLoginState($state){
        if($this->isLogged() == $state){
            header('Location: '.URL);
            exit;
        }   
    }

}