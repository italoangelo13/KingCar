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

if(isset($_GET['acao'])){
    if($_GET['acao'] == "editar"){
        echo "<script>showLoad('Aguarde <br> Carregando as informações do Veículo.');</script> ";
        $vxvaCod = $_GET['cod'];
        $InfoCarro = $Carro->SelecionaCarroPorCod($vxvaCod);

        foreach($InfoCarro as $linhaInfoCarro){
            $vxvaTitulo         = $linhaInfoCarro->CARNOME;
            $vxvaMarca          = $linhaInfoCarro->CARCODMARCA;
            $vxvaModelo         = $linhaInfoCarro->CARCODMODELO;
            $vxvaValor          = $linhaInfoCarro->CARPRECO;
            $vxvaAno            = $linhaInfoCarro->CARANO;
            $vxvaImg            = $linhaInfoCarro->CARFOTO;
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
        
    }
}
else{
    echo "<script>localStorage.setItem('ModCod', '');</script>";
    echo "<script>localStorage.setItem('Mun', '');</script>";
}


function DisparaEventoJs($evento){
    echo $evento;
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
        $vxvaImg            = $_FILES["_edImagemCapa"];
        $dir                = $path_parts = pathinfo($_FILES['_edImagemCapa']['name']);
        $dirNovo            = "../assets/img/Carros/"; //diretorio de destino
        $ext                = $path_parts['extension'];
        $nomeNovo            = trim(date('YmdGis') . '-' . $vxvaMarca . $vxvaModelo . $vxvaAno . $vxvaUf . $vxvaMunicipio . '.' . $ext);
        $destino            = $dirNovo . $nomeNovo;
        $arquivo_tmp        = $_FILES['_edImagemCapa']['tmp_name'];

        if(strlen($vxvaCod) == 0 ){
            $sqlInsert = "INSERT INTO KGCTBLCAR (CARNOME,CARCODMARCA,CARCODMODELO,CARPRECO,CARANO,CARFOTO,CARCODSTATUS,CARKM,CARCODCAMBIO,CARPORTAS,CARCODCOMBUSTIVEL,CARCODCOR,CARTROCA,CARDESTAQUE,CARDATCADASTRO,CARUSER,CARCODMUNICIPIO,CARUF)
                VALUES ('".$vxvaTitulo."',
                $vxvaMarca,
                $vxvaModelo,
                $vxvaValor,
                '".trim($vxvaAno)."',
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
                '$vxvaUf')";
            $result = $Carro->InsereCarro($sqlInsert);


            move_uploaded_file( $arquivo_tmp, $destino);

            $UltCod = $Carro->BuscaUltimoCodCarroUser($vxvaUser);
            if (count($UltCod)) {
                foreach ($UltCod as $row) {
                    //armazeno o total de registros da tabela para fazer a paginação
                    $vxvaCod = $row->CARCOD;
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
        }
        else{

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
                    <a class="nav-link active" href="#">Informações Principais</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="VerificaCadastro()" href="#">Detalhes</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="painel-CadCarro">
        <form name="_formCadCarro" id="_formCadCarro" method="POST" action="InsereAtualizaCarro.php" enctype=multipart/form-data> 
            <div class="row " style="margin-top:5px;" >
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
                                <input type="text" value="<?php if($vxvaCod){echo $vxvaCod;} ?>" class="form-control" id="_edCodCarro" name="_edCodCarro" readonly>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="_edTitulo">Titulo</label>
                                <input type="text" class="form-control" value="<?php if($vxvaTitulo){echo $vxvaTitulo;} ?>" id="_edTitulo" name="_edTitulo" required>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="_edDtCadastro">Dt. Cadastro</label>
                                <input type="text" onkeyup="Mascara(this,Data);" class="form-control" id="_edDtCadastro" name="_edDtCadastro"  value="<?php if($vxvaDataCad){echo date("d/m/Y", strtotime($vxvaDataCad));}else{echo $dataAtual;} ?>" readonly>
                            </div>
                            <div class="col-lg-2">
                                <label for="_ddlDestaque">Destaque</label>
                                <select class="form-control form-control" id="_ddlDestaque" name="_ddlDestaque">
                                    <?php if($vxvaDestaque){ ?>
                                        <option value="N" <?php if($vxvaDestaque == "N"){echo 'selected';} ?>>Não</option>
                                        <option value="S" <?php if($vxvaDestaque == "S"){echo 'selected';} ?>>Sim</option>
                                    <?php } else {?>
                                        <option value="N" selected>Não</option>
                                        <option value="S" >Sim</option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <label for="_ddlTroca">Troca</label>
                                <select class="form-control form-control" id="_ddlTroca" name="_ddlTroca">
                                <?php if($vxvaTroca){ ?>
                                        <option value="N" <?php if($vxvaTroca == "N"){echo 'selected';} ?>>Não</option>
                                        <option value="S" <?php if($vxvaTroca == "S"){echo 'selected';} ?>>Sim</option>
                                    <?php } else { ?>
                                        <option value="N" selected>Não</option>
                                        <option value="S" >Sim</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="_ddlMarca">Marca</label>
                                <select class="form-control form-control" id="_ddlMarca" name="_ddlMarca" required>
                                    <?php if(isset($_GET['acao'])){ ?>
                                        <?php if($_GET['acao'] == "editar") { ?>
                                            <option value="">Selecionar</option>
                                            <?php if ($listaMarcas) : ?>
                                                <?php foreach ($listaMarcas as $marca) : ?>
                                                    <option value="<?php echo $marca->MARCOD; ?>" <?php if($marca->MARCOD == $vxvaMarca){echo 'selected';} ?>><?php echo $marca->MARDESCRICAO; ?></option>
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
                                        <option value="" selected="true">Selecionar</option>
                                            <?php if ($listaMarcas) : ?>
                                                <?php foreach ($listaMarcas as $marca) : ?>
                                                    <option value="<?php echo $marca->MARCOD; ?>"><?php echo $marca->MARDESCRICAO; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                    <?php } ?>
                                </select>
                                
                            </div>
                            <div class="form-group col-lg-3">
                                <?php DisparaEventoJs("<script>$('#_ddlMarca').change();</script>"); ?>
                                <label for="_ddlModelo">Modelo</label>
                                <select class="form-control form-control" id="_ddlModelo" name="_ddlModelo" required>
                                    <option value="" selected="true">Selecionar</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-2">
                                <label for="_ddlAno">Ano</label>
                                <select class="form-control" id="_ddlAno" name="_ddlAno">
                                    <?php for ($i = 0; $i <= $contador; $i++) : ?>
                                        <?php $anoitem = $anoAtual - $i; ?>
                                        <option value="<?php echo $anoitem; ?> "><?php echo $anoitem; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="_edKm">Quilometragem</label>
                                <input required type="text" class="form-control" id="_edKm" name="_edKm" maxlength="10" placeholder="" onkeydown="Mascara(this,Valor);"><!-- onkeyup="mascara('##########,##',this,event,false)" -->
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="_ddlStatus">Status</label>
                                <select class="form-control" id="_ddlStatus" name="_ddlStatus" required>
                                    <option value="" selected="true">Selecionar</option>
                                    <option value="1">A Venda</option>
                                    <option value="2">Vendido</option>
                                </select>
                            </div>
                        </div>
                        <div class="row alert-secondary">
                            <div class="form-group col-lg-3">
                                <label for="_ddlCamb">Câmbio</label>
                                <select class="form-control" id="_ddlCamb" name="_ddlCamb" required>
                                    <option value="" selected="true">Selecionar</option>
                                    <?php if ($listaCambios) : ?>
                                        <?php foreach ($listaCambios as $lcambio) : ?>
                                            <option value="<?php echo $lcambio->CAMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($lcambio->CAMDESCRICAO); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?> -->
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="_ddlComb">Combustivel</label>
                                <select class="form-control" id="_ddlComb" name="_ddlComb" required>
                                    <option value="" selected="true">Selecionar</option>
                                    <?php if ($listaCombustiveis) : ?>
                                        <?php foreach ($listaCombustiveis as $lcombustivel) : ?>
                                            <option value="<?php echo $lcombustivel->COMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($lcombustivel->COMDESCRICAO); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="_edNumPortas">Portas</label>
                                <input type="number" required class="form-control" id="_edNumPortas" name="_edNumPortas" maxlength="1" onkeyup="Mascara(this,Integer);"><!-- onkeyup="mascara('##########,##',this,event,false)" -->
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="_ddlCor">Cor</label>
                                <select class="form-control" id="_ddlCor" name="_ddlCor" required>
                                    <option value="" selected="true">Selecionar</option>
                                    <?php if ($listaCor) : ?>
                                        <?php foreach ($listaCor as $lcor) : ?>
                                            <option value="<?php echo $lcor->CORCOD; ?>"><?php echo $lcor->CORDESCRICAO; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="_edValor">Valor</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="icone-money"></i></div>
                                    </div>
                                    <input type="text" required class="form-control" onkeydown="Mascara(this,Valor);" maxlength="10" id="_edValor" name="_edValor" placeholder="R$ 000.00">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="_ddlUf">Estado</label>
                                <select class="form-control" id="_ddlUf" name="_ddlUf" required>
                                    <option value="" selected="true">Selecionar</option>
                                    <?php if ($listaUf) : ?>
                                        <?php foreach ($listaUf as $uf) : ?>
                                            <option value="<?php echo $uf->MUNUF; ?>"><?php echo $uf->MUNUF; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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
                                <img id="_ImgCapaPreview" src="../assets/img/sem-foto.gif" style="width: 100%;" alt="Capa do Anuncio" class="img-thumbnail">
                                <br />
                                <br />
                                <input hidden required type="file" name="_edImagemCapa" id="_edImagemCapa">

                                <a class="btn btn-success btn-block text-white" id="_btnCarregaImg"><i class="icone-image"></i> Carregar Imagem</a>
                            </div>
                        </div>

                        <div class="row" style="margin-top:5px;">
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


<script>
    $(document).ready(function() {
        $("#_ddlMarca").change(function() {
            CarregaDdlModelo();
        });

        $("#_ddlUf").change(function() {
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

    function VerificaCadastro(){
        var codCarro = $("#_edCodCarro");
        if(codCarro.val() == '' || codCarro.val() == NULL){
            WarningBox('Conclua o cadastro do Carro Antes de acessar os Detalhes do Veiculo.');
            codCarro.focus();
            return;
        }
    }

    function executar() {
        $('#_edImagemCapa').trigger('click');
    }

    function LimpaCampos() {
        var img = $('#_ImgCapaPreview');
        img.attr('src', '../assets/img/sem-foto.gif');
    }

    function ValidarCampos() {
        showLoad('Validando Informações do veículo');
        var titulo = $('#_edTitulo');
        var marca = $('#_ddlMarca');
        var modelo = $('#_ddlModelo');
        var ano = $('#_ddlAno');
        var km = $('#_edKm');
        var cambio = $('#_ddlCamb');
        var combustivel = $('#_ddlComb');
        var portas = $('#_edNumPortas');
        var cor = $('#_ddlCor');
        var uf = $('#_ddlUf');
        var municipio = $('#_ddlMun');
        var img = $('#_edImagemCapa');
        var valor = $('#_edValor');


        if (titulo.val() === "" || titulo.val() === null) {
            hideLoadModal("#CadCarro");
            WarningBox('Campo Titulo é Obrigatório.');
            titulo.focus();
            return;
        }

        if (marca.val() === "" || marca.val() === null || marca.val() === "0") {
            hideLoadModal("#CadCarro");
            WarningBox('Campo marca é Obrigatório.');
            marca.focus();
            return;
        }

        if (modelo.val() === "" || modelo.val() === null || modelo.val() === "0") {
            hideLoadModal("#CadCarro");
            WarningBox('Campo modelo é Obrigatório.');
            modelo.focus();
            return;
        }

        if (ano.val() === "" || ano.val() === null || ano.val() === "0") {
            hideLoadModal("#CadCarro");
            WarningBox('Campo ano é Obrigatório.');
            ano.focus();
            return;
        }

        if (km.val() === "" || km.val() === null) {
            hideLoadModal("#CadCarro");
            WarningBox('Campo Quilometragem é Obrigatório.');
            km.focus();
            return;
        }

        if (cambio.val() === "" || cambio.val() === null || cambio.val() === "0") {
            hideLoadModal("#CadCarro");
            WarningBox('Campo cambio é Obrigatório.');
            cambio.focus();
            return;
        }

        if (combustivel.val() === "" || combustivel.val() === null || combustivel.val() === "0") {
            hideLoadModal("#CadCarro");
            WarningBox('Campo combustivel é Obrigatório.');
            combustivel.focus();
            return;
        }

        if (portas.val() === "" || portas.val() === null) {
            hideLoadModal("#CadCarro");
            WarningBox('Campo portas é Obrigatório.');
            portas.focus();
            return;
        }

        if (cor.val() === "" || cor.val() === null || cor.val() === "0") {
            hideLoadModal("#CadCarro");
            WarningBox('Campo cor é Obrigatório.');
            cor.focus();
            return;
        }

        if (uf.val() === "" || uf.val() === null || uf.val() === "0") {
            hideLoadModal("#CadCarro");
            WarningBox('Campo Estado é Obrigatório.');
            uf.focus();
            return;
        }

        if (municipio.val() === "" || municipio.val() === null || municipio.val() === "0") {
            hideLoadModal("#CadCarro");
            WarningBox('Campo Cidade é Obrigatório.');
            municipio.focus();
            return;
        }

        if (img.val() === "" || municipio.val() === null) {
            hideLoadModal("#CadCarro");
            WarningBox('Capa do Anuncio é Obrigatório.');
            img.focus();
            return;
        }

        if (valor.val() === "" || valor.val() === null || valor.val() === "0" || valor.val() === "0,00" || valor.val() === "0,0") {
            hideLoadModal("#CadCarro");
            WarningBox('Campo valor é Obrigatório.');
            valor.focus();
            return;
        }


        showLoadModal('Aguarde, <br> Salvando informações do Veiculo.', '#CadCarro');

        $('form#_formCadCarro').submit();


    }

    

    function CarregaDdlModelo() {
        let CodMarca = $("#_ddlMarca option:selected").val(); //$("#_ddlMarca").val();  
        var obj = {
            CODMARCA: CodMarca,
        };

        //var param = JSON.stringify(obj);
        console.log(location.pathname + ' ../service/BuscaModelos.php?codMarca=' + CodMarca);
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

                debugger;
                if(localStorage.getItem('ModCod') == null || localStorage.getItem('ModCod') == ''){
                    $('#_ddlModelo option[value=0]').attr('selected', 'selected');
                }
                else{
                    var modcod = localStorage.getItem('ModCod');
                    $('#_ddlModelo option[value='+modcod+']').attr('selected', 'selected');
                }

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