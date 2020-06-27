<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Modelos.php');
$modelo = new Modelos();
$util = new Util();
$Json = null;
$codModelo = null;

try {
    if(isset($_GET)){
        $codModelo = $_GET['cod'];
    }

    $Modelo = $modelo->SelecionarModeloPorCod($codModelo);
    if($Modelo){
        if (count($Modelo) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($Modelo)) {
        $Json = '[';
        $Json = $Json .  '{"modelo":"' . $Modelo[0]->MODDESCRICAO . '","marca":"' . $Modelo[0]->MODCODMARCA . '"}]';
            
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
