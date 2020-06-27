<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Usuarios.php');
$usuario = new Usuarios();
$util = new Util();
$codUsu = null;
$Json = null;
try {

    // $pdo = new PDO(server, user, senha);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $smtp = $pdo->prepare("SELECT MUNCODIGOIBGE, MUNDESCRICAO FROM KGCTBLMUN where MUNUF = '".$Uf."' limit 10");
    // $smtp->execute();
    // $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    if(isset($_GET)){
        $codUsu = $_GET['cod'];
    }

    if (!$codUsu) {
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Codigo de Usuario não informado."}]');
    }
    else{
        if($usuario->DeletaUsuarioPorCod($codUsu)){
            $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Usuario Deletado com Sucesso."}]');
        }
    }

    

    //$Json = $util->convert_from_latin1_to_utf8_recursively($Json);
    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
