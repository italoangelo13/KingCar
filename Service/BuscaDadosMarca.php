<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Marcas.php');
$marca = new Marcas();
$util = new Util();
$Json = null;
$codMarca = null;

try {
    if(isset($_GET)){
        $codMarca = $_GET['cod'];
    }

    $Marca = $marca->SelecionarMarcaPorCod($codMarca);
    if($Marca){
        if (count($Marca) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($Marca)) {
        $Json = '[';
        $Json = $Json .  '{"marca":"' . $Marca[0]->MARDESCRICAO . '","ativo":"' . $Marca[0]->MARATIVO . '"}]';
            
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
