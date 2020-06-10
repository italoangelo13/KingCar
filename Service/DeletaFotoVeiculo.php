<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
$util = new Util();
$Json = null;
try {
    if(isset($_GET)){
        $cod = $_GET['cod'];
        $img = $_GET['nome'];
    }

    $imagem = $img;
    if (file_exists('../assets/img/Carros/' . $cod.'/'.$imagem)) {
        if(unlink('../assets/img/Carros/' . $cod.'/'.$imagem)){
            echo '{"TransCod":1, "msg":"Foto Excluida com sucesso."}';
            exit;
        }
        else{
            echo '{"TransCod":0, "erro":"Não foi possivel excluir essa foto."}';
        exit;
        }
    } else {
        echo '{"TransCod":0, "erro":"Não foi possivel excluir essa foto."}';
        exit;
    }
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
