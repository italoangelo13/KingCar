<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Carros.php');
$car = new Carros();
$util = new Util();
$Json = null;
$codVeiculo = null;

try {
    if(isset($_GET)){
        $codVeiculo = $_GET['cod'];
    }

    $Veiculo = $car->SelecionaVeiculoPorCodParaAtualizacao($codVeiculo);
    if($Veiculo){
        if (count($Veiculo) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }

    $objVeiculo = new Carros();

    $objVeiculo->Id = $Veiculo[0]->CARCOD;
    $objVeiculo->Marca = $Veiculo[0]->CARCODMARCA; 
    $objVeiculo->Modelo = $Veiculo[0]->CARCODMODELO; 
    $objVeiculo->AnoFab = $Veiculo[0]->CARANOFAB; 
    $objVeiculo->AnoMod = $Veiculo[0]->CARANOMOD; 
    $objVeiculo->Cor = $Veiculo[0]->CARCODCOR; 
    $objVeiculo->Combustivel = $Veiculo[0]->CARCODCOMBUSTIVEL; 
    $objVeiculo->Cambio = $Veiculo[0]->CARCODCAMBIO; 
    $objVeiculo->Placa = $Veiculo[0]->CARPLACA;

    if($Veiculo[0]->CARREPASSE == 'S'){
        $objVeiculo->TipoAnuncio = 'R';
    }
    elseif($Veiculo[0]->CARSINISTRADO == 'S'){
        $objVeiculo->TipoAnuncio = 'S';
    }
    else{
        $objVeiculo->TipoAnuncio = 'N';
    }
    
    $objVeiculo->Carroceria = $Veiculo[0]->CARCARROCERIA;
    $objVeiculo->Destaque = $Veiculo[0]->CARDESTAQUE;
    $objVeiculo->Status = $Veiculo[0]->CARCODSTATUS;
    $objVeiculo->Versao = $Veiculo[0]->CARVERSAO;
    $objVeiculo->Motor = $Veiculo[0]->CARMOTOR;
    $objVeiculo->Valvulas = $Veiculo[0]->CARVALVULAS;
    $objVeiculo->Km = $Veiculo[0]->CARKM;
    $objVeiculo->Portas = $Veiculo[0]->CARPORTAS;
    $objVeiculo->Uf = $Veiculo[0]->CARUF;
    $objVeiculo->Municipio = $Veiculo[0]->CARCODMUNICIPIO;
    $objVeiculo->ImgCapa = $Veiculo[0]->CARFOTO;
    $objVeiculo->Troca = $Veiculo[0]->CARTROCA;
    $objVeiculo->NomeAnunciante = $Veiculo[0]->CARNOMEANUNCIANTE;
    $objVeiculo->EmailAnunciante = $Veiculo[0]->CAREMAILANUNCIANTE;
    $objVeiculo->TelAnunciante = $Veiculo[0]->CARTELANUNCIANTE;
    $objVeiculo->Preco = $Veiculo[0]->CARPRECO;
    $stringVeiculo =  json_encode($objVeiculo);
    if (count($Veiculo)) {
        $Json = '[';
        $Json = $Json .  '{"TransCod":1,"Veiculo":'.$stringVeiculo.'}]';
            
        $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
