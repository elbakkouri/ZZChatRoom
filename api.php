<?php
require 'start.php';
if(isset($_GET['action']))
    $action = $_GET['action'];
switch($action){
    case 'get':
        $data = null;
        switch ($_GET['info']) {
            case 'online_users':
                $data = getOnlineUsers();
            break;
            case 'public_messages':
                $data = last($msg->getByTo('all'),10);
            break;
            case 'messages':
                $data = last($msg->getConversation($_GET['from'],$_GET['to']),10);
            break;
        }
        echo json_encode($data);
    break;
    case 'post':
        switch($_GET['method']){
            case 'send':
                $user->login($_GET['from']);
                $user->sendTo($_GET['to'], $_GET['message']);
            break;
        }
    break;
}