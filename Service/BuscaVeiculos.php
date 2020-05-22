<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Carros.php');
$carro = new Carros();
$util = new Util();
$Json = null;

try {

    $listaCarros = $carro->SelecionarVeiculosGrid();
    if($listaCarros){
        if (count($listaCarros) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaCarros)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaCarros);
        foreach ($listaCarros as $car) {
            //$date = new DateTime($car->PUBDATCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $car->CARCOD . '","marca":"' . $car->MARDESCRICAO . '","modelo":"' . $car->MODDESCRICAO . '","preco":"' . $car->CARPRECO . '","imagem":"' . $car->CARFOTO . '","ano":"' . $car->CARANO . '","editar":"'. $car->CARCOD . '","excluir":"'. $car->CARCOD . '"}]';
            } else {
                $Json = $Json .  '{"id":"' . $car->CARCOD . '","marca":"' . $car->MARDESCRICAO . '","modelo":"' . $car->MODDESCRICAO . '","preco":"' . $car->CARPRECO . '","imagem":"' . $car->CARFOTO . '","ano":"' . $car->CARANO . '","editar":"'. $car->CARCOD . '","excluir":"'. $car->CARCOD . '"},';
            }
            $cont++;
        }

        $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
