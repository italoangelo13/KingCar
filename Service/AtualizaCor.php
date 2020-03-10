<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache

include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Cores.php');
$vxobcor = new Cores();
$util = new Util();
$cod = null;
$cor = null;
$hexa = null;
$Json = null;
try {
    
    if(isset($_GET)){
        $cod = $_GET['cod'];
        $cor = $_GET['cor'];
        $hexa = '#' . strtoupper($_GET['hexa']);
    }

    session_start();
    $vxobcor->Id = $cod;
    $vxobcor->Descricao = $cor;
    $vxobcor->Hexadecimal = strtoupper($hexa);
    $vxobcor->User = $_SESSION['Usuario'];
    if($vxobcor->AtualizaCor()){
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":2, "msg":"Cor Atualizada com Sucesso."}]');
    }
    else{
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Atualizar esta cor."}]'); 
    }

    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
