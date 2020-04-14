<?php
header("Content-type:text/html; charset=utf8");

include_once 'Config/ConexaoBD.php';
include_once 'Config/Util.php';
require_once 'Models/Anuncios.php';

$anoAtual = date("Y");
$contador = 80;
$anoMin = $anoAtual - $contador;
$util = new Util();
$anuncio = new Anuncios();

include 'header.inc.php';
?>

<div class="row bg-dark" style="height: 50vh; margin-top:10px;padding:5px;">
    <div class="col-lg-6 text-center" style="border-right: 1px yellow solid">
        <h3 class="text-warning">Endereço</h3>
        <hr style="border-color: yellow;">
        <div class="cointainer-fluid text-warning">
            <div class="row">
                <div class="col-lg-12">
                    <h4>Rua Tal, 999, Nome do bairro</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h5>Cidade - MG</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h5>Cep Aqui</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 text-center" style="border-left: 1px yellow solid">
        <h3 class="text-warning">Contatos</h3>
        <hr style="border-color: yellow;">
        <div class="cointainer-fluid text-warning">
            <div class="row">
                <div class="col-lg-5 text-right">
                    <h4><i class="icone-phone"></i></h4>
                </div>
                <div class="col-lg-7 text-left">
                    <h4> (31) 9999-9999</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 text-right">
                    <h4><i class="icone-facebook"></i></h4>
                </div>
                <div class="col-lg-7 text-left">
                    <h4> @kingCar</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 text-right">
                    <h4><i class="icone-instagram"></i></h4>
                </div>
                <div class="col-lg-7 text-left">
                    <h4> @Kingcar</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 text-right">
                    <h4><i class="icone-whatsapp"></i></h4>
                </div>
                <div class="col-lg-7 text-left">
                    <h4> (31) 99999-9999</h4>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include 'footer.inc.php';
?>
