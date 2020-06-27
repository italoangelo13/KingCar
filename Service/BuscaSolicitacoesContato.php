<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Contatos.php');
$contato = new Contatos();
$util = new Util();
$Json = null;

try {
    $listaSolContatos = $contato->SelecionarSolicitacoesContatos();
    if($listaSolContatos){
        if (count($listaSolContatos) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaSolContatos)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaSolContatos);
        foreach ($listaSolContatos as $con) {
            $date = new DateTime($con->CONDATCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"lido":"'. $con->CONSTATUS .'","id":"' . $con->CONCOD . '","nome":"' . $con->CONNOME . '","email":"' . $con->CONEMAIL . '","dtcadastro":"' . $date->format( 'd/m/Y H:i:s') . '","tel":"'. $con->CONTEL . '","assunto":"'. $con->CONASSUNTO . '","det":"'. $con->CONCOD . '"}]';
            } else {
                $Json = $Json .  '{"lido":"'. $con->CONSTATUS .'","id":"' . $con->CONCOD . '","nome":"' . $con->CONNOME . '","email":"' . $con->CONEMAIL . '","dtcadastro":"' . $date->format( 'd/m/Y H:i:s') . '","tel":"'. $con->CONTEL . '","assunto":"'. $con->CONASSUNTO . '","det":"'. $con->CONCOD . '"},';
            }
            $cont++;
        }

        ////$Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
