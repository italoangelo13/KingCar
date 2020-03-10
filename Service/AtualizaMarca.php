<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache

include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Marcas.php');
$vxobmarca = new Marcas();
$util = new Util();
$cod = null;
$marca = null;
$ativo = null;
$Json = null;
try {
    
    if(isset($_GET)){
        $cod = $_GET['cod'];
        $marca = $_GET['marca'];
        $ativo = strtoupper($_GET['ativo']);
    }

    session_start();
    $vxobmarca->Id = $cod;
    $vxobmarca->Descricao = $marca;
    $vxobmarca->Ativo = strtoupper($ativo);
    $vxobmarca->User = $_SESSION['Usuario'];
    if($vxobmarca->AtualizaMarca()){
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":2, "msg":"Marca Atualizada com Sucesso."}]');
    }
    else{
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Atualizar esta marca."}]'); 
    }

    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
