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


try {

    // $pdo = new PDO(server, user, senha);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $smtp = $pdo->prepare("SELECT MUNCODIGOIBGE, MUNDESCRICAO FROM kgctblmun where MUNUF = '".$Uf."' limit 10");
    // $smtp->execute();
    // $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    $listaUsu = $usuario->SelecionarUsuarios();
    if (count($listaUsu) === 0) {
        echo '[{"TransCod":0, "erro":"Nenhum Usuario encontrado."}]';
    }

    if (count($listaUsu)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaUsu);
        foreach ($listaUsu as $usu) {

            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $usu->USUCOD . '","nome":"' . $usu->USUNOME . '","usuario":"' . $usu->USUUSUARIO . '","dtcadastro":"' . $usu->USUDATCADASTRO . '","editar":"<a class="btn btn-success" href="InsereAtualizaUsuario.php?acao=editar&cod='. $usu->USUCOD . '> <i class="icone-pencil"></i></a>","excluir":"<a class="btn btn-danger" href="CrudUsuario.php?acao=del&cod='. $usu->USUCOD . '> <i class="icone-trash"></i></a>"}]';
            } else {
                //$Json = $Json . '{"MUNCODIGOIBGE":"' . $usu->MUNCODIGOIBGE . '","MUNDESCRICAO":"' . $usu->MUNDESCRICAO . '"},';
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
