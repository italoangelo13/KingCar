<?php
include_once 'header.inc.php';
header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Carros.php';
require_once '../Models/Marcas.php';
require_once '../Models/Modelos.php';
require_once '../Models/Municipios.php';
require_once '../Models/Cambios.php';
require_once '../Models/Combustiveis.php';
require_once '../Models/Cores.php';


$util = new Util();
$Carro = new Carros();
$marca = new Marcas();
$modelo = new Modelos();
$municipio = new Municipios();
$cambio = new Cambios();
$combustivel = new Combustiveis();
$cor = new Cores();

$listaMarcas = $marca->SelecionarListaMarcas();
$listaUf = $municipio->SelecionarListaUf();
$listaCambios = $cambio->SelecionarListaCambio();
$listaCombustiveis = $combustivel->SelecionarListaCombustivel();
$listaCor = $cor->SelecionarListaCores();

$numCarros = 0;
$dataAtual = date("d/m/Y");
$anoAtual = date("Y");
$contador = 40;
$caminhoImg = null;

$strCount = $Carro->SelecionaTotalNumCarros();
$total = 0;
if (count($strCount)) {
    foreach ($strCount as $row) {
        //armazeno o total de registros da tabela para fazer a paginação
        $total = $row->NUMCARROS;
        $numCarros = $row->NUMCARROS;
    }
}


$vxvaCod            = "0";
$vxvaUser           = "";
$vxvaTitulo         = "";
$vxvaValor          = "";
$vxvaDataCad        = "";
$vxvaMarca          = "";
$vxvaModelo         = "";
$vxvaAno            = "";
$vxvaKm             = "";
$vxvaCambio         = "";
$vxvaCombustivel    = "";
$vxvaPortas         = "";
$vxvaCor            = "";
$vxvaUf             = "";
$vxvaMunicipio      = "";
$vxvaStatus         = "";
$vxvaDestaque       = "";
$vxvaTroca          = "";
$vxvaImg            = "";
if (!isset($_POST['salvar'])) {
    $_SESSION['imgCar'] = "";
}

if(isset($_POST['Fotos'])){
    $diretorio = "../assets/img/carros/".$_POST['_edCodCarroFotos'];
    if(!is_dir($diretorio)){
        mkdir($diretorio);
    }
    $arquivo = isset($_FILES['_edFotosCarro']) ? $_FILES['_edFotosCarro'] : FALSE;
    for ($controle = 0; $controle < count($arquivo['name']); $controle++){        
        $destino = $diretorio."/".$arquivo['name'][$controle];
        //realizar o upload da imagem em php
        //move_uploaded_file — Move um arquivo enviado para uma nova localização
        move_uploaded_file($arquivo['tmp_name'][$controle], $destino);    
    }

}

if (isset($_GET['acao'])) {
    if ($_GET['acao'] == "editar") {
        echo "<script>showLoad('Aguarde <br> Carregando as informações do Veículo.');</script> ";
        $vxvaCod = $_GET['cod'];
        $_SESSION['codCar'] = $vxvaCod;

        $InfoCarro = $Carro->SelecionaCarroPorCod($vxvaCod);

        foreach ($InfoCarro as $linhaInfoCarro) {
            $vxvaTitulo         = $linhaInfoCarro->CARNOME;
            $vxvaMarca          = $linhaInfoCarro->CARCODMARCA;
            $vxvaModelo         = $linhaInfoCarro->CARCODMODELO;
            $vxvaValor          = $linhaInfoCarro->CARPRECO;
            $vxvaAno            = $linhaInfoCarro->CARANO;
            $vxvaImg            = $linhaInfoCarro->CARFOTO;
            $_SESSION['imgCar'] = $linhaInfoCarro->CARFOTO;
            $vxvaStatus         = $linhaInfoCarro->CARCODSTATUS;
            $vxvaKm             = $linhaInfoCarro->CARKM;
            $vxvaCambio         = $linhaInfoCarro->CARCODCAMBIO;
            $vxvaPortas         = $linhaInfoCarro->CARPORTAS;
            $vxvaCombustivel    = $linhaInfoCarro->CARCODCOMBUSTIVEL;
            $vxvaCor            = $linhaInfoCarro->CARCODCOR;
            $vxvaTroca          = $linhaInfoCarro->CARTROCA;
            $vxvaDestaque       = $linhaInfoCarro->CARDESTAQUE;
            $vxvaDataCad        = $linhaInfoCarro->CARDATCADASTRO;
            $vxvaMunicipio      = $linhaInfoCarro->CARCODMUNICIPIO;
            $vxvaUf             = $linhaInfoCarro->CARUF;

            echo "<script>localStorage.setItem('ModCod', '$vxvaModelo');</script>";
            echo "<script>localStorage.setItem('Mun', '$vxvaMunicipio');</script>";
        }

        echo "<script>hideLoad();</script>";
    }
    else if($_GET['acao'] == "delFoto"){
        echo "<script>showLoad('Aguarde <br> Excluindo Foto do Veículo.');</script> ";
        $vxvaCod = $_GET['cod'];
        $_SESSION['codCar'] = $vxvaCod;

        $InfoCarro = $Carro->SelecionaCarroPorCod($vxvaCod);

        foreach ($InfoCarro as $linhaInfoCarro) {
            $vxvaTitulo         = $linhaInfoCarro->CARNOME;
            $vxvaMarca          = $linhaInfoCarro->CARCODMARCA;
            $vxvaModelo         = $linhaInfoCarro->CARCODMODELO;
            $vxvaValor          = $linhaInfoCarro->CARPRECO;
            $vxvaAno            = $linhaInfoCarro->CARANO;
            $vxvaImg            = $linhaInfoCarro->CARFOTO;
            $_SESSION['imgCar'] = $linhaInfoCarro->CARFOTO;
            $vxvaStatus         = $linhaInfoCarro->CARCODSTATUS;
            $vxvaKm             = $linhaInfoCarro->CARKM;
            $vxvaCambio         = $linhaInfoCarro->CARCODCAMBIO;
            $vxvaPortas         = $linhaInfoCarro->CARPORTAS;
            $vxvaCombustivel    = $linhaInfoCarro->CARCODCOMBUSTIVEL;
            $vxvaCor            = $linhaInfoCarro->CARCODCOR;
            $vxvaTroca          = $linhaInfoCarro->CARTROCA;
            $vxvaDestaque       = $linhaInfoCarro->CARDESTAQUE;
            $vxvaDataCad        = $linhaInfoCarro->CARDATCADASTRO;
            $vxvaMunicipio      = $linhaInfoCarro->CARCODMUNICIPIO;
            $vxvaUf             = $linhaInfoCarro->CARUF;

            echo "<script>localStorage.setItem('ModCod', '$vxvaModelo');</script>";
            echo "<script>localStorage.setItem('Mun', '$vxvaMunicipio');</script>";
        }

        $foto = $_GET['foto'];
        $caminho = '../assets/img/Carros/'.$foto;
        unlink($caminho);

        echo "<script>hideLoad();</script>";
    }
} else {
    echo "<script>localStorage.setItem('ModCod', '');</script>";
    echo "<script>localStorage.setItem('Mun', '');</script>";
}


