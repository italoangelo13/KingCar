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
$codCambio = null;

try {
    if(isset($_GET)){
        $codCambio = $_GET['cod'];
    }

    $Cambio = $cambio->SelecionarCambioPorCod($codCambio);
    if($Cambio){
        if (count($Cambio) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($Cambio)) {
        $Json = '[';
        $Json = $Json .  '{"cambio":"' . $Cambio[0]->CAMDESCRICAO . '"}]';
            
        $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
