<?php
include_once 'header.inc.php';
//header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Carros.php';

$Carro = new Carros();
$util = new Util();

$numCarros = 0;
$dataAtual = date("d/m/Y");
$anoAtual = date("Y");

$strCount = $Carro->SelecionaTotalNumCarros();

if (count($strCount)) {
    foreach ($strCount as $row) {
        $numCarros = $row->NUMCARROS;
    }
}





?>

<div class="row bg-primary text-white">
    <div class="col-lg-10">
        <h5>Cadastro de Veículos</h5>
    </div>
    <div class="col-lg-2 text-right">
        <?php echo $numCarros; ?> Registro(s)
    </div>
</div>
<div id="pnl_Pesq" class="display-show">
    <div class="row" style="margin-top:5px;">
        <div class="col-lg-12">
            <div class="btn btn-success" onclick="CadastrarUsu()"><i class="icone-plus"></i> Cadastrar Veículo</div>
        </div>
    </div>
    <div class="row bg-light" style="margin-top:5px; padding:5px;">
        <div class="col-lg-12">
            <table id="_gridPesq" class="table table-striped text-center table-responsive-md" style="width: 100%">
                <thead class="bg-success text-white">
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                        <th>Preço</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="Pnl_CadAtu" class="display-hide">
    <form id="_formVeiculo" action="" method="post" enctype="multipart/form-data">
        <div class="row" style="margin-top:5px;">
            <div class="col-lg-12">
                <div class="btn-group">
                    <div class="btn btn-dark" onclick="VoltarTelaPesq()"> <i class="icone-back"></i>Voltar</div>
                    <div class="btn btn-danger" onclick="LimparCampos()"> <i class="icone-cancel"></i> Limpar</div>
                    <div class="btn btn-success" onclick="InsereAtualiza()"><i class="icone-floppy"></i> Salvar</div>
                </div>
            </div>
        </div>
        <div class="accordion">
            <div class="row bg-dark text-white" style="margin-top:5px;">
                <div class="col-lg-12 text-center">
                    <i class="icone-truck"></i> Ficha do Veículo
                </div>
            </div>
            <section id="_pnlDados">
                <div class="row bg-white" style="margin-top:5px;">
                    <div class="form-group col-lg-1">
                        <label for="_edCodVeiculo">Cod</label>
                        <input type="text" value="" class="form-control" id="_edCodVeiculo" name="_edCodVeiculo" readonly>
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="_edPlaca" class="text-danger">Placa</label>
                        <input type="text" value="" class="form-control placaCarro text-uppercase" maxlength="8" id="_edPlaca" name="placa">
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="_ddlTipoVeiculo" class="text-danger">Tipo de Anuncio</label>
                        <select class="form-control" id="_ddlTipoVeiculo" name="tipoVeiculo" required>
                            <option value="N" selected>Novo / Semi-novo</option>
                            <option value="R">Repasse</option>
                            <option value="S">Sinistrado</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="_ddlCarroceria" class="text-danger">Carroceria</label>
                        <select class="form-control" id="_ddlCarroceria" name="carroceria" required>
                            <option value="">Selecionar</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label for="_ddlDestaque" class="text-danger">Destaque</label>
                        <select class="form-control" id="_ddlDestaque" name="destaque" required>
                            <option value="N" selected>Não</option>
                            <option value="S">Sim</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-lg-2">
                        <label for="_ddlStatus" class="text-danger">Status</label>
                        <select id="_ddlStatus" title="status do Anunvio" name="status" required class="form-control ">
                            <option value="A" selected>Ativo</option>
                            <option value="I">Inativo</option>
                        </select>
                    </div>
                </div>
                <div class="row bg-white" style="margin-top:5px;">
                    <div class="form-group col-lg-6">
                        <label for="_edMarca" class="text-danger">Marca</label>
                        <select class="form-control" id="_ddlMarca" name="marca" required>
                            <option value="">Selecionar</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="_edModelo" class="text-danger">Modelo</label>
                        <select class="form-control" id="_ddlModelo" name="modelo" required>
                            <option value="">Selecionar</option>
                        </select>
                    </div>
                </div>

                <div class="row bg-white">
                    <div class="form-group col-sm-12 col-lg-6">
                        <label for="_ddlVersao" class="text-danger">Versão</label>
                        <select class="form-control" title="Versão do Veiculo" id="_ddlVersao" name="versao">
                            <option value="0">Outra Versão</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-lg-6" id="txt-versao" style="display: block">
                        <label for="_edVersao">Informe a Versão:</label>
                        <input type="text" title="Descreva a Versão do Veiculo" class="form-control" id="_edVersao" maxlength="255" name="txtversao">
                    </div>
                </div>

                <div class="row bg-white">
                    <div class="form-group col-sm-12 col-lg-2">
                        <label for="_edAnoFab" class="text-danger">Ano Fab.</label>
                        <input type="text" title="Ano de Fabricação" class="form-control ano" id="_edAnoFab" maxlength="4" name="anoFab">
                    </div>

                    <div class="form-group col-sm-12 col-lg-2">
                        <label for="_edAnoMod" class="text-danger">Ano Mod.</label>
                        <input type="text" title="Ano do Modelo" class="form-control ano" id="_edAnoMod" maxlength="4" name="anoMod">
                    </div>

                    <div class="form-group col-sm-12 col-lg-3">
                        <label for="_ddlUf" class="text-danger">UF</label>
                        <select class="form-control " id="_ddlUf" name="uf" required>
                            <option value="" selected="true">Selecionar</option>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AM">AM</option>
                            <option value="AP">AP</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="MG">MG</option>
                            <option value="MS">MS</option>
                            <option value="MT">MT</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PE">PE</option>
                            <option value="PI">PI</option>
                            <option value="PR">PR</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RO">RO</option>
                            <option value="RR">RR</option>
                            <option value="RS">RS</option>
                            <option value="SC">SC</option>
                            <option value="SE">SE</option>
                            <option value="SP">SP</option>
                            <option value="TO">TO</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-lg-5">
                        <label for="_ddlMunicipio" class="text-danger">Cidade</label>
                        <select class="form-control " id="_ddlMunicipio" name="municipio" required>
                            <option value="">Selecionar</option>
                        </select>
                    </div>
                </div>

                <div class="row bg-white">
                    <div class="form-group col-sm-12 col-lg-2">
                        <label for="_ddlMotor" class="text-danger">Motor</label>
                        <select class="form-control " title="Potência do Motor" id="_ddlMotor" name="motor" required>
                            <option value="" selected>Selecionar</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-lg-2">
                        <label for="_ddlValvula" class="text-danger">Valvulas</label>
                        <select id="_ddlValvula" name="valvula" class="form-control " title="Nº de Valvulas" required>
                            <option value="" selected>Selecione</option>
                            <option value="6">6</option>
                            <option value="8">8</option>
                            <option value="12">12</option>
                            <option value="16">16</option>
                            <option value="20">20</option>
                            <option value="24">24</option>
                            <option value="30">30</option>
                            <option value="32">32</option>
                            <option value="40">40</option>
                            <option value="48">48</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-lg-2">
                        <label for="_ddlPortas" class="text-danger">Portas</label>
                        <select id="_ddlPortas" name="portas" class="form-control " title="Nº de Portas" required>
                            <option value="">Selecione</option>
                            <option value="1">1 Porta</option>
                            <option value="2">2 Portas</option>
                            <option value="3">3 Portas</option>
                            <option value="4">4 Portas</option>
                            <option value="5">5 Portas</option>
                            <option value="6">6 Portas</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-lg-2">
                        <label for="_edKm" class="text-danger">Kilometragem</label>
                        <input type="text" title="Kilometragem" class="form-control kilometragem" id="_edKm" placeholder="52.000" name="km">
                    </div>

                    <div class="form-group col-sm-12 col-lg-2">
                        <label for="_edPreco" class="text-danger">Preço</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">R$</div>
                            </div>
                            <input type="text" title="Preço do Veículo" class="form-control dinheiro" id="_edPreco" placeholder="R$ 35.000,00" name="preco">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-lg-2">
                        <label for="_ddlCor" class="text-danger">Cor</label>
                        <select id="_ddlCor" title="Cor do Veículo" name="cor" required class="form-control ">
                            <option value="">Selecione</option>
                        </select>
                    </div>
                </div>


                <div class="row bg-white">

                    <div class="form-group col-sm-12 col-lg-3">
                        <label for="_ddlCambio" class="text-danger">Câmbio</label>
                        <select id="_ddlCambio" title="Câmbio" name="cambio" required class="form-control ">
                            <option value="">Selecione</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-lg-3">
                        <label for="_ddlCombustivel" class="text-danger">Combustivel</label>
                        <select id="_ddlCombustivel" title="Combustivel" name="combustivel" required class="form-control ">
                            <option value="">Selecione</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-lg-3">
                        <label for="_ddlTroca" class="">Aceita Troca?</label>
                        <select id="_ddlTroca" title="Combustivel" name="troca" required class="form-control ">
                            <option value="N" selected>Não</option>
                            <option value="S">Sim</option>
                        </select>
                    </div>


                </div>

                <div class="row bg-white" style="margin-top:5px;">
                    <div class="form-group col-lg-4">
                        <label for="_btnCarregaImg">Capa p/ Anuncio</label>
                        <br>
                        <img name="_ImgCapaPreview" id="_ImgCapaPreview" src="../assets/img/sem-foto.gif" style="width: 300px; height: 300px;" alt="Capa do Anuncio" class="img-thumbnail">
                        <br />
                        <br />
                        <input hidden type="file" name="_edImagemCapa" id="_edImagemCapa">
                        <input hidden type="text" value="" name="_edImagemCapaAntiga" id="_edImagemCapaAntiga">

                        <a class="btn btn-success text-white" style="width: 300px;" id="_btnCarregaImg"><i class="icone-image"></i> Carregar Imagem</a>
                    </div>

                    <div class="form-group col-sm-12 col-lg-8">
                        <label for="_edKm" class="text-danger">Informções Adicionais</label>
                        <textarea name="infoAd" id="_edinfoAd" style="width: 100%; height: 300px;"></textarea>
                    </div>
                </div>
            </section>

            <div class="row bg-dark text-white" style="margin-top:5px;">
                <div class="col-lg-12 text-center">
                    <i class="icone-user"></i> Dados do Anunciante
                </div>
            </div>

            <section id="_pnlAnunciante">
                <div class="row bg-white">

                    <div class="form-group col-sm-12 col-lg-4">
                        <label for="_edNomeAnunciante" class="text-danger">Nome</label>
                        <input type="text" title="Nome do Anunciante" value="King Car Semi-novos" class="form-control" id="_edNomeAnunciante" name="nomeAnun">
                    </div>

                    <div class="form-group col-sm-12 col-lg-4">
                        <label for="_edEmailAnunciante" class="text-danger">Email</label>
                        <input type="text" title="Email do Anunciante" value="contato@kingcar.com.br" class="form-control" id="_edEmailAnunciante" name="emailAnun">
                    </div>

                    <div class="form-group col-sm-12 col-lg-3">
                        <label for="_edTelAnunciante" class="text-danger">Telefone</label>
                        <input type="tel" title="Telefone do Anunciante" value="31999999999" class="form-control telefone" id="_edTelAnunciante" name="telAnun">
                    </div>


                </div>
            </section>

            <div class="row bg-dark text-white" style="margin-top:5px;">
                <div class="col-lg-12 text-center">
                    <i class="icone-check-3"></i> Itens do Veículo
                </div>
            </div>

            <section id="_pnlComplementos">
                <div class="row alert-warning" style="margin-top:5px;margin-bottom:5px;">
                    <div class="col-lg-12 text-center ">
                        <i class="icone-warning"></i> Marque somente os Itens que o veículo possui.<br> Estas informações serão exibidas na pagina de detalhes do veiculos para os visitantes do seu site.
                    </div>
                </div>
                <div class="row" id="_boxItens">

                </div>
                <hr>
                <div class="row" style="margin-top:5px;margin-bottom:5px;">
                    <div class="col-lg-3 ">
                        <a class="btn btn-success text-white" style="width: 100%;" id="_btnCarregaFotos">
                            <i class="icone-picture-1"></i> Carregar Fotos do Veículo
                        </a>
                        <input hidden type="file" name="_edFotosVeiculo[]" id="_edFotos" multiple="multiple">
                    </div>
                    <div class="col-lg-3">
                        <div class="btn btn-success" id="_btnGravarFotos" style="display: none;">
                            <i class="icone-upload-1"></i> Gravar Fotos
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
</div>





