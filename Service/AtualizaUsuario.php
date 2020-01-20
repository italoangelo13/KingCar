<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache

include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Usuarios.php');
$vxobusu = new Usuarios();
$util = new Util();
$cod = null;
$nome = null;
$usuario = null;
$senha = null;
$Json = null;
try {
    
    if(isset($_GET)){
        $cod = $_GET['cod'];
        $nome = $_GET['nome'];
        $usuario = strtoupper($_GET['usuario']);
        $senha = md5($_GET['senha']);
    }

    if(!$vxobusu->VerificaSenhaAnterior($senha,$cod)){
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":3, "msg":"Senha Identica à anterior"}]');
        echo json_encode($Json);
        return;
    }

    session_start();
    $vxobusu->cod = $cod;
    $vxobusu->nome = $nome;
    $vxobusu->usuario = strtoupper($usuario);
    $vxobusu->senha = $senha;
    $vxobusu->user = $_SESSION['Usuario'];
    if($vxobusu->AtualizaUsuario()){
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":4, "msg":"Usuário Atualizado com Sucesso."}]');
    }
    else{
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Atualizar este usuario."}]'); 
    }

    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
