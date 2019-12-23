<?php
header("Content-type:text/html; charset=utf8");

include_once '../Config/ConexaoBD.php';
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





//determina o numero de registros que serão mostrados na tela
$maximo = 10;
//armazenamos o valor da pagina atual
$pagina = isset($_GET['pagina']) ? ($_GET['pagina']) : '1';
//subtraimos 1, porque os registros sempre começam do 0 (zero), como num array
$inicio = $pagina - 1;
//multiplicamos a quantidade de registros da pagina pelo valor da pagina atual 
$inicio = $maximo * $inicio;


$strCount = $Carro->SelecionaTotalNumCarros();
$total = 0;
if (count($strCount)) {
    foreach ($strCount as $row) {
        //armazeno o total de registros da tabela para fazer a paginação
        $total = $row->NUMCARROS;
        $numCarros = $row->NUMCARROS;
    }
}


$resultado = $Carro->SelecionaCarrosPaginados($inicio, $maximo);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KingCar - Painel Administrativo</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontello/css/fontello.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/kingcar.css">
    <link rel="stylesheet" href="../assets/jquery-confirm/jquery-confirm.min.css">
    <link rel="stylesheet" href="../assets/inputmask/inputmask.min.css">
    <script src="../assets/jquery-3.3.1.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/fontawesome/js/all.min.js"></script>
    <script src="../assets/jquery-confirm/jquery-confirm.min.js"></script>
    <script src="../assets/Loader/jquery.loading.min.js"></script>
    <script src="../assets/Mascaras.js"></script>
    <script src="../assets/kingcar.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row bg-primary text-white">
            <div class="col-lg-10">
                <h5>Cadastro de Carros</h5>
            </div>
            <div class="col-lg-2 text-right">
                <?php echo $numCarros; ?> Registro(s)
            </div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-lg-12">
                <button class="btn btn-success" data-toggle="modal" data-target="#CadCarro"><i class="icone-plus"></i> Cadastrar Carro</button>
            </div>
        </div>

        <form action="" method="post">
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12 bg-secondary">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label for="">Pesquisar Por:</label>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <select name="_ddlPesquisa" id="_ddlPesquisa" class="form-control">
                                                <option value="CODCAR" selected>CÓDIGO</option>
                                                <option value="MARDESCRICAO">MARCA</option>
                                                <option value="MODDESCRICAO">MODELO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="text" name="_edPesquisa" id="_edPesquisa" class="form-control" placeholder="Pesquisar Carro">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" class="btn btn-success" name="pesquisa"><i class="icone-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Ordem de Pesquisa:</label>
                                <select name="_ddlPesquisa" id="_ddlOrd" class="form-control">
                                    <option value="ASC" selected>CRESCENTE</option>
                                    <option value="DESC">DECRESCENTE</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>

        <div class="row" style="margin-top: 10px;">
            <div class="col-lg-12">
                <?php if ($resultado) : ?>
                    <table class="table table-stripped">
                        <thead>
                            <th>
                                Cod.
                            </th>
                            <th>
                                Marca
                            </th>
                            <th>
                                Modelo
                            </th>
                            <th>
                                Ano
                            </th>
                            <th>
                                Preço
                            </th>
                            <th>
                                Localização
                            </th>
                            <th>
                                Editar
                            </th>
                            <th>
                                Excluir
                            </th>
                        </thead>
                        <tbody>
                            <? foreach ($linha as $resultado) : ?>
                                <tr>
                                    <td><?php echo $linha->CARCOD; ?></td>
                                </tr>
                            <? endforeach ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <h5 class="alert alert-danger">Nenhum Registro encontrado!</h5>
                <?php endif ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        //determina de quantos em quantos links serão adicionados e removidos
                        $max_links = 10;
                        //dados para os botões
                        $previous = $pagina - 1;
                        $next = $pagina + 1;
                        //usa uma funcção "ceil" para arrendondar o numero pra cima, ex 1,01 será 2
                        $pgs = ceil($total / $maximo);
                        if ($pgs > 1) {
                            //botao anterior
                            if ($previous > 0) {

                        ?>
                                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?pagina=" . $previous; ?>">Anterior</a></li>
                            <?php
                            } else {

                            ?>
                                <li class="page-item" disabled='disabled'><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?pagina=" . $previous; ?>">Anterior</a></li>
                                <?php
                            }

                            for ($i = $pagina - $max_links; $i <= $pgs - 1; $i++) {
                                if ($i <= 0) {
                                    //enquanto for negativo, não faz nada
                                } else {
                                    //senão adiciona os links para outra pagina
                                    if ($i != $pagina) {
                                ?>
                                        <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?pagina=" . ($i); ?>"><?php echo $i; ?></a></li>
                                    <?php

                                    } else {
                                    ?>
                                        <li class="page-item" disabled='disabled'><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?pagina=" . ($i); ?>"><?php echo $i; ?></a></li>
                                <?php
                                    }
                                }
                            }
                            //botao proximo
                            if ($next <= $pgs) {

                                ?>
                                <li class="page-item"><a class="page-link" href="<?php $_SERVER['PHP_SELF'] . "?pagina=" . $next; ?>">Proximo</a></li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item" disabled='disabled'><a class="page-link" href="<?php $_SERVER['PHP_SELF'] . "?pagina=" . $next; ?>">Proximo</a></li>
                        <?php
                            }
                        }

                        ?>
                    </ul>
                </nav>
            </div>
        </div>

    </div>



    <!-- Modal Cad Carro -->
    <div class="modal fade" id="CadCarro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar Novo Carro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="_formCadCarro" id="_formCadCarro" method="POST" action="CrudCarros.php" enctype=multipart/form-data> <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label for="_edCodCarro">Cod</label>
                                <input type="text" class="form-control" id="_edCodCarro" name="_edCodCarro" readonly>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="_edTitulo">Titulo</label>
                                <input type="text" class="form-control" id="_edTitulo" name="_edTitulo">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="_edDtCadastro">Dt. Cadastro</label>
                                <input type="text" onkeyup="Mascara(this,Data);" class="form-control" id="_edDtCadastro" name="_edDtCadastro" value="<?php echo $dataAtual; ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="_ddlMarca">Marca</label>
                                <select class="form-control form-control" id="_ddlMarca" name="_ddlMarca">
                                    <option value="0" selected="true">Selecionar</option>
                                    <?php if ($listaMarcas) : ?>
                                        <?php foreach ($listaMarcas as $marca) : ?>
                                            <option value="<?php echo $marca->MARCOD; ?>"><?php echo $marca->MARDESCRICAO; ?></option>
                                        <?php endforeach; ?>
                                        <!-- <?php else : ?>
                                            <option value="0" selected>Selecionar</option>
                                        <?php endif; ?> -->
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="_ddlModelo">Modelo</label>
                                <select class="form-control form-control" id="_ddlModelo" name="_ddlModelo">
                                    <option value="0" selected="true">Selecionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label for="_ddlAno">Ano</label>
                                <select class="form-control" id="_ddlAno" name="_ddlAno">
                                    <?php for ($i = 0; $i <= $contador; $i++) : ?>
                                        <?php $anoitem = $anoAtual - $i; ?>
                                        <option value="<?php echo $anoitem; ?> "><?php echo $anoitem; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="_edKm">Quilometragem</label>
                                <input type="text" class="form-control" id="_edKm" name="_edKm" maxlength="10" placeholder="" onkeydown="Mascara(this,Valor);"><!-- onkeyup="mascara('##########,##',this,event,false)" -->
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="_ddlCamb">Câmbio</label>
                                <select class="form-control" id="_ddlCamb" name="_ddlCamb">
                                    <option value="0" selected="true">Selecionar</option>
                                    <?php if ($listaCambios) : ?>
                                        <?php foreach ($listaCambios as $lcambio) : ?>
                                            <option value="<?php echo $lcambio->CAMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($lcambio->CAMDESCRICAO); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?> -->
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="_ddlComb">Combustivel</label>
                                <select class="form-control" id="_ddlComb" name="_ddlComb">
                                    <option value="0" selected="true">Selecionar</option>
                                    <?php if ($listaCombustiveis) : ?>
                                        <?php foreach ($listaCombustiveis as $lcombustivel) : ?>
                                            <option value="<?php echo $lcombustivel->COMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($lcombustivel->COMDESCRICAO); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="_edNumPortas">Portas</label>
                                <input type="text" class="form-control" id="_edNumPortas" name="_edNumPortas" maxlength="1" onkeyup="Mascara(this,Integer);"><!-- onkeyup="mascara('##########,##',this,event,false)" -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="_ddlCor">Cor</label>
                                <select class="form-control" id="_ddlCor" name="_ddlCor">
                                    <option value="0" selected="true">Selecionar</option>
                                    <?php if ($listaCor) : ?>
                                        <?php foreach ($listaCor as $lcor) : ?>
                                            <option value="<?php echo $lcor->CORCOD; ?>"><?php echo $lcor->CORDESCRICAO; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="_ddlUf">Estado</label>
                                <select class="form-control" id="_ddlUf" name="_ddlUf">
                                    <option value="0" selected="true">Selecionar</option>
                                    <?php if ($listaUf) : ?>
                                        <?php foreach ($listaUf as $uf) : ?>
                                            <option value="<?php echo $uf->MUNUF; ?>"><?php echo $uf->MUNUF; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-5">
                                <label for="_ddlMun">Cidade</label>
                                <select class="form-control" id="_ddlMun" name="_ddlMun">
                                    <option value="0" selected="true">Selecionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-3">
                                <br>
                                <img id="_ImgCapaPreview" src="../assets/img/sem-foto.gif" style="width: 100%;" alt="Capa do Anuncio" class="img-thumbnail">
                                <br />
                                <br />
                                <input hidden type="file" name="_edImagemCapa" id="_edImagemCapa">

                                <a class="btn btn-success btn-block text-white" id="_btnCarregaImg"><i class="icone-image"></i> Carregar Imagem</a>
                            </div>

                            <div class="col-lg-3">
                                <label for="_edValor">Valor</label>
                                <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icone-money"></i></div>
                                            </div>
                                            <input type="text" class="form-control" onkeydown="Mascara(this,Valor);" id="_edValor" name="_edValor" placeholder="R$ 000,00">
                                        </div>
                            </div>

                            <div class="form-group col-lg-2">
                                <label for="_ddlStatus">Status</label>
                                <select class="form-control" id="_ddlStatus" name="_ddlStatus">
                                    <option value="0" selected="true">Selecionar</option>
                                    <option value="1" >A Venda</option>
                                    <option value="2" >Vendido</option>
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <br>
                                <br>
                                <input type="checkbox" class="" id="_ckDestaque" name="_ckDestaque">
                                <label for="_ckDestaque"> Destaque</label>
                            </div>
                            
                            <div class="col-lg-2">
                                <br>
                                <br>
                                <input type="checkbox" class="" id="_ckTroca" name="_ckTroca">
                                <label for="_ckTroca"> Aceita Troca</label>
                            </div>

                            
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" onclick="LimpaCampos()">Limpar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="ValidarCampos()">Salvar</button>
            </div>
            </form>
        </div>
    </div>
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

            $(".money").inputmask('decimal', {
                'alias': 'numeric',
                'groupSeparator': ',',
                'autoGroup': true,
                'digits': 2,
                'radixPoint': ".",
                'digitsOptional': false,
                'allowMinus': false,
                'prefix': 'R$ ',
                'placeholder': ''
    });

    $(".decimal").inputmask('decimal', {
        'alias': 'numeric',
        'groupSeparator': ',',
        'autoGroup': true,
        'digits': 2,
        'radixPoint': ".",
        'digitsOptional': false,
        'allowMinus': false,
        'prefix': '',
        'placeholder': ''
});







            $("#_formCadCarro").on('submit', function(e) {
                debugger;
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '../Negocio/CadCarro.php',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    // beforeSend: function() {
                    //     $('.submitBtn').attr("disabled", "disabled");
                    //     $('#fupForm').css("opacity", ".5");
                    // },
                    success: function(response) { //console.log(response);
                        console.log(response);
                        // $('.statusMsg').html('');
                        // if (response.status == 1) {
                        //     $('#fupForm')[0].reset();
                        //     $('.statusMsg').html('<p class="alert alert-success">' + response.message + '</p>');
                        // } else {
                        //     $('.statusMsg').html('<p class="alert alert-danger">' + response.message + '</p>');
                        // }
                        // $('#fupForm').css("opacity", "");
                        // $(".submitBtn").removeAttr("disabled");
                    }
                });
            });
        });

        function executar() {
            $('#_edImagemCapa').trigger('click');
        }

        function LimpaCampos() {
            var img = $('#_ImgCapaPreview');
            img.attr('src', '../assets/img/sem-foto.gif');
        }

        function ValidarCampos() {
            showLoadModal('Validando Informações do veículo', '#CadCarro');
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

            $.ajax({
                url: "../service/BuscaModelos.php?codMarca=" + CodMarca,
                type: 'GET',
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    debugger;
                    console.log(data);
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
</body>

</html>