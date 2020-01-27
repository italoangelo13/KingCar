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
