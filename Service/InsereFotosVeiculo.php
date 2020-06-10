<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache


//xdebug_break();
include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
$util = new Util();
$cod = null;
$Json = null;
try {
    if (isset($_POST)) {
        $cod = $_POST['_edCodVeiculo'];
    }

    if (isset($_FILES)) {
        $diretorio = '../assets/img/Carros/' . $cod;
        if (!is_dir($diretorio)) {
            mkdir($diretorio);
            $arquivo = isset($_FILES['_edFotosVeiculo']) ? $_FILES['_edFotosVeiculo'] : FALSE;
            for ($controle = 0; $controle < count($arquivo['name']); $controle++) {
                $destino = $diretorio . "/" . $arquivo['name'][$controle];
                move_uploaded_file($arquivo['tmp_name'][$controle], $destino);
            }
        } else {
            $arquivo = isset($_FILES['_edFotosVeiculo']) ? $_FILES['_edFotosVeiculo'] : FALSE;
            for ($controle = 0; $controle < count($arquivo['name']); $controle++) {
                $destino = $diretorio . "/" . $arquivo['name'][$controle];
                move_uploaded_file($arquivo['tmp_name'][$controle], $destino);
            }
        }
    }

    $Json = '[{"TransCod":1, "msg":"Fotos Cadastradas Com sucesso."}]';
    echo json_encode($Json);
} catch (Exception $e) {
    $Json = '[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
    echo json_encode($Json);
}
