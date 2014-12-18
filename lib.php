<?php 
function _t($k){
    global $voca;
    global $lang;
    if(array_key_exists($k, $voca)){
        return $voca[$k][$lang];
    }
    return " ";
}

function getOnlineUsers(){
    global $user;
    $users = $user->getAll();
    $online = array();
    if(isset($_SESSION['username']))
        $myName = $_SESSION['username'];
    else
        $myName = "";
    if(count($users)){
        foreach ($users as $u){
            if(time() - $u['last_activity'] < 5 * 60 && $u['name'] != $myName)
                $online[] = $u['name'];
        }
    }
    return $online;
}

function last($arr,$number){
    $i = count($arr);
    if($i <= $number)
        return $arr;
    $result = array();
    while($number > 0){
        $result[$number] = $arr[$i];
        $i --;
        $number --;
    }
    return $result;
}