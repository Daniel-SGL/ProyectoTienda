<?php

require_once("db.php");
$conn = db::connect();
require_once("models/User.php");

session_start();

if (isset($_GET['c'])) {
    require_once("controllers/" . $_GET['c'] . "Controller.php");
}

if (isset($_GET['login'])) {
    require_once "views/login.phtml";
    exit();
}

if (isset($_GET['register'])) {
    require_once "views/register.phtml";
    exit();
}

require_once "views/mainView.phtml";