function DisparaEventoJs($evento)
{
    echo $evento;
}



if(isset($_POST['salvarInfoComp'])){
    echo "<script>showLoad('Aguarde <br> Registrando as Informações Complementares do Veiculo.');</script> ";
    $vxvaCod = $_SESSION['codCar'];

    $InfoCarro = $Carro->SelecionaCarroPorCod($vxvaCod);

    foreach ($InfoCarro as $linhaInfoCarro) {
        $vxvaTitulo         = $linhaInfoCarro->CARNOME;
        $vxvaMarca          = $linhaInfoCarro->CARCODMARCA;
        $vxvaModelo         = $linhaInfoCarro->CARCODMODELO;
        $vxvaValor          = $linhaInfoCarro->CARPRECO;
        $vxvaAno            = $linhaInfoCarro->CARANO;
        $vxvaImg            = $linhaInfoCarro->CARFOTO;
        $_SESSION['imgCar'] = $linhaInfoCarro->CARFOTO;
        $vxvaStatus         = $linhaInfoCarro->CARCODSTATUS;
        $vxvaKm             = $linhaInfoCarro->CARKM;
        $vxvaCambio         = $linhaInfoCarro->CARCODCAMBIO;
        $vxvaPortas         = $linhaInfoCarro->CARPORTAS;
        $vxvaCombustivel    = $linhaInfoCarro->CARCODCOMBUSTIVEL;
        $vxvaCor            = $linhaInfoCarro->CARCODCOR;
        $vxvaTroca          = $linhaInfoCarro->CARTROCA;
        $vxvaDestaque       = $linhaInfoCarro->CARDESTAQUE;
        $vxvaDataCad        = $linhaInfoCarro->CARDATCADASTRO;
        $vxvaMunicipio      = $linhaInfoCarro->CARCODMUNICIPIO;
        $vxvaUf             = $linhaInfoCarro->CARUF;
        echo "<script>localStorage.setItem('ModCod', '$vxvaModelo');</script>";
        echo "<script>localStorage.setItem('Mun', '$vxvaMunicipio');</script>";
    }


    $det = null;
    $infoComplementar = null;
    $codInfoComp = null;
    if(isset($_POST['det'])){
        $det = $_POST['det'];
    }

    $infoComplementar = $_POST['_edInfoAd'];

    if($Carro->VerificaExisteInfoComp($_SESSION['codCar'])){
        $codInfoComp = $Carro->BuscaCodInfoComp($_SESSION['codCar']);
    }
    else{
        $res = $Carro->InsereDetCarro($_SESSION['codCar'],$_SESSION['Usuario']);
        if($res > 0){
            $codInfoComp = $Carro->BuscaCodInfoComp($_SESSION['codCar']);
        }
        else{
            $codInfoComp = null; 
        }
    }


    if($codInfoComp == null){
        echo "<script>hideLoad();</script>";
        echo "<script>ErrorBox('Ocorreu um erro ao Registrar as Informações Complementares do Veiculo.');</script>";
    }
    else{
        $sqlInfoComp = "UPDATE KGCTBLDETCAR SET ";
        if($det){
            foreach($det as $linha){
                if($linha != 'on')
                $sqlInfoComp .= " ".$linha." = 'S', ";
            }
        }
        $sqlInfoComp .= " DETINFOCOMP = '$infoComplementar'  where detcod = $codInfoComp";

        if($Carro->AtualizaInfoComp($sqlInfoComp)){
            echo "<script>hideLoad();</script>";
            echo "<script>SuccessBox('Informações Complementares do Veiculo Atualizadas com sucesso.');</script>";
        }
        else{
            echo "<script>hideLoad();</script>";
            echo "<script>ErrorBox('Ocorreu um erro ao Registrar as Informações Complementares do Veiculo.');</script>";
        }
    }
    
    
}

?>


