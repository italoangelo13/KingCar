<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Cores.php');
$cores = new Cores();
$util = new Util();
$Json = null;

try {

    $listaCores = $cores->SelecionarListaCores();
    if($listaCores){
        if (count($listaCores) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaCores)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaCores);
        foreach ($listaCores as $cor) {
            $date = new DateTime($cor->CORDATCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $cor->CORCOD . '","cores":"' . $cor->CORDESCRICAO . '","hexa":"' . $cor->CORCODHEXADECIMAL . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $cor->CORCOD . '","excluir":"'. $cor->CORCOD . '"}]';
            } else {
                $Json = $Json .  '{"id":"' . $cor->CORCOD . '","cores":"' . $cor->CORDESCRICAO . '","hexa":"' . $cor->CORCODHEXADECIMAL . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $cor->CORCOD . '","excluir":"'. $cor->CORCOD . '"},';
            }
            $cont++;
        }

        ////$Json = $util->convert_from_latin1_to_utf8_recursively($Json);
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
