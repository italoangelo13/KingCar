<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Cambios.php');
$cambio = new Cambios();
$util = new Util();
$codCambio = null;
$Json = null;
try {

    if(isset($_GET)){
        $codCambio = $_GET['cod'];
    }

    if (!$codCambio) {
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Codigo do Cambio não informado."}]');
    }
    else{
        if($cambio->DeletaCambioPorCod($codCambio)){
            $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Cambio Deletado com Sucesso."}]');
        }
    }

    

    $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
