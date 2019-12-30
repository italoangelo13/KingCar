<?php
session_start();
require_once('../Models/Usuarios.php');
$USUARIO = new Usuarios(); 
$USUARIO->Logout();
?>