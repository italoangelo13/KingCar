<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Modelos.php');
$vxobmod = new Modelos();
$util = new Util();
$modelo = null;
$marca = null;
$Json = null;
try {
    
    if(isset($_GET)){
        $modelo = strtoupper($_GET['modelo']);
        $marca = $_GET['marca'];
    }

   

    session_start();
    $vxobmod->Descricao = $modelo;
    $vxobmod->Marca = $marca;
    $vxobmod->User = $_SESSION['Usuario'];
    if($vxobmod->InsereModelo()){
        $ultimoCod = $vxobmod->BuscaUltimoCodPorUser();
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Modelo Cadstrado com Sucesso.","UltCod":'.$ultimoCod.'}]');
    }
    else{
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Cadastrar este modelo."}]'); 
    }

    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
