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
$cor = null;
$hexa = null;
$Json = null;
try {
    
    if(isset($_GET)){
        $cor = $_GET['cor'];
        $hexa = '#'.strtoupper($_GET['hexa']);
    }

    if(!$hexa){
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"A Cor deve Ser Informada."}]'); 
        echo json_encode($Json);
        exit;
    }
   

    session_start();
    $vxobcor->Descricao = strtoupper($cor);
    $vxobcor->Hexadecimal = strtoupper($hexa);
    $vxobcor->User = $_SESSION['Usuario'];
    if($vxobcor->InsereCor()){
        $ultimoCod = $vxobcor->BuscaUltimoCodPorUser();
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Cor Cadstrada com Sucesso.","UltCod":'.$ultimoCod.'}]');
    }
    else{
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Cadastrar esta cor."}]'); 
    }

    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
