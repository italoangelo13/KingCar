<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Combustiveis.php');
$combustivel = new Combustiveis();
$util = new Util();
$codCombustivel = null;
$Json = null;
try {

    if(isset($_GET)){
        $codCombustivel = $_GET['cod'];
    }

    if (!$codCombustivel) {
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Codigo do Combustivel não informado."}]');
    }
    else{
        if($combustivel->DeletaCombustivelPorCod($codCombustivel)){
            $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Combustivel Deletado com Sucesso."}]');
        }
    }

    

    $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
