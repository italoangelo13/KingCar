<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Publicidades.php');
$publicidade = new Publicidades();
$util = new Util();
$Json = null;

try {

    $listaPublicidade = $publicidade->SelecionarListaPublicidades();
    if($listaPublicidade){
        if (count($listaPublicidade) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaPublicidade)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaPublicidade);
        foreach ($listaPublicidade as $pub) {
            $date = new DateTime($pub->PUBDATCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $pub->PUBCOD . '","empresa":"' . $pub->PUBEMPRESA . '","titulo":"' . $pub->PUBTITULO . '","imagem":"' . $pub->PUBIMG . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $pub->PUBCOD . '","excluir":"'. $pub->PUBCOD . '"}]';
            } else {
                $Json = $Json .  '{"id":"' . $pub->PUBCOD . '","empresa":"' . $pub->PUBEMPRESA . '","titulo":"' . $pub->PUBTITULO . '","imagem":"' . $pub->PUBIMG . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $pub->PUBCOD . '","excluir":"'. $pub->PUBCOD . '"},';
            }
            $cont++;
        }

        ////$Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
