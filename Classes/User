<?php 
class User extends FileHandler{
    public $userName;

    public function sendTo($userName,$text){
        $msg = new Message;
        $msg->add(array(
            'time' => time(),
            'from' => $this->userName,
            'to' => $userName,
            'message' => $text
        ));
        $this->updateLastActivity();
    }

    public function getUserName(){
        return $this->userName;
    }

    public function exists($userName){
        if(! count($this->getByuserName($userName)))
            return false;
        return true;
    }

    public function login($userName){
        $this->userName = $userName;
        $fields = $this->getByName($userName);
        if(empty($fields)){
            $this->add(array(
                'name' => $userName,
                'last_activity' => time()
            ));
        }else{
            $this->updateLastActivity();
        }
    }

    public function updateLastActivity(){
        $this->setWhereName($this->userName,array('last_activity'=>time()));
    }
}
