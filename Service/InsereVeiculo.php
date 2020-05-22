<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache


//xdebug_break();
include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Carros.php');
require_once('../Models/Versoes.php');
$vxobCar = new Carros();
$vxobVer = new Versoes();
$util = new Util();
$imagem = null;
$Json = null;
try {
    session_start();
    $user = $_SESSION['Usuario'];
    if (isset($_POST)) {
        $date = date('dmYHis');
        $placa = strtoupper(str_replace('-', '', $_POST['placa']));
        $tpAnun = $_POST['tipoVeiculo'];
        $carroceria = $_POST['carroceria'];
        $destaque = $_POST['destaque'];
        $status = $_POST['status'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $versao = $_POST['versao'];
        if (isset($_POST['txtversao'])) {
            $txtversao = $_POST['txtversao'];
        } else {
            $txtversao = "";
        }

        $anoFab = $_POST['anoFab'];
        $anoMod = $_POST['anoMod'];
        $uf = $_POST['uf'];
        $municipio = $_POST['municipio'];
        $motor = $_POST['motor'];
        $valvula = $_POST['valvula'];
        $portas = $_POST['portas'];
        $km = $_POST['km'];
        $preco = $_POST['preco'];
        $cor = $_POST['cor'];
        $cambio = $_POST['cambio'];
        $combustivel = $_POST['combustivel'];
        $troca = $_POST['troca'];
        $infoAd = $util->tirarAcento(strtoupper($_POST['infoAd']));

        $nomeAnum = $_POST['nomeAnun'];
        $emailAnum = $_POST['emailAnun'];
        $telAnum = $_POST['telAnun'];


        $det = $_POST['det'];

        $dir                = $path_parts = pathinfo($_FILES['_edImagemCapa']['name']);
        $dirNovo            = "../assets/img/Carros/"; //diretorio de destino
        $ext                = $path_parts['extension'];
        $nomeNovo            = trim(date('YmdGis') . '-' . $marca . $modelo . trim($nomeAnum) . trim($uf) . $municipio . '.' . $ext);
        $destino            = $dirNovo . $nomeNovo;
        $arquivo_tmp        = $_FILES['_edImagemCapa']['tmp_name'];
        $vxvaImg            = $nomeNovo;

        //Inserindo nova versão
        if ($versao == "0") {
            $vxobVer->Marca = $marca;
            $vxobVer->Modelo = $modelo;
            $vxobVer->Versao = $txtversao;
            $vxobVer->User = $user;
            if ($vxobVer->InsereVersao()) {
                $codVersao = $vxobVer->BuscaUltimoCodPorUser();
                $versao = $codVersao;
            }
        }
    }

    //TRATANDO VALORES
    $km = str_replace('.','',$km);
    $km = str_replace(',','.',$km);
    $km = doubleval($km);

    $preco = str_replace('.','',$preco);
    $preco = str_replace(',','.',$preco);
    $preco = doubleval($preco);

    

    $vxobCar->User = $user;
    $vxobCar->Placa  = $placa;
    $vxobCar->TipoAnuncio = $tpAnun;
    $vxobCar->Carroceria = $carroceria;
    $vxobCar->Destaque = $destaque;
    $vxobCar->Status = $status;
    $vxobCar->Marca = $marca;
    $vxobCar->Modelo = $modelo;
    $vxobCar->Versao = $versao;
    $vxobCar->AnoFab = $anoFab;
    $vxobCar->AnoMod = $anoMod;
    $vxobCar->Motor = $motor;
    $vxobCar->Valvulas = $valvula;
    $vxobCar->Km = $km;
    $vxobCar->Preco = $preco;
    $vxobCar->Cambio = $cambio;
    $vxobCar->Combustivel = $combustivel;
    $vxobCar->Portas = $portas;
    $vxobCar->Cor = $cor;
    $vxobCar->Uf = $uf;
    $vxobCar->Municipio = $municipio;
    $vxobCar->ImgCapa = $vxvaImg;
    $vxobCar->Troca = $troca;
    $vxobCar->NomeAnunciante = $nomeAnum;
    $vxobCar->EmailAnunciante = $emailAnum;
    $vxobCar->TelAnunciante = $telAnum;

    if ($tpAnun == "R") {
        if (is_dir('../assets/img/Carros/')) {
            if (move_uploaded_file($arquivo_tmp, $destino)) {
                if ($vxobCar->InsereCarroRepasse()) {
                    $Ultcod = $vxobCar->BuscaUltimoCodCarroUser($user);
                    foreach($det as $d){
                        $CodItem = $vxobCar->BuscaItemPorCod($d);
                        $vxobCar->InsereItensCarro($CodItem[0]->COMPCOD,$Ultcod[0]->CARCOD,$user);
                    }
                    $arr = array('TransCod' => 1, 'Ultcod' => $Ultcod[0]->CARCOD);
                    $Json = '[{"TransCod":1, "msg":"Veiculo Cadastrado com Sucesso.","UltCod":' . $Ultcod[0]->CARCOD . '}]';
                } else {
                    $Json = '[{"TransCod":0, "msg":"Não foi Possivel Cadastrar este Veiculo."}]';
                }
            }
        } else {
            mkdir('../assets/img/Carros/');
            if (move_uploaded_file($arquivo_tmp, $destino)) {
                if ($vxobCar->InsereCarroRepasse()) {
                    $Ultcod = $vxobCar->BuscaUltimoCodCarroUser($user);
                    foreach($det as $d){
                        $CodItem = $vxobCar->BuscaItemPorCod($d);
                        $vxobCar->InsereItensCarro($CodItem[0]->COMPCOD,$Ultcod[0]->CARCOD,$user);
                    }
                    $Json = '[{"TransCod":1, "msg":"Veiculo Cadastrado com Sucesso.","UltCod":' . $Ultcod[0]->CARCOD . '}]';
                } else {
                    $Json = '[{"TransCod":0, "msg":"Não foi Possivel Cadastrar este Veiculo."}]';
                }
            }
        }
    } else if ($tpAnun == "S") {
        if (is_dir('../assets/img/Carros/')) {
            if (move_uploaded_file($arquivo_tmp, $destino)) {
                if ($vxobCar->InsereCarroSinistrado()) {
                    $Ultcod = $vxobCar->BuscaUltimoCodCarroUser($user);
                    foreach($det as $d){
                        $CodItem = $vxobCar->BuscaItemPorCod($d);
                        $vxobCar->InsereItensCarro($CodItem[0]->COMPCOD,$Ultcod[0]->CARCOD,$user);
                    }
                    $Json = '[{"TransCod":1, "msg":"Veiculo Cadastrado com Sucesso.","UltCod":' . $Ultcod[0]->CARCOD . '}]';
                } else {
                    $Json = '[{"TransCod":0, "msg":"Não foi Possivel Cadastrar este Veiculo."}]';
                }
            }
        } else {
            mkdir('../assets/img/Carros/');
            if (move_uploaded_file($arquivo_tmp, $destino)) {
                if ($vxobCar->InsereCarroSinistrado()) {
                    $Ultcod = $vxobCar->BuscaUltimoCodCarroUser($user);
                    foreach($det as $d){
                        $CodItem = $vxobCar->BuscaItemPorCod($d);
                        $vxobCar->InsereItensCarro($CodItem[0]->COMPCOD,$Ultcod[0]->CARCOD,$user);
                    }
                    $Json = '[{"TransCod":1, "msg":"Veiculo Cadastrado com Sucesso.","UltCod":' . $Ultcod[0]->CARCOD . '}]';
                } else {
                    $Json = '[{"TransCod":0, "msg":"Não foi Possivel Cadastrar este Veiculo."}]';
                }
            }
        }
    } else {
        if (is_dir('../assets/img/Carros/')) {
            if (move_uploaded_file($arquivo_tmp, $destino)) {
                if ($vxobCar->InsereCarroSemiNovo()) {
                    $Ultcod = $vxobCar->BuscaUltimoCodCarroUser($user);
                    foreach($det as $d){
                        $CodItem = $vxobCar->BuscaItemPorCod($d);
                        $vxobCar->InsereItensCarro($CodItem[0]->COMPCOD,$Ultcod[0]->CARCOD,$user);
                    }
                    $Json = '[{"TransCod":1, "msg":"Veiculo Cadastrado com Sucesso.","UltCod":' . $Ultcod[0]->CARCOD . '}]';
                } else {
                    $Json = '[{"TransCod":0, "msg":"Não foi Possivel Cadastrar este Veiculo."}]';
                }
            }
        } else {
            mkdir('../assets/img/Carros/');
            if (move_uploaded_file($arquivo_tmp, $destino)) {
                if ($vxobCar->InsereCarroSemiNovo()) {
                    $Ultcod = $vxobCar->BuscaUltimoCodCarroUser($user);
                    foreach($det as $d){
                        $CodItem = $vxobCar->BuscaItemPorCod($d);
                        $vxobCar->InsereItensCarro($CodItem[0]->COMPCOD,$Ultcod[0]->CARCOD,$user);
                    }
                    $Json = '[{"TransCod":1, "msg":"Veiculo Cadastrado com Sucesso.","UltCod":' . $Ultcod[0]->CARCOD . '}]';
                } else {
                    $Json = '[{"TransCod":0, "msg":"Não foi Possivel Cadastrar este Veiculo."}]';
                }
            }
        }
    }

    echo json_encode($Json);
} catch (Exception $e) {
    $Json = '[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'; // opcional, apenas para teste
    echo json_encode($Json);
}