<?php
try {
    //VERIFICA SE O FORMULARIO FOI ENVIADO
    if (isset($_POST['salvar'])) {
        //EMITE MENSAGEM INFORMANDO QUE ESTA REALIZANDO VALIDAÇÃO NOS CAMPOS INFORMADOS
        echo "<script>showLoad('Aguarde <br> Realizando o Cadastro do Veículo.');</script> ";

        //PREENCHE VARIAVEIS COM OS CAMPOS INFORMADOS
        $vxvaCod            = $_POST['_edCodCarro'];
        $vxvaUser           = $_SESSION['Usuario'];
        $vxvaTitulo         = $_POST["_edTitulo"];
        $vxvaValor          = $_POST["_edValor"];
        $vxvaDataCad        = $_POST["_edDtCadastro"];
        $vxvaMarca          = $_POST["_ddlMarca"];
        $vxvaModelo         = $_POST["_ddlModelo"];
        $vxvaAno            = $_POST["_ddlAno"];
        $vxvaKm             = $_POST["_edKm"];
        $vxvaCambio         = $_POST["_ddlCamb"];
        $vxvaCombustivel    = $_POST["_ddlComb"];
        $vxvaPortas         = $_POST["_edNumPortas"];
        $vxvaCor            = $_POST["_ddlCor"];
        $vxvaUf             = $_POST["_ddlUf"];
        $vxvaMunicipio      = $_POST["_ddlMun"];
        $vxvaStatus         = $_POST["_ddlStatus"];
        $vxvaDestaque       = $_POST["_ddlDestaque"];
        $vxvaTroca          = $_POST["_ddlTroca"];
        if (isset($_FILES["_edImagemCapa"])) {
            if (strlen($_FILES["_edImagemCapa"]["name"]) > 0) {

                $dir                = $path_parts = pathinfo($_FILES['_edImagemCapa']['name']);
                $dirNovo            = "../assets/img/Carros/"; //diretorio de destino
                $ext                = $path_parts['extension'];
                $nomeNovo            = trim(date('YmdGis') . '-' . $vxvaMarca . $vxvaModelo . trim($vxvaAno) . trim($vxvaUf) . $vxvaMunicipio . '.' . $ext);
                $destino            = $dirNovo . $nomeNovo;
                $arquivo_tmp        = $_FILES['_edImagemCapa']['tmp_name'];
                $vxvaImg            = $nomeNovo;
            } else {
                $nomeNovo           = $_SESSION['imgCar'];
                $vxvaImg            = $_SESSION['imgCar'];
            }
        }



        if (strlen($vxvaCod) == 0) {
            $sqlInsert = "INSERT INTO KGCTBLCAR (CARNOME,CARCODMARCA,CARCODMODELO,CARPRECO,CARANO,CARFOTO,CARCODSTATUS,CARKM,CARCODCAMBIO,CARPORTAS,CARCODCOMBUSTIVEL,CARCODCOR,CARTROCA,CARDESTAQUE,CARDATCADASTRO,CARUSER,CARCODMUNICIPIO,CARUF)
                VALUES (    '" . $vxvaTitulo . "',
                            $vxvaMarca,
                            $vxvaModelo,
                            $vxvaValor,
                            '" . trim($vxvaAno) . "',
                            '$nomeNovo',
                            $vxvaStatus,
                            $vxvaKm,
                            $vxvaCambio,
                            $vxvaPortas,
                            $vxvaCombustivel,
                            $vxvaCor,
                            '$vxvaTroca',
                            '$vxvaDestaque',
                            CURRENT_TIMESTAMP,
                            '$vxvaUser',
                            $vxvaMunicipio,
                            '$vxvaUf'
                            )";
            $result = $Carro->InsereCarro($sqlInsert);


            move_uploaded_file($arquivo_tmp, $destino);

            $UltCod = $Carro->BuscaUltimoCodCarroUser($vxvaUser);
            if (count($UltCod)) {
                foreach ($UltCod as $row) {
                    //armazeno o total de registros da tabela para fazer a paginação
                    $vxvaCod = $row->CARCOD;
                    $_SESSION['codCar'] = $vxvaCod;
                }
            }

            $qtdeCarros = $Carro->SelecionaTotalNumCarros();
            if (count($qtdeCarros)) {
                foreach ($qtdeCarros as $row) {
                    $numCarros = $row->NUMCARROS;
                }
            }


            echo "<script>hideLoad();</script>";
            echo "<script>SuccessBox('Veiculo Cadastrado com Sucesso.');</script>";
        } else {
            $sqlUpdate = "update kgctblcar set
            CARNOME             = '" . $vxvaTitulo . "',
            CARCODMARCA         = $vxvaMarca,
            CARCODMODELO        = $vxvaModelo,
            CARPRECO            = $vxvaValor,
            CARANO              = '" . trim($vxvaAno) . "',
            CARFOTO             = '$nomeNovo',
            CARCODSTATUS        = $vxvaStatus,
            CARKM               = $vxvaKm,
            CARCODCAMBIO        = $vxvaCambio,
            CARPORTAS           = $vxvaPortas,
            CARCODCOMBUSTIVEL   = $vxvaCombustivel,
            CARCODCOR           = $vxvaCor,
            CARTROCA            = '$vxvaTroca',
            CARDESTAQUE         = '$vxvaDestaque',
            CARDATCADASTRO      = CURRENT_TIMESTAMP,
            CARUSER             = '$vxvaUser',
            CARCODMUNICIPIO     = $vxvaMunicipio,
            CARUF               = '$vxvaUf'            
            where CARCOD = $vxvaCod";
            $result = $Carro->AtualizaCarro($sqlUpdate);

            if (isset($_FILES["_edImagemCapa"])) {
                if (strlen($_FILES["_edImagemCapa"]["name"]) > 0) {
                    move_uploaded_file($arquivo_tmp, $destino);
                }
            }

            $qtdeCarros = $Carro->SelecionaTotalNumCarros();
            if (count($qtdeCarros)) {
                foreach ($qtdeCarros as $row) {
                    $numCarros = $row->NUMCARROS;
                }
            }


            echo "<script>hideLoad();</script>";
            echo "<script>SuccessBox('Veiculo Atualizado com Sucesso.');</script>";
        }
    }
} catch (Exception $ex) {
    echo "<script>hideLoad();</script>";
    echo "<script>ErrorBox('Ocorreu um erro ao salvar o registro.');</script>";
}
?>
<div class="row bg-primary text-white">
    <div class="col-lg-10">
        <h5>Cadastro de Carros</h5>
    </div>
    <div class="col-lg-2 text-right">
        <?php echo $numCarros; ?> Registro(s)
    </div>
