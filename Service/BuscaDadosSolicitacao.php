<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Contatos.php');
$contato = new Contatos();
$util = new Util();
$Json = null;
$codSol = null;

try {
    if(isset($_GET)){
        $codSol = $_GET['cod'];
    }

    $con = $contato->SelecionarContatoPorCod($codSol);
    if($con){
        if (count($con) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($con)) {
        $date = new DateTime($con[0]->CONDATCADASTRO);
        $data = date_format($date,'d/m/Y');
        $hora = date_format($date,'H:i');
        $dataEnvio = $data . ' as ' . $hora;
        $mensagem = trim($con[0]->CONMENSAGEM,"\r\n");
        $mensagem = str_replace("\r\n","",$mensagem);
        $Json = '';
        $Json = $Json .  '{"msg":"' . $mensagem . '","nome":"' . $con[0]->CONNOME . '","email":"' . $con[0]->CONEMAIL . '","tel":"' . $con[0]->CONTEL . '","dataSolicitacao":"' . $dataEnvio . '","assunto":"' . $con[0]->CONASSUNTO . '"}';
            
        $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);

        // if ($Json) {
        //     echo $json;
        // } else
        //     echo json_last_error_msg();

        // echo json_encode($result);
    }

    $contato->AtualizaStatusContato($codSol);
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
