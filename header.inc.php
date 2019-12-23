<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KingCar - Troca e Venda</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontello/css/fontello.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/kingcar.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/fontawesome/js/all.min.js"></script>
<script src="//code.jivosite.com/widget.js" data-jv-id="M8AgwKTtAZ" async></script>
<script src="assets/kingcar.js"></script>
<script>
$(document).ready(function () {
    $("#_ddlMarca").change(function(){ 
        CarregaDdlModelo();
    });
});
</script>
</head>

<body  style="background: black;">
    <div class="container-fluid">
        <header class="row" >
            <div class="col-lg-12" style="padding: 0px;">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <a class="navbar-brand" href="index.php">
                        <img src="img/logo.png" alt="logo" style="width:8vh;">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                            <li class="nav-item"><a class="nav-link" href="carros.php">Carros</a></li>
                            <li class="nav-item"><a class="nav-link" href="anunciar.php">Anuncie</a></li>
                            <li class="nav-item"><a class="nav-link" href="sobre.php">Sobre</a></li>
                            <li class="nav-item"><a class="nav-link" href="faleconosco.php">Contato</a></li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0">
                            <label class="text-white"><i class="icone-phone"></i> (031) 3671 - 0000</label>
                        </form>
                    </div>
                </nav>
            </div>
        </header>