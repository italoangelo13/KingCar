<?php
session_start();
require_once '../Config/ConexaoBD.php';
require_once('../Models/Usuarios.php');

$USUARIO = new Usuarios(); 

if(!$USUARIO->VerificaAutenticacao()){
    echo "<script> alert('Sua Sessão Expirou, Faça o Login Novamente.');</script>";
    header("Location: ../login.php");
}


$user = utf8_encode($_SESSION['NomeUsuario']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KingCar - Painel Administrativo</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontello/css/fontello.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/kingcar.css">
    <link rel="stylesheet" href="../assets/jquery-confirm/jquery-confirm.min.css">
    <link rel="stylesheet" href="../assets/chartjs/chart.min.css">
    <script src="../assets/jquery-3.3.1.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/fontawesome/js/all.min.js"></script>
    <script src="../assets/jquery-confirm/jquery-confirm.min.js"></script>
    <script src="../assets/Loader/jquery.loading.min.js"></script>
    <script src="../assets/Mascaras.js"></script>
    <script src="../assets/chartjs/chart.min.js"></script>
    <script src="../assets/kingcar.js"></script>
</head>

<body style="height: 100vh; background-color: gainsboro;">
<div class="container-fluid">
        <div class="row bg-dark text-white">
            <div class="col-lg-6" style="height:5vh;">
                <strong>Painel Administrativo</strong>
            </div>
            <div class="col-lg-6 text-right">
                <i class="icone-user"></i> <strong> <?php echo $user; ?></strong>
                <a href="logout.php" class="text-white"> <i class="icone-logout"></i> Sair</a>
            </div>
        </div>
        <div class="row" style="margin-bottom: 2px;">
            <nav style="padding: 2px;" class="navbar navbar-expand-lg navbar-dark bg-success col-lg-12">
                <a class="navbar-brand" href="admin.php"><i class="icone-home"></i> <label>Inicio </label></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item ">
                        <a class="nav-link" href="#" ><i class="icone-user"></i> <label>Usuários</label></a>
                        
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="CrudCarros.php" ><i class="fas fa-car"></i> <label>Carros </label></a>
                        
                        </li>
                        <li class="nav-item ">
                        <a class="nav-link" href="#" ><i class="icone-newspaper-2"></i> <label>Publicidades</label></a>
                        
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#" ><i class="icone-question"></i> <label>Sobre </label></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>