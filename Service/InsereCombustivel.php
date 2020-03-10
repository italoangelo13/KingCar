<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Combustiveis.php');
$vxobComb = new Combustiveis();
$util = new Util();
$combustivel = null;
$Json = null;
try {
    
    if(isset($_GET)){
        $combustivel = strtoupper($_GET['combustivel']);
    }

   

    session_start();
    $vxobComb->Descricao = $combustivel;
    $vxobComb->User = $_SESSION['Usuario'];
    if($vxobComb->InsereCombustivel()){
        $ultimoCod = $vxobComb->BuscaUltimoCodPorUser();
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Combustivel Cadstrado com Sucesso.","UltCod":'.$ultimoCod.'}]');
    }
    else{
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Cadastrar este combustivel."}]'); 
    }

    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
