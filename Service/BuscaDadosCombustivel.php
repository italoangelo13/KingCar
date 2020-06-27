<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Combustiveis.php');
$combustivel = new Combustiveis();
$util = new Util();
$Json = null;
$codCombustivel = null;

try {
    if(isset($_GET)){
        $codCombustivel = $_GET['cod'];
    }

    $Comb = $combustivel->SelecionarCombustivelPorCod($codCombustivel);
    if($Comb){
        if (count($Comb) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($Comb)) {
        $Json = '[';
        $Json = $Json .  '{"combustivel":"' . $Comb[0]->COMDESCRICAO . '"}]';
            
        ////$Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
