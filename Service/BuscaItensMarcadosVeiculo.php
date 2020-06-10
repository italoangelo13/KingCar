<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Carros.php');
$car = new Carros();
$util = new Util();
$Json = null;
$codVeiculo = null;
try {
    if(isset($_GET)){
        $codVeiculo = $_GET['cod'];
    }

    $Veiculo = $car->SelecionarItensMarcadosVeiculo($codVeiculo);
    if($Veiculo){
        if (count($Veiculo) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }

   
    if (count($Veiculo)) {
        $Json = '[';
        $cont = 1;
        $total = count($Veiculo);
        foreach ($Veiculo as $vei) {
            if ($cont == $total) {
                $Json = $Json .  '{"descricao":"' . $vei->COMPDESC . '","campo":"' . $vei->COMPNOMCAMPO . '"}]';
            } else {
                $Json = $Json .  '{"descricao":"' . $vei->COMPDESC . '","campo":"' . $vei->COMPNOMCAMPO . '"},';
            }
            $cont++;
        }

        $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
