<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Anuncios.php');
$anuncios = new Anuncios();
$util = new Util();
$Json = null;

try {

    $listaAnuncios = $anuncios->SelecionarListaAnuncio();
    if($listaAnuncios){
        if (count($listaAnuncios) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaAnuncios)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaAnuncios);
        foreach ($listaAnuncios as $anu) {
            $date = new DateTime($anu->SOLDTCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $anu->SOLCOD . '","anunciante":"' . $anu->SOLANOME . '","email":"' . $anu->SOLEMAIL . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $anu->SOLCOD . '","veiculo":"'. $anu->VEICULO . '","imagem":"'. $anu->SOLFOTOCAPA . '"}]';
            } else {
                $Json = $Json .  '{"id":"' . $anu->SOLCOD . '","anunciante":"' . $anu->SOLANOME . '","email":"' . $anu->SOLEMAIL . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $anu->SOLCOD . '","veiculo":"'. $anu->VEICULO . '","imagem":"'. $anu->SOLFOTOCAPA . '"},';
            }
            $cont++;
        }

        $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);

        // if ($Json) {
        //     echo $json;
        // } else
        //     echo json_last_error_msg();

        // echo json_encode($result);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
