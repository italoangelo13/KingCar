<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Compra.php');
$compra = new Compra();
$util = new Util();
$Json = null;
$codSol = null;

try {
    if(isset($_GET)){
        $codSol = $_GET['cod'];
    }

    $com = $compra->SelecionarSolicitacaoPorCod($codSol);
    if($com){
        if (count($com) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($com)) {
        $date = new DateTime($com[0]->COMDATCADASTRO);
        $mensagem = trim($com[0]->COMMSG,"\r\n");
        $Json = '';
        $Json = $Json .  '{"msg":"' . $com[0]->COMMSG . '","nome":"' . $com[0]->COMNOME . '","email":"' . $com[0]->COMEMAIL . '","tel":"' . $com[0]->COMTEL . '","dataSolicitacao":"' . date_format($date,'d/m/Y') . '","codCarro":"' . $com[0]->CARCOD . '","marca":"' . $com[0]->MARDESCRICAO . '","modelo":"' . $com[0]->MODDESCRICAO . '","ano":"' . $com[0]->CARANO . '","foto":"' . $com[0]->CARFOTO . '","preco":"' . $com[0]->CARPRECO . '"}';
            
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
