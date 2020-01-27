<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Compra.php');
$compra = new Compra();
$util = new Util();
$Json = null;

try {
    $listaSolCompra = $compra->SelecionarSolicitacoesCompra();
    if($listaSolCompra){
        if (count($listaSolCompra) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaSolCompra)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaSolCompra);
        foreach ($listaSolCompra as $sCompra) {
            $date = new DateTime($sCompra->COMDATCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"lido":"'. $sCompra->COMLIDO .'","id":"' . $sCompra->COMCOD . '","nome":"' . $sCompra->COMNOME . '","email":"' . $sCompra->COMEMAIL . '","dtcadastro":"' . $date->format( 'd/m/Y H:i:s') . '","tel":"'. $sCompra->COMTEL . '","carro":"'. $sCompra->VEICULO . '","det":"'. $sCompra->COMCOD . '"}]';
            } else {
                $Json = $Json .  '{"lido":"'. $sCompra->COMLIDO .'","id":"' . $sCompra->COMCOD . '","nome":"' . $sCompra->COMNOME . '","email":"' . $sCompra->COMEMAIL . '","dtcadastro":"' . $date->format( 'd/m/Y H:i:s') . '","tel":"'. $sCompra->COMTEL . '","carro":"'. $sCompra->VEICULO . '","det":"'. $sCompra->COMCOD . '"},';
            }
            $cont++;
        }

        $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
