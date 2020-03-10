<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache

include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Modelos.php');
$vxobmodelo = new Modelos();
$util = new Util();
$cod = null;
$modelo = null;
$marca = null;
$Json = null;
try {
    
    if(isset($_GET)){
        $cod = $_GET['cod'];
        $modelo = strtoupper($_GET['modelo']);
        $marca = $_GET['marca'];
    }

    session_start();
    $vxobmodelo->Id = $cod;
    $vxobmodelo->Descricao = $modelo;
    $vxobmodelo->Marca = $marca;
    $vxobmodelo->User = $_SESSION['Usuario'];
    if($vxobmodelo->AtualizaModelo()){
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":2, "msg":"Modelo Atualizado com Sucesso."}]');
    }
    else{
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Atualizar este modelo."}]'); 
    }

    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
