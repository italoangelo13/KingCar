<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Cambios.php');
$vxobcam = new Cambios();
$util = new Util();
$cambio = null;
$Json = null;
try {
    
    if(isset($_GET)){
        $cambio = strtoupper($_GET['cambio']);
    }

   

    session_start();
    $vxobcam->Descricao = $cambio;
    $vxobcam->User = $_SESSION['Usuario'];
    if($vxobcam->InsereCambio()){
        $ultimoCod = $vxobcam->BuscaUltimoCodPorUser();
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Cambio Cadstrado com Sucesso.","UltCod":'.$ultimoCod.'}]');
    }
    else{
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Cadastrar este cambio."}]'); 
    }

    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
