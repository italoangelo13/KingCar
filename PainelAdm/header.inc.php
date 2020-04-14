<?php
session_start();
require_once '../Config/ConexaoBD.php';
require_once('../Models/Usuarios.php');
require_once('../Models/Compra.php');

$USUARIO = new Usuarios(); 
$compra = new Compra();

if(!$USUARIO->VerificaAutenticacao()){
    echo "<script> alert('Sua Sessão Expirou, Faça o Login Novamente.');</script>";
    header("Location: ../login.php");
}


$user = utf8_encode($_SESSION['NomeUsuario']);

$r = $compra->SelecionarNumSolicitacaoCompra();
        
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
    <link rel="stylesheet" href="../assets/jQueryte.1.4.0/jquery-te-1.4.0.css">
    <link rel="stylesheet" href="../assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="../assets/lightgallery/css/lightgallery.min.css">
    <script src="../assets/jquery-3.3.1.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/fontawesome/js/all.min.js"></script>
    <script src="../assets/jquery-confirm/jquery-confirm.min.js"></script>
    <script src="../assets/Loader/jquery.loading.min.js"></script>
    <script src="../assets/Mascaras.js"></script>
    <script src="../assets/chartjs/chart.min.js"></script>
    <script src="../assets/jQueryte.1.4.0/jquery-te-1.4.0.min.js"></script>
    <script src="../assets/DataTables/datatables.min.js"></script>
    <script src="../assets/lightgallery/js/lightgallery.min.js"></script>
    <script src="../assets/limittext/jquery.limittext.min.js"></script>
    <script src="../assets/jQuery-spHtmlEditor/jQuery.spHtmlEditor.js"></script>
    <script src="../assets/kingcar.js"></script>
    
    <script>


    setInterval("atualizaNumMsg()",3000);



        function atualizaNumMsg(){
            $.ajax({
                url: "../service/BuscaNumSolicitacaoCompra.php",
                type: 'GET',
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    var dados = JSON.parse(data);
                    console.log(dados[0]);
                    $("#_lblContMsg").text(dados[0].Msg);

                }
            });
        }
    </script>
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
                        <a class="nav-link" href="CrudUsuario.php" ><i class="icone-user"></i> <label>Usuários</label></a>
                        
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="CrudCarros.php" ><i class="fas fa-car"></i> <label>Carros </label></a>
                        
                        </li>
                        <li class="nav-item ">
                        <a class="nav-link" href="CrudPublicidade.php" ><i class="icone-newspaper-2"></i> <label>Publicidades</label></a>
                        
                        </li>
                        <li class="nav-item ">
                        <a class="nav-link" href="SolAnuncios.php" ><i class="icone-exclamation"></i> <label>Anuncios</label></a>
                        
                        </li>
                        <li class="nav-item ">
                        <a class="nav-link" href="CadastrosBasicos.php" ><i class="icone-plus"></i> <label>Cadastros Basicos</label></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="institucional.php" ><i class="icone-building"></i> <label>Institucional </label></a>
                        </li>
                    </ul>

                    <div class="form-inline my-2 my-lg-0">
                    <a href="SolicitacoesCompra.php" style="position:relative;" title="Solicitações de Compras">
                        <span class="icone-mail text-light" style="font-size: 30px;" aria-hidden="true"></span>
                        <?php if($r[0]->QTDE > 0){ echo '<span id="_lblContMsg" class="badge badge-danger" style="position: absolute; z-index: 1; top:0px; right:0px; ">0</span>'; }?>
                    </a>

                    <a href="ConfiguracoesParam.php"  title="Configurações">
                        <span class="icone-cog text-light" style="font-size: 30px;" aria-hidden="true"></span>
                    </a>
                    </div>
                </div>
            </nav>
        </div>