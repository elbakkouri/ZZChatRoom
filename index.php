<?php
require 'start.php';
$error = false;
if(isset($_GET['request'])){
  switch($_GET['request']){
    case 'lang':
      if(isset($_GET['lang']) && ( $_GET['lang'] == 'en' || $_GET['lang'] == 'fr' )){
        $_SESSION['lang'] = $_GET['lang'];
      }
      header('location: index.php');
    break;
    case 'login':
      $onlineUsers = getOnlineUsers();
      if(count($onlineUsers) && in_array($_POST['user'], $onlineUsers)){
        $error = 'user_already_in_use';
      }else{
        $_SESSION['username'] = $_POST['user'];
        $user->login($_POST['user']);
        header('location: index.php');
      }
    break;
  }
}

require 'header.php';
if(isset($_SESSION['username'])){
  $user->login($_SESSION['username']);
  require 'room.php';
}else{
  require 'login.php';
}
require 'footer.php';
?>