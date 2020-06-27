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

try {

    $listaMarca = $marca->SelecionarListaTodasMarcas();
    if($listaMarca){
        if (count($listaMarca) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaMarca)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaMarca);
        foreach ($listaMarca as $mar) {
            $date = new DateTime($mar->MARDATCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $mar->MARCOD . '","marca":"' . $mar->MARDESCRICAO . '","ativo":"' . $mar->MARATIVO . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $mar->MARCOD . '","excluir":"'. $mar->MARCOD . '"}]';
            } else {
                $Json = $Json .  '{"id":"' . $mar->MARCOD . '","marca":"' . $mar->MARDESCRICAO . '","ativo":"' . $mar->MARATIVO . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $mar->MARCOD . '","excluir":"'. $mar->MARCOD . '"},';
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