<script>
    $(document).ready(function() {
        atualizaGridPrincipal();

        $('.placaCarro').mask('AAA-0000');
        $('.telefone').mask('(00) 0000#-0000');
        $('.ano').mask('0000');
        $('.dinheiro').mask('#.##0,00', {
            reverse: true
        });
        $('.kilometragem').mask('#.##0,00', {
            reverse: true
        });

        $("#_btnCarregaImg").click(function() {
            self.executar();
        });

        $("#_btnCarregaFotos").click(function() {
            self.CarregarFotos();
        });

        $(".accordion").accordion({
            heightStyle: "content"
        });

        CarregaMarcas();
        CarregarMotor();
        CarregarCores();
        CarregarCambios();
        CarregarCombustiveis();
        CarregarItens();
        //CarregarCategorias();
        CarregarCarrocerias();

        $("#_ddlMarca").change(function() {
            CarregarModelo();
        });

        $("#_ddlModelo").change(function() {
            CarregarVersoes();
        });

        $("#_ddlUf").change(function() {
            CarregarMunicipios();
        });


        $("#_ddlVersao").change(function() {
            var ver = $("#_ddlVersao").val();
            if (ver == '0') {
                $("#txt-versao").css('display', 'block');
            } else {
                $("#txt-versao").css('display', 'none');
            }
        });

        $('#_formVeiculo').submit(function() {

            var codVeiculo = $('#_edCodVeiculo').val();

            // Captura os dados do formulário
            var formulario = document.getElementById('_formVeiculo');

            // Instância o FormData passando como parâmetro o formulário
            var formData = new FormData(formulario);
            formData.append('image', $('#_edImagemCapa').prop('files')[0]);
            if (!codVeiculo) { //INSERT
                showLoad('Aguarde! <br> Cadastrando Veículo.');
                // Envia O FormData através da requisição AJAX
                $.ajax({
                    url: "../Service/InsereVeiculo.php",
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        debugger;
                        console.log(data);
                        var dados = JSON.parse(data);
                        console.log(dados[0]);
                        var transcod = dados[0].TransCod;
                        if (transcod == 0) {
                            hideLoad();
                            ErrorBox(dados[0].msg);
                        } else {
                            hideLoad();
                            $('#_edCodVeiculo').val(dados[0].UltCod)
                            SuccessBox(dados[0].msg);
                        }

                    },
                    error: function(x, e) {
                        if (x.status == 0) {
                            alert('You are offline!!\n Please Check Your Network.');
                        } else if (x.status == 404) {
                            alert('Requested URL not found.');
                        } else if (x.status == 500) {
                            alert('Internel Server Error.');
                        } else if (e == 'parsererror') {
                            alert('Error.\nParsing JSON Request failed.');
                        } else if (e == 'timeout') {
                            alert('Request Time out.');
                        } else {
                            alert('Unknow Error.\n' + x.responseText);
                        }
                    }
                });
            } else {
                showLoad('Aguarde! <br> Atualizando Publicidade.');
                // Envia O FormData através da requisição AJAX
                $.ajax({
                    url: "../Service/AtualizaPublicidade.php",
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        debugger;
                        console.log(data);
                        var dados = JSON.parse(data);
                        console.log(dados[0]);
                        var transcod = dados[0].TransCod;
                        if (transcod == 0) {
                            hideLoad();
                            ErrorBox(dados[0].msg);
                        } else {
                            hideLoad();
                            SuccessBox(dados[0].msg);
                        }

                    },
                    error: function(data) {
                        debugger;
                        console.log(data);
                        var dados = JSON.parse(data);
                        console.log(dados[0]);
                    }
                });
            }
            return false;
        });



    });

    function CarregarFotos() {
        var cod = $('#_edCodVeiculo').val();

        if (!cod) {
            $("#_btnGravarFotos").css('display', 'none');
            WarningBox('Finalize o cadastro do veículo antes de carregar as fotos.');
            return;
        }

        $("#_btnGravarFotos").css('display', 'block');
        // $('#_edFotos').trigger('click');
        $('#_edFotos').click();
    }

    function CarregarMunicipios() {
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
                var selectbox = $('#_ddlMunicipio');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.MUNCODIGOIBGE).text(o.MUNDESCRICAO.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlMunicipio option[value=0]').attr('selected', 'selected');

            }
        });
    }

    function CarregarMunicipios(mun) {
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
                var selectbox = $('#_ddlMunicipio');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.MUNCODIGOIBGE).text(o.MUNDESCRICAO.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlMunicipio option[value='+mun+']').attr('selected', 'selected');

            }
        });
    }


    function CarregarMotor() {
        $.ajax({
            url: "../service/BuscaMotor.php",
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                var selectbox = $('#_ddlMotor');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.MOTCOD).text(o.MOTPOTENCIA.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlMotor option[value=0]').attr('selected', 'selected');

            }
        });
    }



    function CarregarItens() {
        $.ajax({
            url: "../service/BuscaItensVeiculo.php",
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                var selectbox = $('#_boxItens');
                //selectbox.find('option').remove();
                dados.forEach(function(o, index) {

                    let element = '<div class="form-group col-lg-3"><input type="checkbox" name="det[]" id="_ck' + o.COMPNOMCAMPO + '" value="' + o.COMPNOMCAMPO + '"><label for="_ck' + o.COMPNOMCAMPO + '">' + o.COMPDESC.toUpperCase() + '</label></div>';
                    $('#_boxItens').append(element);
                    //element.appendTo(selectbox);
                    //$('<option>').val(o.MOTCOD).text(o.MOTPOTENCIA).appendTo(selectbox);
                });
                // $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                // $('#_ddlMotor option[value=0]').attr('selected', 'selected');

            }
        });
    }

    function CarregarCores() {
        $.ajax({
            url: "../service/BuscaCores.php",
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                var selectbox = $('#_ddlCor');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.id).text(o.cores.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlCor option[value=0]').attr('selected', 'selected');

            }
        });
    }

    function CarregarCategorias() {
        $.ajax({
            url: "../service/BuscaCategoria.php",
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                var selectbox = $('#_ddlCategoria');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.id).text(o.categoria.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlCategoria option[value=0]').attr('selected', 'selected');

            }
        });
    }

    function CarregarCarrocerias() {
        $.ajax({
            url: "../service/BuscaCarroceria.php",
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                var selectbox = $('#_ddlCarroceria');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.id).text(o.carroceria.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlCarroceria option[value=0]').attr('selected', 'selected');

            }
        });
    }

    function CarregarCambios() {
        $.ajax({
            url: "../service/BuscaCambios.php",
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                var selectbox = $('#_ddlCambio');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.id).text(o.cambio.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlCambio option[value=0]').attr('selected', 'selected');

            }
        });
    }

    function CarregarCombustiveis() {
        $.ajax({
            url: "../service/BuscaCombustivel.php",
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                var selectbox = $('#_ddlCombustivel');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.id).text(o.combustivel.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlCombustivel option[value=0]').attr('selected', 'selected');

            }
        });
    }

    function CarregaMarcas() {
        debugger;
        $.ajax({
            url: "../Service/BuscaMarcas.php",
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: {},
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                var selectbox = $('#_ddlMarca');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.id).text(o.marca.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('').text('Selecionar').appendTo(selectbox);
                $('#_ddlMarca option[value=""]').attr('selected', 'selected');
            }
        });
    }


    function CarregarModelo() {
        debugger;
        let CodMarca = $("#_ddlMarca option:selected").val(); //$("#_ddlMarca").val(); 
        $.ajax({
            url: "../service/BuscaModelos.php?codMarca=" + CodMarca,
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                var selectbox = $('#_ddlModelo');
                selectbox.find('option').remove();
                data.forEach(function(o, index) {
                    $('<option>').val(o.MODCOD).text(o.MODDESCRICAO.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlModelo option[value=0]').attr('selected', 'selected');

            }
        });
    }

    function CarregarModelo(mod) {
        debugger;
        let CodMarca = $("#_ddlMarca option:selected").val(); //$("#_ddlMarca").val(); 
        $.ajax({
            url: "../service/BuscaModelos.php?codMarca=" + CodMarca,
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                var selectbox = $('#_ddlModelo');
                selectbox.find('option').remove();
                data.forEach(function(o, index) {
                    $('<option>').val(o.MODCOD).text(o.MODDESCRICAO.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                $('#_ddlModelo option[value='+mod+']').attr('selected', 'selected');

            }
        });
    }

    function CarregarVersoes() {
        debugger;
        let CodMarca = $("#_ddlMarca option:selected").val();
        let CodModelo = $("#_ddlModelo option:selected").val(); //$("#_ddlMarca").val(); 
        console.log(CodMarca);
        console.log(CodModelo);
        $.ajax({
            url: "../service/BuscaVersoes.php?marca=" + CodMarca + "&modelo=" + CodModelo,
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                var selectbox = $('#_ddlVersao');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.id).text(o.versao.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Outra Versão').appendTo(selectbox);
                $('#_ddlVersao option[value=0]').attr('selected', 'selected');

            }
        });
    }


    function CarregarVersoes(mar,mod,ver) {
        debugger;
        let CodMarca = $("#_ddlMarca option:selected").val();
        let CodModelo = $("#_ddlModelo option:selected").val(); //$("#_ddlMarca").val(); 
        console.log(CodMarca);
        console.log(CodModelo);
        $.ajax({
            url: "../service/BuscaVersoes.php?marca=" + mar + "&modelo=" + mod,
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                var selectbox = $('#_ddlVersao');
                selectbox.find('option').remove();
                dados.forEach(function(o, index) {
                    $('<option>').val(o.id).text(o.versao.toUpperCase()).appendTo(selectbox);
                });
                $('<option>').val('0').text('Outra Versão').appendTo(selectbox);
                $('#_ddlVersao option[value='+ver+']').attr('selected', 'selected');

            }
        });
    }

    function executar() {
        $('#_edImagemCapa').trigger('click');
    }


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

    function LimparCampos() {
        $('#_edCodVeiculo').val('');
        $('#_edEmpresa').val('');
        var img = $('#_ImgCapaPreview');
        img.attr('src', '../assets/img/sem-foto.gif');
        $('#_edImagemCapa').val('');
    }


    //Atualiza Grid Principal
    function atualizaGridPrincipal() {
        //debugger;
        if ($.fn.DataTable.isDataTable('#_gridPesq')) {
            var table = $('#_gridPesq').DataTable();
            table.destroy();
            CarregaGridPrincipal();
        } else {
            CarregaGridPrincipal();
        }
    }

    function TrocaTela(h, s) {
        //s -> Tela a ser mostrada
        //h -> Tela a ser ocultada
        $(h).removeClass("display-show");
        $(h).addClass("display-hide");

        $(s).removeClass("display-hide");
        $(s).addClass("display-show");

    }

    function VoltarTelaPesq() {
        showLoad('Aguarde!');
        LimparCampos();
        TrocaTela('#Pnl_CadAtu', '#pnl_Pesq');
        atualizaGridPrincipal();
        hideLoad();
    }

    function InsereAtualiza() {
        //TRANSCOD
        //0 - ERRO DE CODIGO
        //1 - OPERAÇÃO CONCLUIDA COM SUCESSO
        //2 - ativo JÁ CADASTRADO
        //3 - SENHA IGUAL A ANTERIOR
        debugger;


        showLoad('Aguarde!<br>Validando Informações do Veículo.');
        var codVeiculo = $('#_edCodVeiculo').val();
        var placa = $('#_edPlaca').val();
        var tipoVeiculo = $("#_ddlTipoVeiculo :selected").val();
        var carroceria = $("#_ddlCarroceria :selected").val();
        var destaque = $("#_ddlDestaque :selected").val();
        var status = $("#_ddlStatus :selected").val();
        var marca = $("#_ddlMarca :selected").val();
        var modelo = $("#_ddlModelo :selected").val();
        var versaoSel = $("#_ddlVersao :selected").val();
        var versaoEd = $('#_edVersao').val();
        var anoFab = $('#_edAnoFab').val();
        var anoMod = $('#_edAnoMod').val();
        var uf = $("#_ddlUf :selected").val();
        var municipio = $("#_ddlMunicipio :selected").val();
        var motor = $("#_ddlMotor :selected").val();
        var valvula = $("#_ddlValvula :selected").val();
        var portas = $("#_ddlPortas :selected").val();
        var km = $('#_edKm').val();
        var preco = $('#_edPreco').val();
        var cor = $("#_ddlCor :selected").val();
        var cambio = $("#_ddlCambio :selected").val();
        var combustivel = $("#_ddlCombustivel :selected").val();
        var infoAd = $('#_edinfoAd').val();
        var troca = $("#_ddlTroca :selected").val();

        var nomeAnun = $('#_edNomeAnunciante').val();
        var emailAnum = $('#_edEmailAnunciante').val();
        var telAnum = $('#_edTelAnunciante').val();


        /*VALIDAÇÃO DE PLACA*/
        if (!placa) {
            $('#_edPlaca').focus();
            hideLoad();
            WarningBox('O campo placa é obrigatório');
            return;
        } else {
            if (placa.length < 8) {
                $('#_edPlaca').focus();
                hideLoad();
                WarningBox('Favor Informar Uma Placa Valida!');
                return;
            }
        }

        /*VALIDAÇÃO DO TIPO DE ANUNCIO*/
        if (!tipoVeiculo) {
            $('#_ddlTipoVeiculo').focus();
            hideLoad();
            WarningBox('O campo Tipo do Anuncio é obrigatório');
            return;
        }

        /*VALIDAÇÃO DA CARROCERIA*/
        if (!carroceria) {
            $('#_ddlCarroceria').focus();
            hideLoad();
            WarningBox('O campo Carroceria é obrigatório');
            return;
        }


        /*VALIDAÇÃO DA MARCA*/
        if (!marca) {
            $('#_ddlMarca').focus();
            hideLoad();
            WarningBox('O campo Marca é obrigatório');
            return;
        }


        /*VALIDAÇÃO Do Modelo*/
        if (!modelo) {
            $('#_ddlModelo').focus();
            hideLoad();
            WarningBox('O campo Modelo é obrigatório');
            return;
        }

        /*VALIDAÇÃO Da Versão*/
        if (versaoSel === '0') {
            if (!versaoEd) {
                $('#_edVersao').focus();
                hideLoad();
                WarningBox('O campo Versão é obrigatório');
                return;
            }

        }

        /*VALIDAÇÃO Do Ano de Fab.*/
        if (!anoFab) {
            $('#_edAnoFab').focus();
            hideLoad();
            WarningBox('O campo Ano de Fabricação é obrigatório');
            return;
        } else {
            if (anoFab.length < 4) {
                $('#_edAnoFab').focus();
                hideLoad();
                WarningBox('Favor informar um Ano de Fabricação Válido');
                return;
            }
        }

        /*VALIDAÇÃO Do Ano de Mod.*/
        if (!anoMod) {
            $('#_edAnoMod').focus();
            hideLoad();
            WarningBox('O campo Ano do Modelo é obrigatório');
            return;
        } else {
            if (anoMod.length < 4) {
                $('#_edAnoMod').focus();
                hideLoad();
                WarningBox('Favor informar um Ano do Modelo Válido');
                return;
            }
        }


        /*VALIDAÇÃO Do Estado*/
        if (!uf) {
            $('#_ddlUf').focus();
            hideLoad();
            WarningBox('O campo UF é obrigatório');
            return;
        }

        /*VALIDAÇÃO Do Municipio*/
        if (!municipio) {
            $('#_ddlMunicipio').focus();
            hideLoad();
            WarningBox('O campo Municipio é obrigatório');
            return;
        }

        /*VALIDAÇÃO Do Motor*/
        if (!motor) {
            $('#_ddlMotor').focus();
            hideLoad();
            WarningBox('O campo Motor é obrigatório');
            return;
        }

        /*VALIDAÇÃO Do Valvulas*/
        if (!valvula) {
            $('#_ddlValvula').focus();
            hideLoad();
            WarningBox('O campo Valvulas é obrigatório');
            return;
        }

        /*VALIDAÇÃO Do Portas*/
        if (!portas) {
            $('#_ddlPortas').focus();
            hideLoad();
            WarningBox('O campo Portas é obrigatório');
            return;
        }

        /*VALIDAÇÃO Do Kilometragem*/
        if (!km) {
            $('#_edKm').focus();
            hideLoad();
            WarningBox('O campo Kilometragem é obrigatório');
            return;
        }

        /*VALIDAÇÃO Do Preço*/
        if (!preco) {
            $('#_edPreco').focus();
            hideLoad();
            WarningBox('O campo Preço é obrigatório');
            return;
        }

        /*VALIDAÇÃO Do Cor*/
        if (!cor) {
            $('#_ddlCor').focus();
            hideLoad();
            WarningBox('O campo Cor é obrigatório');
            return;
        }

        /*VALIDAÇÃO Do Cambio*/
        if (!cambio) {
            $('#_ddlCambio').focus();
            hideLoad();
            WarningBox('O campo Cambio é obrigatório');
            return;
        }

        /*VALIDAÇÃO Do Combustivel*/
        if (!combustivel) {
            $('#_ddlCombustivel').focus();
            hideLoad();
            WarningBox('O campo Combustivel é obrigatório');
            return;
        }

        /*VALIDAÇÃO Do Anunciante*/
        if (!nomeAnun) {
            $('#_edNomeAnunciante').focus();
            hideLoad();
            WarningBox('O campo Nome do Anunciante é obrigatório');
            return;
        }

        if (!emailAnum) {
            $('#_edEmailAnunciante').focus();
            hideLoad();
            WarningBox('O campo email do Anunciante é obrigatório');
            return;
        }

        if (!telAnum) {
            $('#_edTelAnunciante').focus();
            hideLoad();
            WarningBox('O campo Telefone do Anunciante é obrigatório');
            return;
        }

        /*VALIDAÇÃO DA CAPA DO ANUNCIO*/
        if ($('#_edImagemCapa').prop('files')[0] == undefined) {
            $('#_edImagemCapa').focus();
            hideLoad();
            WarningBox('Informe a capa do anuncio.');
            return;
        }



        if (!codVeiculo) { //INSERT
            $('#_formVeiculo').submit();
        } else { //UPDATE
            $('#_formVeiculo').submit();
        }
    }

    function AtualizaPublicidade(codVeiculo) {
        showLoad('Aguarde!<br>Carregando as informações da Publicidade.');
        TrocaTela('#pnl_Pesq', '#Pnl_CadAtu');
        $('#_edCodPublicidade').val(codVeiculo);
        BuscaDadosVeiculo(codVeiculo);
    }

    function CadastrarUsu() {
        showLoad('Aguarde!');
        TrocaTela('#pnl_Pesq', '#Pnl_CadAtu');
        hideLoad();
    }

    function DeletaPublicidade(codVeiculo) {
        showLoad('Aguarde <br> Excluindo Publicidade Selecionada.');
        $.ajax({
            url: "../Service/DeletaPublicidade.php?cod=" + codVeiculo,
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: {},
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados[0]);
                if (dados[0].TransCod == 0 || dados[0].TransCod == 2) {
                    hideLoad();
                    ErrorBox(dados[0].msg);
                } else {
                    hideLoad();
                    SuccessBox('Publicidade Deletada com Sucesso.');
                    atualizaGridPrincipal();
                }
            }
        });
    }

    function BuscaDadosVeiculo(codVeiculo) {
        $.ajax({
            url: "../Service/BuscaDadosVeiculo.php?cod=" + codVeiculo,
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: {},
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados[0]);
                if (dados[0].TransCod == 0) {
                    hideLoad();
                    ErrorBox(dados[0].msg);
                } else {
                    $('#_edCodVeiculo').val(dados[0].Veiculo.Id);
                    $('#_edPlaca').val(dados[0].Veiculo.Placa);
                    $('#_ddlTipoVeiculo option[value='+dados[0].Veiculo.TipoAnuncio+']').attr('selected', 'selected');
                    $('#_ddlCarroceria option[value='+dados[0].Veiculo.Carroceria+']').attr('selected', 'selected');
                    $('#_ddlDestaque option[value='+dados[0].Veiculo.Destaque+']').attr('selected', 'selected');
                    $('#_ddlStatus option[value='+dados[0].Veiculo.Status+']').attr('selected', 'selected');
                    $('#_ddlMarca option[value='+dados[0].Veiculo.Marca+']').attr('selected', 'selected');
                    CarregarModelo(dados[0].Veiculo.Modelo);
                    CarregarVersoes(dados[0].Veiculo.Marca,dados[0].Veiculo.Modelo,dados[0].Veiculo.Versao);
                    $("#txt-versao").css('display', 'none');
                    $('#_ddlUf option[value='+dados[0].Veiculo.Uf+']').attr('selected', 'selected');
                    CarregarMunicipios(dados[0].Veiculo.Municipio);
                    $('#_edAnoFab').val(dados[0].Veiculo.AnoFab);
                    $('#_edAnoMod').val(dados[0].Veiculo.AnoMod);
                    $('#_ddlMotor option[value='+dados[0].Veiculo.Motor+']').attr('selected', 'selected');
                    $('#_ddlValvula option[value='+dados[0].Veiculo.Valvulas+']').attr('selected', 'selected');
                    $('#_ddlPortas option[value='+dados[0].Veiculo.Portas+']').attr('selected', 'selected');
                    $('#_edKm').val(dados[0].Veiculo.Km);
                    $('#_edPreco').val(dados[0].Veiculo.Preco);
                    $('#_ddlCor option[value='+dados[0].Veiculo.Cor+']').attr('selected', 'selected');
                    $('#_ddlCambio option[value='+dados[0].Veiculo.Cambio+']').attr('selected', 'selected');
                    $('#_ddlCombustivel option[value='+dados[0].Veiculo.Combustivel+']').attr('selected', 'selected');
                    $('#_ddlTroca option[value='+dados[0].Veiculo.Troca+']').attr('selected', 'selected');
                    MarcarItens();
                    $("#_ImgCapaPreview").attr('src', '../assets/img/Carros/' + dados[0].Veiculo.ImgCapa);
                    $('#_edImagemCapaAntiga').val(dados[0].Veiculo.ImgCapa);
                    hideLoad();
                }
            }
        });
    }

    //Carregando Grid Pincipal
    function CarregaGridPrincipal() {
        showLoad('Carregando Informações!');

        $.ajax({
            url: "../Service/BuscaVeiculos.php",
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: {},
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                hideLoad();
                $('#_gridPesq').DataTable({
                    "language": {
                        "sEmptyTable": "Nenhum registro encontrado",
                        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sInfoThousands": ".",
                        "sLengthMenu": "_MENU_ resultados por página",
                        "sLoadingRecords": "Carregando...",
                        "sProcessing": "Processando...",
                        "sZeroRecords": "Nenhum registro encontrado",
                        "sSearch": "Pesquisar",
                        "oPaginate": {
                            "sNext": "Próximo",
                            "sPrevious": "Anterior",
                            "sFirst": "Primeiro",
                            "sLast": "Último"
                        },
                        "oAria": {
                            "sSortAscending": ": Ordenar colunas de forma ascendente",
                            "sSortDescending": ": Ordenar colunas de forma descendente"
                        },
                        "select": {
                            "rows": {
                                "_": "Selecionado %d linhas",
                                "0": "Nenhuma linha selecionada",
                                "1": "Selecionado 1 linha"
                            }
                        }
                    },
                    "data": dados,
                    "columns": [{
                            "data": "imagem",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<img style="width:75px; height:75px;" src="../assets/img/Carros/' + data + '" />';
                                }

                                return data;
                            }
                        }, {
                            "data": "id",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "marca",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "modelo",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "ano",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "preco",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = parseFloat(data);
                                    data = data.toLocaleString("pt-BR", {
                                        style: "currency",
                                        currency: "BRL"
                                    });
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "editar",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<div style="cursor:pointer;" onClick="AtualizaPublicidade(' + data + ')" class="btn btn-success"><i class="icone-pencil"></i></div>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "excluir",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<div style="cursor:pointer;" onClick="DeletaPublicidade(' + data + ')" class="btn btn-danger"><i class="icone-trash"></i></div>';
                                }

                                return data;
                            }
                        }
                    ]
                });
            }
        });

    }
</script>