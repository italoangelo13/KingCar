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
        $con = 1;
        $total = count($listaSolCompra);
        foreach ($listaSolCompra as $com) {
            $date = new DateTime($com->COMDATCADASTRO);
            if ($con == $total) {
                $Json = $Json .  '{"lido":"'. $com->COMLIDO .'","id":"' . $com->COMCOD . '","nome":"' . $com->COMNOME . '","email":"' . $com->COMEMAIL . '","dtcadastro":"' . $date->format( 'd/m/Y H:i:s') . '","tel":"'. $com->COMTEL . '","assunto":"'. $com->VEICULO . '","det":"'. $com->COMCOD . '"}]';
            } else {
                $Json = $Json .  '{"lido":"'. $com->COMLIDO .'","id":"' . $com->COMCOD . '","nome":"' . $com->COMNOME . '","email":"' . $com->COMEMAIL . '","dtcadastro":"' . $date->format( 'd/m/Y H:i:s') . '","tel":"'. $com->COMTEL . '","assunto":"'. $com->VEICULO . '","det":"'. $com->COMCOD . '"},';
            }
            $con++;
        }

        //$Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
