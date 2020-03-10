<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache

include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Cambios.php');
$vxobcambio = new Cambios();
$util = new Util();
$cod = null;
$cambio = null;
$Json = null;
try {
    
    if(isset($_GET)){
        $cod = $_GET['cod'];
        $cambio = strtoupper($_GET['cambio']);
    }

    session_start();
    $vxobcambio->Id = $cod;
    $vxobcambio->Descricao = $cambio;
    $vxobcambio->User = $_SESSION['Usuario'];
    if($vxobcambio->AtualizaCambio()){
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":2, "msg":"Cambio Atualizado com Sucesso."}]');
    }
    else{
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Atualizar este cambio."}]'); 
    }

    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
