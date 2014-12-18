<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require 'classes/FileHandler.php';
require 'classes/Message.php';
require 'classes/User.php';

$msg = new Message;
$user = new User;

require 'langs.php';
if(!isset($_SESSION['lang']))
    $_SESSION['lang'] = 'en';
$lang = $_SESSION['lang'];

require 'lib.php';