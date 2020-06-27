<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Categorias.php');
$categorias = new Categorias();
$util = new Util();
$Json = null;

try {

    $listaCategorias = $categorias->SelecionarListaCategorias();
    if($listaCategorias){
        if (count($listaCategorias) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaCategorias)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaCategorias);
        foreach ($listaCategorias as $cat) {
            //$date = new DateTime($cat->CORDATCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $cat->CATCOD . '","categoria":"' . $cat->CATDESCRICAO . '"}]';
            } else {
                $Json = $Json .  '{"id":"' . $cat->CATCOD . '","categoria":"' . $cat->CATDESCRICAO . '"},';
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
