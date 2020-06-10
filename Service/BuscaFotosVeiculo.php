<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
//require_once('../Models/Municipios.php');
//$imgicipio = new Municipios();

$util = new Util();
if ($_GET) {
    $cod = $_GET['cod'];
} else {
    echo '[{"erro":"Sem parametros na url"}]';
    exit(); //para a aplicação PHP
}

try {

    // $pdo = new PDO(server, user, senha);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $smtp = $pdo->prepare("SELECT NOMEIMG, MUNDESCRICAO FROM kgctblimg where MUNUF = '".$Uf."' limit 10");
    // $smtp->execute();
    // $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    $imagens = array();
    if (is_dir('../assets/img/Carros/' . $cod)) {
        $diretorio = dir('../assets/img/Carros/' . $cod);
        while ($arquivo = $diretorio->read()) {
            if($arquivo != "." && $arquivo != ".."){
                $imagens[] =  $arquivo;
            }
            
        }
    } else {
        echo '[{"TransCod":2, "erro":"Não Existe imagens para este Veiculo."}]';
        exit;
    }

    if (count($imagens) > 0) {
        $Json = '[{"TransCod":1, "erro":"Imagens Carregadas com Sucesso."},{"Imagens":[';
        $cont = 1;
        $total = count($imagens);
        foreach ($imagens as $img) {

            if ($cont == $total) {
                $Json = $Json .  '{"NOMEIMG":"' . $img . '"}]}]';
            } else {
                $Json = $Json . '{"NOMEIMG":"' . $img . '"},';
            }
            $cont++;
        }

        $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
    else{
        echo '[{"TransCod":2, "erro":"Não Existe imagens para este Veiculo."}]';
        exit;
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
