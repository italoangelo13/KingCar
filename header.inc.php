<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta charset="UTF-8"> -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KingCar - Troca e Venda</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontello/css/fontello.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/kingcar.css">
    <link rel="stylesheet" href="assets/jquery-confirm/jquery-confirm.min.css">
    <link rel="stylesheet" href="assets/jquery-Ui/jquery-ui.min.css" />
    <link rel="stylesheet" href="assets/lightgallery/css/lightgallery.min.css" />
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <script src="assets/jquery-3.3.1.min.js"></script>
    <script src="assets/jquery-Ui/jquery-Ui.min.js"></script>
    <script src="assets/lightgallery/js/lightgallery-all.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
    <script src="assets/jquery-confirm/jquery-confirm.min.js"></script>
    <script src="assets/Loader/jquery.loading.min.js"></script>
    <script src="assets/Mascaras.js"></script>
    <script src="assets/kingcar.js"></script>
<script>
$(document).ready(function () {
    $("#_ddlMarca").change(function(){ 
        CarregaDdlModelo();
    });

    function SuccessBox(msg) {
    $.alert({
        title: 'KingCar Alerta',
        content: msg,
        type: 'green',
        typeAnimated: true,
    });
}

function WarningBox(msg) {
    $.alert({
        title: 'KingCar Alerta',
        content: msg,
        type: 'orange',
        typeAnimated: true,
    });
}

function ErrorBox(msg) {
    $.alert({
        title: 'KingCar Alerta',
        content: msg,
        type: 'red',
        typeAnimated: true,
    });
}


function DefaultBox(msg) {
    $.alert({
        title: 'KingCar Alerta',
        content: msg,
        type: 'dark',
        typeAnimated: true,
    });
}


function showLoad(msg) {
    if (msg == null || msg == '') {
        msg = 'Carregando...'
    }

    $('body').loading({
        theme: 'dark',
        message: msg
    });
}


function hideLoad() {
    $('body').loading('stop');
}
});
</script>
</head>

<body  style="background: black;">
    <div class="container-fluid">
        <header class="row" >
            <div class="col-lg-12" style="padding: 0px;">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <a class="navbar-brand" href="index.php">
                        <img src="assets/img/logo.png" alt="logo" style="width:6vw;">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto" style="font-weight: 700; font-size: 14pt;">
                            <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                            <li class="nav-item"><a class="nav-link" href="sobre.php">Institucional</a></li>
                            <li class="nav-item"><a class="nav-link" href="carros.php">Carros</a></li>
                            <li class="nav-item"><a class="nav-link" href="anuncio.php">Anuncie</a></li>
                            <li class="nav-item"><a class="nav-link" href="faleConosco.php">Contato</a></li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0">
                            <label class="text-white"><i class="icone-phone"></i> (031) 3671 - 0000</label>
                        </form>
                    </div>
                </nav>
            </div>
        </header>