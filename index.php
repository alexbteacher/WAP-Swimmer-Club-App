<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "controller/constants.init.php";
include_once "controller/main.php";
include_once "view/all/header.php";
include_once $loadedView;
include_once "view/all/footer.php";
