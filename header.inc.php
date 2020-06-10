<?php
require_once 'config/Util.php';
$util = new Util();
$telefone = null;
$facebook = null;
$whatsapp = null;
$instagram = null;

$parTel = $util->SelecionarParametroPorCod(7); //7 - Telefone
$parWhat = $util->SelecionarParametroPorCod(8); //8 - whatsapp
$parFace = $util->SelecionarParametroPorCod(9); //9 - facebook
$parInsta = $util->SelecionarParametroPorCod(10); //10 - instagram

$telefone = $parTel[0]->PRMVAL;
$whatsapp = $parWhat[0]->PRMVAL;
$facebook = $parFace[0]->PRMVAL;
$instagram = $parInsta[0]->PRMVAL;




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta charset="UTF-8"> -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KingCar - Troca e Venda</title>
    <link rel="stylesheet" href="assets/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontello/css/fontello.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/kingcar.css">
    <link rel="stylesheet" href="assets/jquery-confirm/jquery-confirm.min.css">
    <link rel="stylesheet" href="assets/chartjs/chart.min.css">
    <link rel="stylesheet" href="assets/jQueryte.1.4.0/jquery-te-1.4.0.css">
    <link rel="stylesheet" href="assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="assets/lightgallery/css/lightgallery.min.css">
    <script src="assets/jquery-3.3.1.min.js"></script>
    <script src="assets/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
    <script src="assets/jquery-confirm/jquery-confirm.min.js"></script>
    <script src="assets/Loader/jquery.loading.min.js"></script>
    <script src="assets/Mascaras.js"></script>
    <script src="assets/chartjs/chart.min.js"></script>
    <script src="assets/jQueryte.1.4.0/jquery-te-1.4.0.min.js"></script>
    <script src="assets/DataTables/datatables.min.js"></script>
    <script src="assets/lightgallery/js/lightgallery.min.js"></script>
    <script src="assets/kingcar.js"></script>
    <script>
        $(document).ready(function() {
            $("#_ddlMarca").change(function() {
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

<body style="background: black;">
    <div class="container-fluid">
        <header class="row bg-white" style="padding: 5px;">
            <div class="col-lg-3 text-center text-lg-left">
                <img src="assets/img/logo-preto.png" alt="logo" style="width:100%;">
            </div>
            <div class="col-lg-9 text-center text-lg-right">
                <div class="container-fluid">
                    <?php if ($facebook) { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <a target="_blank" href="<?php echo $facebook; ?>" class="text-dark" style="text-decoration: none;"><i class="icone-facebook-rect-1"></i> Facebook </a>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($instagram) { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <a target="_blank" href="<?php echo $instagram; ?>" class="text-dark" style="text-decoration: none;"><i class="icone-instagram-filled"></i> Instagram </a>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($whatsapp) { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp; ?>&text=Olá!" class="text-dark" style="text-decoration: none;"><i class="icone-whatsapp"></i> Whatsapp </a>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($telefone) { ?>
                        <div class="row">
                            <div class="col-lg-12 text-dark">
                                <i class="icone-phone"></i> <?php echo $telefone; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </header>
        <div class="row">
            <div class="col-lg-12" style="padding: 0px;">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <label class="d-block d-sm-none navbar-brand">
                        Menu
                    </label>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto" style="font-weight: 700; font-size: 14pt;">
                            <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                            <li class="nav-item"><a class="nav-link" href="sobre.php">Institucional</a></li>
                            <li class="nav-item" style="display: none"><a class="nav-link" href="carros.php">Carros</a></li>
                            <li class="nav-item" style="display: none"><a class="nav-link" href="anuncio.php">Anuncie</a></li>

                            <li class="nav-item dropdown">
                                <label class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Veículos
                                </label>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item btn-drop" href="carros.php">Semi-novos</a>
                                    <a class="dropdown-item btn-drop" href="pesqRepasse.php">Repasse</a>
                                    <a class="dropdown-item btn-drop" href="pesqSinistrados.php">Sinistrados/Recuperados</a>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav my-2 my-lg-0" style="font-weight: 700; font-size: 14pt;">
                            <li class="nav-item"><a class="nav-link" href="faleConosco.php">Contato</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>