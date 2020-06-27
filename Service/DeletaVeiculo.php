<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Carros.php');
$carros = new Carros();
$util = new Util();
$codVeiculo = null;
$Json = null;
try {

    if (isset($_GET)) {
        $codVeiculo = $_GET['cod'];
    }

    if (!$codVeiculo) {
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Codigo do Veiculo não informado."}]');
    } else {
        $imgVeiculo = $carros->SelecionarImagemVeiculoPorCod($codVeiculo);
        $imagem = $imgVeiculo[0]->CARFOTO;
        $caminhoImg = '../assets/img/Carros/' . $imagem;
        if ($carros->DeletaVeiculoPorCod($codVeiculo)) {
            unlink($caminhoImg);
            $pasta = '../assets/img/carros/'.$codVeiculo.'/';
            if (is_dir($pasta)) {
                $diretorio = dir($pasta);

                while ($arquivo = $diretorio->read()) {
                    if (($arquivo != '.') && ($arquivo != '..')) {
                        unlink($pasta . $arquivo);
                    }
                }

                $diretorio->close();
                rmdir($pasta);
            } 
            $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Veiculo Deletado com Sucesso."}]');
        }
    }



    //$Json = $util->convert_from_latin1_to_utf8_recursively($Json);
    echo json_encode($Json);
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
