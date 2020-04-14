<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Anuncios.php');
$anuncio = new Anuncios();
$util = new Util();
$Json = null;
$codAnun = null;

try {
    if(isset($_GET)){
        $codAnun = $_GET['cod'];
    }

    $Anuncio = $anuncio->SelecionarAnuncioPorCod($codAnun);
    if($Anuncio){
        if (count($Anuncio) === 0) {
            $Json = '[]';
            echo json_encode($Json);
        }
    }
    else{
        $Json = '[]';
        echo json_encode($Json);
        return;
    }
    

    if (count($Anuncio)) {
        $date = new DateTime($Anuncio[0]->SOLDTCADASTRO);
        $Json = '[';
        $Json = $Json .  '{"anunciante":"' . $Anuncio[0]->SOLANOME . '","email":"' . $Anuncio[0]->SOLEMAIL . '","dtCadastro":"' . $date->format( 'd/m/Y H:i') . '","imagem":"' . $Anuncio[0]->SOLFOTOCAPA . '","veiculo":"' . $Anuncio[0]->VEICULO . '","marca":"' . $Anuncio[0]->MARDESCRICAO . '","modelo":"' . $Anuncio[0]->MODDESCRICAO . '","ano":"' . $Anuncio[0]->SOLANO . '","cor":"' . $Anuncio[0]->CORDESCRICAO . '","combustivel":"' . $Anuncio[0]->COMDESCRICAO . '","cambio":"' . $Anuncio[0]->CAMDESCRICAO . '","km":"' . $Anuncio[0]->SOLKM . '","preco":"' . $Anuncio[0]->SOLPRECO . '","troca":"' . $Anuncio[0]->SOLTROCA . '"}]';
            
        $Json = $util->convert_from_latin1_to_utf8_recursively($Json);
        echo json_encode($Json);
    }
} catch (Exception $e) {
    echo '[{"TransCod":0, "erro":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
}
