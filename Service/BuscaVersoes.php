<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Versoes.php');
$v = new Versoes();
$util = new Util();
$Json = null;

try {
    if ($_GET){
        $CODMARCA = $_GET['marca'];
        $CODMODELO = $_GET['modelo'];
    } else {
        echo '[{"erro":"Sem parametros na url"}]';
        exit(); //para a aplicação PHP
    }

    // $pdo = new PDO(server, user, senha);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $smtp = $pdo->prepare("SELECT MUNCODIGOIBGE, MUNDESCRICAO FROM kgctblmun where MUNUF = '".$Uf."' limit 10");
    // $smtp->execute();
    // $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    $listaVersoes = $v->SelecionarVersaoPorModelo($CODMODELO,$CODMARCA);
    if($listaVersoes){
        if (count($listaVersoes) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaVersoes)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaVersoes);
        foreach ($listaVersoes as $ver) {
            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $ver->VERCOD . '","versao":"' . $ver->VERNOME . '"}]';
            } else {
                $Json = $Json .  '{"id":"' . $ver->VERCOD . '","versao":"' . $ver->VERNOME . '"},';
            }
            $cont++;
        }

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
