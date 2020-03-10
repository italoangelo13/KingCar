<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Marcas.php');
$vxobmar = new Marcas();
$util = new Util();
$marca = null;
$ativo = null;
$Json = null;
try {
    
    if(isset($_GET)){
        $marca = $_GET['marca'];
        $ativo = strtoupper($_GET['ativo']);
    }

   

    session_start();
    $vxobmar->Descricao = $marca;
    $vxobmar->Ativo = strtoupper($ativo);
    $vxobmar->User = $_SESSION['Usuario'];
    if($vxobmar->InsereMarca()){
        $ultimoCod = $vxobmar->BuscaUltimoCodPorUser();
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Marca Cadstrada com Sucesso.","UltCod":'.$ultimoCod.'}]');
    }
    else{
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Cadastrar esta marca."}]'); 
    }

    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
