<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Publicidades.php');
$publicidades = new Publicidades();
$util = new Util();
$codPub = null;
$Json = null;
try {

    if(isset($_GET)){
        $codPub = $_GET['cod'];
    }

    if (!$codPub) {
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Codigo da Publicidade não informado."}]');
    }
    else{
        $imgPub = $publicidades->SelecionarImagemPublicidadePorCod($codPub);
        $imagem = $imgPub[0]->PUBIMG;
        $caminhoImg = '../assets/img/Pub/'.$imagem;
            if($publicidades->DeletaPublicidadePorCod($codPub)){
                unlink($caminhoImg);
                $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Publicidade Deletada com Sucesso."}]');
            }
        
    }

    

    //$Json = $util->convert_from_latin1_to_utf8_recursively($Json);
    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
