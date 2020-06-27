<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
$util = new Util();
// if ($_GET) {
//     $Uf = $_GET['Uf'];
// } else {
//     echo '[{"erro":"Sem parametros na url"}]';
//     exit(); //para a aplicação PHP
// }

try {

    // $pdo = new PDO(server, user, senha);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $smtp = $pdo->prepare("SELECT COMPCOD, COMPDESC FROM kgctblitem where MUNUF = '".$Uf."' limit 10");
    // $smtp->execute();
    // $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    $listaItens = $util->SelecionarItensVeiculo();
    if (count($listaItens) === 0) {
        echo '[{"TransCod":0, "erro":"Nenhum item encontrado."}]';
    }

    if (count($listaItens)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaItens);
        foreach ($listaItens as $item) {

            if ($cont == $total) {
                $Json = $Json .  '{"COMPCOD":"' . $item->COMPCOD . '","COMPDESC":"' . $item->COMPDESC . '","COMPNOMCAMPO":"' . $item->COMPNOMCAMPO . '"}]';
            } else {
                $Json = $Json . '{"COMPCOD":"' . $item->COMPCOD . '","COMPDESC":"' . $item->COMPDESC . '","COMPNOMCAMPO":"' . $item->COMPNOMCAMPO . '"},';
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
