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

    $listaCarro = $carro->SelecionarVeiculosPorQtdeVisitas();
    if($listaCarro){
        if (count($listaCarro) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaCarro)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaCarro);
        foreach ($listaCarro as $car) {
            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $car->CARCOD . '","destaque":"'.$car->CARDESTAQUE.'","troca":"'.$car->CARTROCA.'","carro":"' . $car->VEICULO . '","visitas":"' . $car->CARQTDEVISITAS . '","editar":"'. $car->CARCOD . '","preco":'. $car->CARPRECO . '}]';
            } else {
                $Json = $Json .  '{"id":"' . $car->CARCOD . '","destaque":"'.$car->CARDESTAQUE.'","troca":"'.$car->CARTROCA.'","carro":"' . $car->VEICULO . '","visitas":"' . $car->CARQTDEVISITAS . '","editar":"'. $car->CARCOD . '","preco":'. $car->CARPRECO . '},';
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