</div>

<div class="row bg-light" style="padding: 5px;">
    <div class="col-lg-12 text-center">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <div id="_lkInfoCad" class="nav-link active" onclick="TrocaTela(1)"><i class="icone-vcard"></i> Informações Principais</div>
            </li>
            <li class="nav-item">
                <div id="_lkInfoComp" class="nav-link" onclick="TrocaTela(2)"><i class="icone-doc-text-1"></i> Detalhes</div>
            </li>
            <li class="nav-item">
                <div id="_lkFotos" class="nav-link" onclick="TrocaTela(3)"><i class="icone-picture"></i> Fotos</div>
            </li>
        </ul>
    </div>
</div>
<div id="painel-CadCarro" class="display-show">

    <form name="_formCadCarro" id="_formCadCarro" method="POST" action="InsereAtualizaCarro.php" enctype=multipart/form-data> <div class="row " tyle="margin-top:5px;">
        <div class="col-lg-12 text-center bg-dark text-white">
            DADOS DO VEÍCULO
        </div>
</div>
<div class="row " style="margin-top:5px;">
    <div class="col-lg-12">
        <div class="container-fluid bg-light" style="padding-top:5px;">
            <div class="row" style="margin-top:5px;">
                <div class="col-lg-12">
                    <button class="btn btn-success" type="submit" name="salvar"><i class="icone-floppy"></i> Salvar</button>
                    <button class="btn btn-danger" type="reset" onclick="LimpaCampos()"><i class="icone-cancel"></i> Limpar</button>
                    <a class="btn btn-dark" href="CrudCarros.php"><i class="icone-reply-1"></i> Voltar</a>
                </div>
            </div>
            <div class="row alert-secondary" style="margin-top:5px;">
                <div class="form-group col-lg-2">
                    <label for="_edCodCarro">Cod</label>
                    <input type="text" value="<?php if ($vxvaCod) {
                                                    echo $vxvaCod;
                                                } ?>" class="form-control" id="_edCodCarro" name="_edCodCarro" readonly>
                </div>
                <div class="form-group col-lg-4">
                    <label for="_edTitulo">Titulo</label>
                    <input type="text" class="form-control" value="<?php if ($vxvaTitulo) {
                                                                        echo $vxvaTitulo;
                                                                    } ?>" id="_edTitulo" name="_edTitulo" required>
                </div>
                <div class="form-group col-lg-2">
                    <label for="_edDtCadastro">Dt. Cadastro</label>
                    <input type="text" onkeyup="Mascara(this,Data);" class="form-control" id="_edDtCadastro" name="_edDtCadastro" value="<?php if ($vxvaDataCad) {
                                                                                                                                                echo date("d/m/Y", strtotime($vxvaDataCad));
                                                                                                                                            } else {
                                                                                                                                                echo $dataAtual;
                                                                                                                                            } ?>" readonly>
                </div>
                <div class="col-lg-2">
                    <label for="_ddlDestaque">Destaque</label>
                    <select class="form-control form-control" id="_ddlDestaque" name="_ddlDestaque">
                        <?php if ($vxvaDestaque) { ?>
                            <option value="N" <?php if ($vxvaDestaque == "N") {
                                                    echo 'selected';
                                                } ?>>Não</option>
                            <option value="S" <?php if ($vxvaDestaque == "S") {
                                                    echo 'selected';
                                                } ?>>Sim</option>
                        <?php } else { ?>
                            <option value="N" selected>Não</option>
                            <option value="S">Sim</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-lg-2">
                    <label for="_ddlTroca">Troca</label>
                    <select class="form-control form-control" id="_ddlTroca" name="_ddlTroca">
                        <?php if ($vxvaTroca) { ?>
                            <option value="N" <?php if ($vxvaTroca == "N") {
                                                    echo 'selected';
                                                } ?>>Não</option>
                            <option value="S" <?php if ($vxvaTroca == "S") {
                                                    echo 'selected';
                                                } ?>>Sim</option>
                        <?php } else { ?>
                            <option value="N" selected>Não</option>
                            <option value="S">Sim</option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-3">
                    <label for="_ddlMarca">Marca</label>
                    <select class="form-control form-control" id="_ddlMarca" name="_ddlMarca" required>
                        <?php if (isset($_GET['acao'])) { ?>
                            <?php if ($_GET['acao'] == "editar") { ?>
                                <option value="">Selecionar</option>
                                <?php if ($listaMarcas) : ?>
                                    <?php foreach ($listaMarcas as $marca) : ?>
                                        <option value="<?php echo $marca->MARCOD; ?>" <?php if ($marca->MARCOD == $vxvaMarca) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $marca->MARDESCRICAO; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php } else { ?>
                                <option value="" selected="true">Selecionar</option>
                                <?php if ($listaMarcas) : ?>
                                    <?php foreach ($listaMarcas as $marca) : ?>
                                        <option value="<?php echo $marca->MARCOD; ?>"><?php echo $marca->MARDESCRICAO; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php } ?>
                        <?php } else { ?>
                            <?php if ($vxvaMarca) { ?>
                                <option value="">Selecionar</option>
                                <?php if ($listaMarcas) : ?>
                                    <?php foreach ($listaMarcas as $marca) : ?>
                                        <option value="<?php echo $marca->MARCOD; ?>" <?php if ($marca->MARCOD == $vxvaMarca) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $marca->MARDESCRICAO; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php } else { ?>
                                <option value="" selected="true">Selecionar</option>
                                <?php if ($listaMarcas) : ?>
                                    <?php foreach ($listaMarcas as $marca) : ?>
                                        <option value="<?php echo $marca->MARCOD; ?>"><?php echo $marca->MARDESCRICAO; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php } ?>
                        <?php } ?>
                    </select>

                </div>
                <div class="form-group col-lg-3">
                    <label for="_ddlModelo">Modelo</label>
                    <select class="form-control form-control" id="_ddlModelo" name="_ddlModelo" required>
                        <option value="" selected="true">Selecionar</option>
                    </select>
                </div>

                <div class="form-group col-lg-2">
                    <label for="_ddlAno">Ano</label>
                    <select class="form-control" id="_ddlAno" name="_ddlAno">
                        <?php if (isset($_GET['acao'])) { ?>
                            <?php if ($_GET['acao'] == "editar") { ?>
                                <?php for ($i = 0; $i <= $contador; $i++) : ?>
                                    <?php $anoitem = $anoAtual - $i; ?>
                                    <option value="<?php echo $anoitem; ?>" <?php if (strval($anoitem) == $vxvaAno) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $anoitem; ?></option>
                                <?php endfor; ?>
                            <?php } else { ?>
                                <?php for ($i = 0; $i <= $contador; $i++) : ?>
                                    <?php $anoitem = $anoAtual - $i; ?>
                                    <option value="<?php echo $anoitem; ?> "><?php echo $anoitem; ?></option>
                                <?php endfor; ?>
                            <?php } ?>
                        <?php } else { ?>
                            <?php if ($vxvaAno) { ?>
                                <?php for ($i = 0; $i <= $contador; $i++) : ?>
                                    <?php $anoitem = $anoAtual - $i; ?>
                                    <option value="<?php echo $anoitem; ?>" <?php if (strval($anoitem) == $vxvaAno) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $anoitem; ?></option>
                                <?php endfor; ?>
                            <?php } else { ?>
                                <?php for ($i = 0; $i <= $contador; $i++) : ?>
                                    <?php $anoitem = $anoAtual - $i; ?>
                                    <option value="<?php echo $anoitem; ?> "><?php echo $anoitem; ?></option>
                                <?php endfor; ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="_edKm">Quilometragem</label>
                    <input required type="text" class="form-control" value="<?php if ($vxvaKm) {
                                                                                echo $vxvaKm;
                                                                            } ?>" id="_edKm" name="_edKm" maxlength="10" placeholder="" onkeydown="Mascara(this,Valor);"><!-- onkeyup="mascara('##########,##',this,event,false)" -->
                </div>
                <div class="form-group col-lg-2">
                    <label for="_ddlStatus">Status</label>
                    <select class="form-control" id="_ddlStatus" name="_ddlStatus" required>
                        <?php if ($vxvaStatus) { ?>
                            <option value="1" <?php if ($vxvaTroca == "1") {
                                                    echo 'selected';
                                                } ?>>Ativo</option>
                            <option value="2" <?php if ($vxvaTroca == "2") {
                                                    echo 'selected';
                                                } ?>>Inativo</option>
                        <?php } else { ?>
                            <option value="1">Ativo</option>
                            <option value="2">Inativo</option>
                        <?php } ?>
                    </select>
                    </select>
                </div>
            </div>
            <div class="row alert-secondary">
                <div class="form-group col-lg-3">
                    <label for="_ddlCamb">Câmbio</label>
                    <select class="form-control" id="_ddlCamb" name="_ddlCamb" required>
                        <?php if ($vxvaCambio) { ?>
                            <option value="">Selecionar</option>
                            <?php if ($listaCambios) : ?>
                                <?php foreach ($listaCambios as $lcambio) : ?>
                                    <option value="<?php echo $lcambio->CAMCOD; ?>" <?php if ($lcambio->CAMCOD == $vxvaCambio) {
                                                                                        echo 'selected';
                                                                                    } ?>><?php echo $util->convert_from_latin1_to_utf8_recursively($lcambio->CAMDESCRICAO); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?> -->
                        <?php } else { ?>
                            <option value="" selected="true">Selecionar</option>
                            <?php if ($listaCambios) : ?>
                                <?php foreach ($listaCambios as $lcambio) : ?>
                                    <option value="<?php echo $lcambio->CAMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($lcambio->CAMDESCRICAO); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?> -->
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="_ddlComb">Combustivel</label>
                    <select class="form-control" id="_ddlComb" name="_ddlComb" required>
                        <?php if ($vxvaCombustivel) { ?>
                            <option value="">Selecionar</option>
                            <?php if ($listaCombustiveis) : ?>
                                <?php foreach ($listaCombustiveis as $lcombustivel) : ?>
                                    <option value="<?php echo $lcombustivel->COMCOD; ?>" <?php if ($lcombustivel->COMCOD == $vxvaCombustivel) {
                                                                                                echo 'selected';
                                                                                            } ?>><?php echo $util->convert_from_latin1_to_utf8_recursively($lcombustivel->COMDESCRICAO); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php } else { ?>
                            <option value="" selected="true">Selecionar</option>
                            <?php if ($listaCombustiveis) : ?>
                                <?php foreach ($listaCombustiveis as $lcombustivel) : ?>
                                    <option value="<?php echo $lcombustivel->COMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($lcombustivel->COMDESCRICAO); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="_edNumPortas">Portas</label>
                    <input type="number" required class="form-control" value="<?php if ($vxvaPortas) {
                                                                                    echo $vxvaPortas;
                                                                                } ?>" id="_edNumPortas" name="_edNumPortas" maxlength="1" onkeyup="Mascara(this,Integer);"><!-- onkeyup="mascara('##########,##',this,event,false)" -->
                </div>
                <div class="form-group col-lg-2">
                    <label for="_ddlCor">Cor</label>
                    <select class="form-control" id="_ddlCor" name="_ddlCor" required>
                        <?php if ($vxvaCor) { ?>
                            <option value="">Selecionar</option>
                            <?php if ($listaCor) : ?>
                                <?php foreach ($listaCor as $lcor) : ?>
                                    <option value="<?php echo $lcor->CORCOD; ?>" <?php if ($lcor->CORCOD == $vxvaCor) {
                                                                                        echo 'selected';
                                                                                    } ?>><?php echo $lcor->CORDESCRICAO; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php } else { ?>
                            <option value="" selected="true">Selecionar</option>
                            <?php if ($listaCor) : ?>
                                <?php foreach ($listaCor as $lcor) : ?>
                                    <option value="<?php echo $lcor->CORCOD; ?>"><?php echo $lcor->CORDESCRICAO; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label for="_edValor">Valor</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="icone-money"></i></div>
                        </div>
                        <input type="text" required class="form-control" value="<?php if ($vxvaValor) {
                                                                                    echo $vxvaValor;
                                                                                } ?>" onkeydown="Mascara(this,Valor);" maxlength="10" id="_edValor" name="_edValor" placeholder="R$ 000.00">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-3">
                    <label for="_ddlUf">Estado</label>
                    <select class="form-control" id="_ddlUf" name="_ddlUf" required>
                        <?php if ($vxvaUf) { ?>
                            <option value="">Selecionar</option>
                            <?php if ($listaUf) : ?>
                                <?php foreach ($listaUf as $uf) : ?>
                                    <option value="<?php echo $uf->MUNUF; ?>" <?php if ($uf->MUNUF == $vxvaUf) {
                                                                                    echo 'selected';
                                                                                } ?>><?php echo $uf->MUNUF; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php } else { ?>
                            <option value="" selected="true">Selecionar</option>
                            <?php if ($listaUf) : ?>
                                <?php foreach ($listaUf as $uf) : ?>
                                    <option value="<?php echo $uf->MUNUF; ?>"><?php echo $uf->MUNUF; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label for="_ddlMun">Cidade</label>
                    <select class="form-control" id="_ddlMun" name="_ddlMun" required>
                        <option value="" selected="true">Selecionar</option>
                    </select>
                </div>



            </div>

            <div class="row alert-secondary">
                <div class="form-group col-lg-4">
                    <br>
                    <img name="_ImgCapaPreview" id="_ImgCapaPreview" src="<?php if ($vxvaImg) {
                                                                                echo '../assets/img/Carros/' . $vxvaImg;
                                                                            } else {
                                                                                echo '../assets/img/sem-foto.gif';
                                                                            } ?>" style="width: 100%;" alt="Capa do Anuncio" class="img-thumbnail">
                    <br />
                    <br />
                    <input hidden type="file" name="_edImagemCapa" id="_edImagemCapa">

                    <a class="btn btn-success btn-block text-white" id="_btnCarregaImg"><i class="icone-image"></i> Carregar Imagem</a>
                </div>
            </div>

            <div class="row" style="margin-top:5px; margin-bottom:10px; padding:5px;">
                <div class="col-lg-12">
                    <button class="btn btn-success" type="submit" name="salvar"><i class="icone-floppy"></i> Salvar</button>
                    <button class="btn btn-danger" type="reset" onclick="LimpaCampos()"><i class="icone-cancel"></i> Limpar</button>
                    <a class="btn btn-dark" href="CrudCarros.php"><i class="icone-reply-1"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</div>

<div id="infoComp" class="display-hide">

    <div class="row " tyle="margin-top:5px;">
        <div class="col-lg-12 text-center bg-dark text-white">
            DETALHES DO VEÍCULO
        </div>
    </div>
    <form action="InsereAtualizaCarro.php" method="post">
        <div class="row" style="margin-top:5px;">
            <div class="col-lg-12">
                <div class="container-fluid bg-light" style="padding-top:5px; padding-bottom:5px;">
                    <div class="row" style="margin-top:5px;">
                        <div class="col-lg-12">
                            <button class="btn btn-success" type="submit" name="salvarInfoComp"><i class="icone-floppy"></i> Salvar</button>
                            <button class="btn btn-danger" type="reset"><i class="icone-cancel"></i> Limpar</button>
                            <a class="btn btn-dark" href="CrudCarros.php"><i class="icone-reply-1"></i> Voltar</a>
                            <input type="checkbox" onclick="marcarTodos(this.checked);" name="det[]" id="_cktodos"><label for="_cktodos">Marcar Todos</label>
                        </div>
                    </div>

                    <div class="row alert-warning" style="margin-top:5px;">
                        <div class="col-lg-12 text-center ">
                            <i class="icone-warning"></i> Marque somente as informações que o veículo possui.<br> Estas informações serão exibidas na pagina de detalhes do veiculos para os visitantes do seu site.
                        </div>
                    </div>
                    <div class="row alert-secondary" style="margin-top:5px;">
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckVidroEletrico" value="DETVIDELETRICA">
                            <label for="_ckVidroEletrico">Vidro Eletrico</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckTravaEletrica" value="DETTRAELETRICA">
                            <label for="_ckTravaEletrica">Trava Eletrica</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckDirHidra" value="DETDIRHIDRAULICA">
                            <label for="_ckDirHidra">Direção Hidráulica</label>
                        </div>
                        <div class="col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckAlarme" value="DETALARME">
                            <label for="_ckAlarme">Alarme</label>
                        </div>
                    </div>
                    <div class="row" style="margin-top:5px;">
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckFarMilha" value="DETFARMILHA">
                            <label for="_ckFarMilha">Farol de Milha</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckFarXenon" value="DETFARXENON">
                            <label for="_ckFarXenon">Farol de Xenon</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckArQuente" value="DETARQUENTE">
                            <label for="_ckArQuente">Ar Quente</label>
                        </div>
                        <div class="col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckArCond" value="DETARCONDICIONADO">
                            <label for="_ckArCond">Ar Condicionado</label>
                        </div>
                    </div>

                    <div class="row alert-secondary" style="margin-top:5px;">
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckBancouro" value="DETBANCOURO">
                            <label for="_ckBancouro">Banco de Couro</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckSomVolante" value="DETSOMVOLANTE">
                            <label for="_ckSomVolante">Som no Volante</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckDesembTraseiro" value="DETDESEMBTRASEIRO">
                            <label for="_ckDesembTraseiro">Desembaçador Traseiro</label>
                        </div>
                        <div class="col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckDirEletrica" value="DETDIRELETRICA">
                            <label for="_ckDirEletrica">Direção Elétrica</label>
                        </div>
                    </div>
                    <div class="row" style="margin-top:5px;">
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckFarNeblina" value="DETFARNEBLINA">
                            <label for="_ckFarNeblina">Farol de Neblina</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckFreioAbs" value="DETFREIOABS">
                            <label for="_ckFreioAbs">Freio ABS</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckGPS" value="DETGPS">
                            <label for="_ckGPS">GPS</label>
                        </div>
                        <div class="col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckMultimidia" value="DETMULTIMIDIA">
                            <label for="_ckMultimidia">Multimidia</label>
                        </div>
                    </div>

                    <div class="row alert-secondary" style="margin-top:5px;">
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckPortaCopos" value="DETPORTACOPOS">
                            <label for="_ckPortaCopos">Porta-Copos</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckRetroEletrico" value="DETRETROELETRICO">
                            <label for="_ckRetroEletrico">Retrovisor Elétrico</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckRodaLiga" value="DETRODLIGA">
                            <label for="_ckRodaLiga">Rodas de Liga Leve</label>
                        </div>
                        <div class="col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckTetoSolar" value="DETTETOSOLAR">
                            <label for="_ckTetoSolar">Teto Solar</label>
                        </div>
                    </div>
                    <div class="row" style="margin-top:5px;">
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckABLat" value="DETAIRBAGLAT">
                            <label for="_ckABLat">Air-Bag Lateral</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckABMot" value="DETAIRBAGMOT">
                            <label for="_ckABMot">Air-Bag do Motorista</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckABPas" value="DETAIRBAGPAS">
                            <label for="_ckABPas">Air-Bag de Passageiro</label>
                        </div>
                        <div class="col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckBancAjust" value="DETBANAJUSTAVEL">
                            <label for="_ckBancAjust">Banco com Altura Ajustavel</label>
                        </div>
                    </div>

                    <div class="row alert-secondary" style="margin-top:5px;">
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckCamRe" value="DETCAMRE">
                            <label for="_ckCamRe">Câmera de Ré</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckCD" value="DETCD">
                            <label for="_ckCD">CD Player</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckDVD" value="DETDVD">
                            <label for="_ckDVD">DVD Player</label>
                        </div>
                        <div class="col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckBlueRay" value="DETBLUERAY">
                            <label for="_ckBlueRay">BlueRay</label>
                        </div>
                    </div>
                    <div class="row" style="margin-top:5px;">
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckCompBordo" value="DETCOMPBORDO">
                            <label for="_ckCompBordo">Computador de Bordo</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckEncTraseiro" value="DETENCTRASEIRO">
                            <label for="_ckEncTraseiro">Encosto de Cabeça Traseiro</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckUSB" value="DETUSB">
                            <label for="_ckUSB">Entrada USB</label>
                        </div>
                        <div class="col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckPilAuto" value="DETPILOTOAUTO">
                            <label for="_ckPilAuto">Piloto Automático</label>
                        </div>
                    </div>
                    <div class="row alert-secondary" style="margin-top:5px;">
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckSensorEst" value="DETSENSOREST">
                            <label for="_ckSensorEst">Sensor de Estacionamento</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckVolAjust" value="DETVOLAJUSTAVEL">
                            <label for="_ckVolAjust">Volante Ajustavel</label>
                        </div>
                        <div class="form-group col-lg-3">
                            <input type="checkbox" name="det[]" id="_ckUnicoDono" value="DETUNICODONO">
                            <label for="_ckUnicoDono">Unico Dono</label>
                        </div>
                    </div>

                    <div class="row" style="margin-top:5px;">
                        <div class="form-group col-lg-12">
                            <label for="_edInfoAd">Informações Adicionais</label>
                            <textarea name="_edInfoAd" id="_edInfoAd" style="width: 100%" rows="10"></textarea>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </form>
</div>

<div id="pnlFotos" class="display-hide">
    <div class="row" tyle="margin-top:5px;">
        <div class="col-lg-12 text-center bg-dark text-white">
            FOTOS DO VEÍCULO
        </div>
    </div>
    <form enctype="multipart/form-data" action="InsereAtualizaCarro.php" method="post">
        <div class="row bg-light" style="margin-top:5px; padding:5px">

            <div class="col-lg-2">
                <button type="submit" name="Fotos" class="btn btn-success btn-block"><i class="icone-upload"></i> Carregar</button>
            </div>
            <div class="col-lg-10">
                <input type="file" name="_edFotosCarro[]" id="_edFotos" multiple="multiple">
                <input type="hidden" value="<?php if ($_SESSION['codCar']) {
                                                    echo $_SESSION['codCar'];
                                                } ?>" class="form-control" name="_edCodCarroFotos" readonly>
            </div>

        </div>
    </form>
    <div class="row"  style="margin-top:5px;">
                <?php
                    if($_SESSION['codCar']){
                        $dir = '../assets/img/Carros/'.$_SESSION['codCar'];
                        if(!is_dir($dir)){
                            mkdir($dir);
                        }

                        $files = scandir($dir,1);
                        $cont = count($files);
                        if(count($files) > 2){
                            foreach($files as $f){
                                if ($f != '.' && $f != '..'){
                                ?>
                                <div class="card col-lg-3" style="padding: 5px;">
                                    <img class="card-img-top" src="<?php echo $dir.'/'.$f; ?>" title="<?php echo strtoupper(utf8_encode($f)); ?>" alt="<?php echo utf8_encode($f); ?>">
                                        <a href="InsereAtualizaCarro.php?acao=delFoto&cod=<?php echo $_SESSION['codCar']; ?>&foto=<?php echo $_SESSION['codCar'].'/'.$f; ?>" class="card-footer bg-danger  text-center text-white" style="cursor: pointer;">
                                            <i class="icone-trash"></i> Remover
                                        </a>
                                </div>
                                <?php
                                }
                            }
                        }
                        else{
                            ?>
                            <div class="col-lg-12">
                                <h4 class="alert alert-danger">Nenhuma Foto Encontrada!</h4>
                            </div>
                            <?php
                        }
                        
                    }
                    
                ?>
        
    </div>
</div>


<script>
    $(document).ready(function() {
        lightGallery(document.getElementById('_galfotos'));

        $("#_edInfoAd").jqte();

        $("#_ddlMarca").change(function() {
            CarregaDdlModelo();
        });

        $("#_ddlUf").change(function() {
            CarregaDdlCidade();
        });

        $("#_ddlMarca").blur(function() {
            CarregaDdlModelo();
        });

        $("#_ddlUf").blur(function() {
            CarregaDdlCidade();
        });

        $("#_btnCarregaImg").click(function() {
            self.executar();
        });

        $("#_edImagemCapa").click(function() {
            const $ = document.querySelector.bind(document);
            const previewImg = $('#_ImgCapaPreview');
            const fileChooser = $('#_edImagemCapa');

            fileChooser.onchange = e => {
                const fileToUpload = e.target.files.item(0);
                const reader = new FileReader();

                // evento disparado quando o reader terminar de ler 
                reader.onload = e => previewImg.src = e.target.result;

                // solicita ao reader que leia o arquivo 
                // transformando-o para DataURL. 
                // Isso disparará o evento reader.onload.
                reader.readAsDataURL(fileToUpload);
            };
        });



    });

    function marcarTodos(marcar) {
        var itens = document.getElementsByName('det[]');
        var i = 0;
        for (i = 0; i < itens.length; i++) {
            itens[i].checked = marcar;
        }

    }

    function TrocaTela(tela) {
        if (tela == 2) {
            if (!VerificaCadastro()) {
                return;
            }
        }

        switch (tela) {
            case 1:
                AlternaPainelCad();
                break;

            case 2:
                AlternaPainelDet();
                break;

            case 3:
                AlternaPainelFotos();
                break;

        }

    }

    function AlternaPainelDet() {
        //s -> Tela a ser mostrada
        //h -> Tela a ser ocultada
        $("#painel-CadCarro").removeClass("display-show");
        $("#painel-CadCarro").addClass("display-hide");
        $('#_lkInfoCad').removeClass('active');

        $("#infoComp").removeClass("display-hide");
        $("#infoComp").addClass("display-show");
        $('#_lkInfoComp').addClass('active');

        $("#pnlFotos").removeClass("display-show");
        $("#pnlFotos").addClass("display-hide");
        $('#_lkFotos').removeClass('active');
    }

    function AlternaPainelFotos() {
        //s -> Tela a ser mostrada
        //h -> Tela a ser ocultada
        $("#painel-CadCarro").removeClass("display-show");
        $("#painel-CadCarro").addClass("display-hide");
        $('#_lkInfoCad').removeClass('active');

        $("#infoComp").removeClass("display-show");
        $("#infoComp").addClass("display-hide");
        $('#_lkInfoComp').removeClass('active');

        $("#pnlFotos").removeClass("display-hide");
        $("#pnlFotos").addClass("display-show");
        $('#_lkFotos').addClass('active');

        $("#_edCodCarroFotos").val($("_edCodCarro").val());
    }

    function AlternaPainelCad() {
        //s -> Tela a ser mostrada
        //h -> Tela a ser ocultada
        $("#infoComp").removeClass("display-show");
        $("#infoComp").addClass("display-hide");
        $('#_lkInfoCad').addClass('active');

        $("#painel-CadCarro").removeClass("display-hide");
        $("#painel-CadCarro").addClass("display-show");
        $('#_lkInfoComp').removeClass('active');

        $("#pnlFotos").removeClass("display-show");
        $("#pnlFotos").addClass("display-hide");
        $('#_lkFotos').removeClass('active');
    }


    function VerificaCadastro() {
        var codCarro = $("#_edCodCarro");
        if (codCarro.val() == '' || codCarro.val() == null) {
            WarningBox('Conclua o cadastro do Carro Antes de acessar os Detalhes do Veiculo.');
            codCarro.focus();
            return false;
        } else {
            return true;
        }
    }

    function executar() {
        $('#_edImagemCapa').trigger('click');
    }

    function LimpaCampos() {
        var img = $('#_ImgCapaPreview');
        img.attr('src', '../assets/img/sem-foto.gif');
    }





    function CarregaDdlModelo() {
        let CodMarca = $("#_ddlMarca option:selected").val(); //$("#_ddlMarca").val();  
        var obj = {
            CODMARCA: CodMarca,
        };

        $.ajax({
            url: "../service/BuscaModelos.php?codMarca=" + CodMarca,
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                var selectbox = $('#_ddlModelo');
                selectbox.find('option').remove();
                data.forEach(function(o, index) {
                    $('<option>').val(o.MODCOD).text(o.MODDESCRICAO).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlModelo option[value=0]').attr('selected', 'selected');

            }
        });
    }

    function CarregaDdlCidade() {
        let uf = $("#_ddlUf option:selected").val(); //$("#_ddlMarca").val();  
        var obj = {
            Uf: uf,
        };

        //var param = JSON.stringify(obj);
        $.ajax({
            url: "../service/BuscaMunicipios.php?Uf=" + uf,
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                var selectbox = $('#_ddlMun');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.MUNCODIGOIBGE).text(o.MUNDESCRICAO).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlMun option[value=0]').attr('selected', 'selected');

            }
        });
    }
</script>
<?php
include_once 'footer.inc.php';
?>