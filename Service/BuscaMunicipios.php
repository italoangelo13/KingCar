<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Municipios.php');
$municipio = new Municipios();
$util = new Util();
if ($_GET) {
    $Uf = $_GET['Uf'];
} else {
    echo '[{"erro":"Sem parametros na url"}]';
    exit(); //para a aplicação PHP
}

try {

    // $pdo = new PDO(server, user, senha);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $smtp = $pdo->prepare("SELECT MUNCODIGOIBGE, MUNDESCRICAO FROM KGCTBLMUN where MUNUF = '".$Uf."' limit 10");
    // $smtp->execute();
    // $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    $listaMun = $municipio->SelecionarListaMunicipiosPorUf($Uf);
    if (count($listaMun) === 0) {
        echo '[{"TransCod":0, "erro":"Nenhum Municipio encontrado para este Estado."}]';
    }

    if (count($listaMun)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaMun);
        foreach ($listaMun as $mun) {

            if ($cont == $total) {
                $Json = $Json .  '{"MUNCODIGOIBGE":"' . $mun->MUNCODIGOIBGE . '","MUNDESCRICAO":"' . $mun->MUNDESCRICAO . '"}]';
            } else {
                $Json = $Json . '{"MUNCODIGOIBGE":"' . $mun->MUNCODIGOIBGE . '","MUNDESCRICAO":"' . $mun->MUNDESCRICAO . '"},';
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
