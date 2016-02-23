<?php 
include_once 'lib/module.php';
session_destroy();
$objModule->redirect("./login.php");
?>