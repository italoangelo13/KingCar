<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache

include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Institucional.php');
$vxobInst = new Institucional();
$util = new Util();
$sobre = null;
$dif = null;
$missao = null;
$visao = null;
$valores = null;
$Json = null;
try {

    if (isset($_GET)) {
        $sobre = $_GET['cod'];

        if (isset($_GET['dif'])) {
            $dif = $_GET['dif'];
        }

        if (isset($_GET['missao'])) {
            $missao = $_GET['missao'];
        }

        if (isset($_GET['visao'])) {
            $visao = $_GET['visao'];
        }

        if (isset($_GET['valores'])) {
            $valores = $_GET['valores'];
        }
    }

    $vxobInst->Sobre = $sobre;
    $vxobInst->Diferencial = $dif;
    $vxobInst->Missao = $missao;
    $vxobInst->Valores = $valores;
    $vxobInst->Visao = $visao;

    if ($vxobInst->ExisteInstitucional()) {
        if ($vxobInst->AtualizaInstitucional()) {
            $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":2, "msg":"Informações Institucionais Atualizadas com Sucesso."}]');
        } else {
            $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Atualizar as informações Institucionais."}]');
        }
    } else {
        if ($vxobInst->InsereInstitucional()) {
            $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":2, "msg":"Informações Institucionais Inseridas com Sucesso."}]');
        } else {
            $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Incluir as informações Institucionais."}]');
        }
    }

    echo json_encode($Json);
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
