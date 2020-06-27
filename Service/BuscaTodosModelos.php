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

try {

    // $pdo = new PDO(server, user, senha);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $smtp = $pdo->prepare("SELECT MUNCODIGOIBGE, MUNDESCRICAO FROM KGCTBLMUN where MUNUF = '".$Uf."' limit 10");
    // $smtp->execute();
    // $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    $listaModelo = $modelo->SelecionarListaTodosModelos();
    if($listaModelo){
        if (count($listaModelo) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaModelo)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaModelo);
        foreach ($listaModelo as $mod) {
            $date = new DateTime($mod->MODDATCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $mod->MODCOD . '","modelo":"' . $mod->MODDESCRICAO . '","marca":"' . $mod->MARDESCRICAO . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $mod->MODCOD . '","excluir":"'. $mod->MODCOD . '"}]';
            } else {
                $Json = $Json .  '{"id":"' . $mod->MODCOD . '","modelo":"' . $mod->MODDESCRICAO . '","marca":"' . $mod->MARDESCRICAO . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $mod->MODCOD . '","excluir":"'. $mod->MODCOD . '"},';
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
