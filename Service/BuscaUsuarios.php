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
$Json = null;

try {

    // $pdo = new PDO(server, user, senha);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $smtp = $pdo->prepare("SELECT MUNCODIGOIBGE, MUNDESCRICAO FROM KGCTBLMUN where MUNUF = '".$Uf."' limit 10");
    // $smtp->execute();
    // $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    $listaUsu = $usuario->SelecionarUsuarios();
    if($listaUsu){
        if (count($listaUsu) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($listaUsu)) {
        $Json = '[';
        $cont = 1;
        $total = count($listaUsu);
        foreach ($listaUsu as $usu) {
            $date = new DateTime($usu->USUDATCADASTRO);
            if ($cont == $total) {
                $Json = $Json .  '{"id":"' . $usu->USUCOD . '","nome":"' . $usu->USUNOME . '","usuario":"' . $usu->USUUSUARIO . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $usu->USUCOD . '","excluir":"'. $usu->USUCOD . '"}]';
            } else {
                $Json = $Json .  '{"id":"' . $usu->USUCOD . '","nome":"' . $usu->USUNOME . '","usuario":"' . $usu->USUUSUARIO . '","dtcadastro":"' . $date->format( 'd/m/Y') . '","editar":"'. $usu->USUCOD . '","excluir":"'. $usu->USUCOD . '"},';
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
