<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Motor.php');
$motor = new Motor();
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

    // $smtp = $pdo->prepare("SELECT MOTCOD, MOTPOTENCIA FROM KGCTBLMOT where MUNUF = '".$Uf."' limit 10");
    // $smtp->execute();
    // $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    $listaMot = $motor->SelecionarListaMotor();
    if (count($listaMot) === 0) {
        echo '[{"TransCod":0, "erro":"Nenhuma Potência de Motor Encontrada."}]';
    }

    if (count($listaMot)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaMot);
        foreach ($listaMot as $mot) {

            if ($cont == $total) {
                $Json = $Json .  '{"MOTCOD":"' . $mot->MOTCOD . '","MOTPOTENCIA":"' . $mot->MOTPOTENCIA . '"}]';
            } else {
                $Json = $Json . '{"MOTCOD":"' . $mot->MOTCOD . '","MOTPOTENCIA":"' . $mot->MOTPOTENCIA . '"},';
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
