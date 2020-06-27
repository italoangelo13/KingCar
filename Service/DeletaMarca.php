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
$codMarca = null;
$Json = null;
try {

    // $pdo = new PDO(server, user, senha);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $smtp = $pdo->prepare("SELECT MUNCODIGOIBGE, MUNDESCRICAO FROM KGCTBLMUN where MUNUF = '".$Uf."' limit 10");
    // $smtp->execute();
    // $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    if(isset($_GET)){
        $codMarca = $_GET['cod'];
    }

    if (!$codMarca) {
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Codigo da Marca não informado."}]');
    }
    else{
        if($marca->VerificaExisteModeloParaMarca($codMarca)){
            $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":2, "msg":"Esta Marca Ja Esta sendo Utilizada por Algum Modelo. <br> Nao e possivel excluir Esta Marca."}]');
        }
        else{
            if($marca->DeletaMarcaPorCod($codMarca)){
                $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Marca Deletada com Sucesso."}]');
            }
        }
    }

    

    //$Json = $util->convert_from_latin1_to_utf8_recursively($Json);
    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
