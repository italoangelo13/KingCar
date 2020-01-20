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

    $sqlQtdeCarro = "SELECT CARFOTO, CARCOD,CARANO,CARUSER,CARDATCADASTRO, MARDESCRICAO, MODDESCRICAO
    FROM kgctblcar
    INNER JOIN kgctblmar ON CARCODMARCA = MARCOD
    INNER JOIN kgctblMOD ON CARCODMODELO = MODCOD
    WHERE NOT EXISTS(SELECT 1 FROM KGCTBLDETCAR WHERE CARCOD = DETCODCARRO)";
    $listaCar = $carro->SelecionarNumCarrosDetIncompletos($sqlQtdeCarro);
    if($listaCar){
        if (count($listaCar) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaCar)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaCar);
        foreach ($listaCar as $car) {
            $date = new DateTime($car->CARDATCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"foto":"'. $car->CARFOTO . '","id":"' . $car->CARCOD . '","marca":"' . $car->MARDESCRICAO . '","modelo":"' . $car->MODDESCRICAO . '","ano":"'. $car->CARANO . '","usuario":"'. $car->CARUSER . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","link":"'. $car->CARCOD . '"}]';
            } else {
                $Json = $Json .  '{"foto":"'. $car->CARFOTO . '","id":"' . $car->CARCOD . '","marca":"' . $car->MARDESCRICAO . '","modelo":"' . $car->MODDESCRICAO . '","ano":"'. $car->CARANO . '","usuario":"'. $car->CARUSER . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","link":"'. $car->CARCOD . '"},';
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
