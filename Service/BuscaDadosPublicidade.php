<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Publicidades.php');
$pub = new Publicidades();
$util = new Util();
$Json = null;
$codPublicidade = null;

try {
    if(isset($_GET)){
        $codPublicidade = $_GET['cod'];
    }

    $Publicidade = $pub->SelecionarPublicidadePorCod($codPublicidade);
    if($Publicidade){
        if (count($Publicidade) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($Publicidade)) {
        $Json = '[';
        $Json = $Json .  '{"empresa":"' . $Publicidade[0]->PUBEMPRESA . '","titulo":"' . $Publicidade[0]->PUBTITULO . '","link":"' . $Publicidade[0]->PUBLINK . '","imagem":"' . $Publicidade[0]->PUBIMG . '"}]';
            
        $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
