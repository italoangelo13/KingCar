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
$Json = null;

try {

    $listaCambio = $cambio->SelecionarListaCambio();
    if($listaCambio){
        if (count($listaCambio) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaCambio)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaCambio);
        foreach ($listaCambio as $cam) {
            $date = new DateTime($cam->CAMDATCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $cam->CAMCOD . '","cambio":"' . $cam->CAMDESCRICAO . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $cam->CAMCOD . '","excluir":"'. $cam->CAMCOD . '"}]';
            } else {
                $Json = $Json .  '{"id":"' . $cam->CAMCOD . '","cambio":"' . $cam->CAMDESCRICAO . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $cam->CAMCOD . '","excluir":"'. $cam->CAMCOD . '"},';
            }
            $cont++;
        }

        ////$Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
