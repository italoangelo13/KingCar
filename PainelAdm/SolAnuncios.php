<?php
include_once 'header.inc.php';
//header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Anuncios.php';

$Anuncio = new Anuncios();
$util = new Util();

$numAnuncios = 0;
$dataAtual = date("d/m/Y");
$anoAtual = date("Y");

$strCount = $Anuncio->SelecionarTotalAnuncio();

if (count($strCount)) {
    foreach ($strCount as $row) {
        $numAnuncios = $row->NUMANUNCIO;
    }
}





?>

<div class="row bg-primary text-white">
    <div class="col-lg-10">
        <h5>Solicitações de Anuncio de Veículos</h5>
    </div>
    <div class="col-lg-2 text-right">
        <?php echo $numAnuncios; ?> Registro(s)
    </div>
</div>
<div id="pnl_Pesq" class="display-show">
    <div class="row bg-light" style="margin-top:5px; padding:5px;">
        <div class="col-lg-12">
            <table id="_gridPesq" class="table table-striped text-center ">
                <thead class="bg-success text-white">
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Anunciante</th>
                        <th>Email</th>
                        <th>Veiculo</th>
                        <th>Dt. Cadastro</th>
                        <th>Ir para Solicitação</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="Pnl_CadAtu" class="display-hide">
    <form id="_formPub" action="" method="post" enctype="multipart/form-data">
        <div class="row" style="margin-top:5px;">
            <div class="col-lg-12">
                <div class="btn-group">
                    <div class="btn btn-dark" onclick="VoltarTelaPesq()"> <i class="icone-back"></i>Voltar</div>
                </div>
            </div>
        </div>
        <div class="row bg-dark text-white" style="margin-top:5px;">
            <div class="col-lg-12 text-center">
                Dados do Anunciante
            </div>
        </div>
        <div class="row bg-white" style="margin-top:5px;">
            <div class="form-group col-lg-1">
                <label for="_edCodAnuncio">Cod</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edCodAnuncio">0</label>
                
            </div>
            <div class="form-group col-lg-4">
                <label for="_edAnunciante" class="text-danger">Anunciante</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edAnunciante"></label>
            </div>
            <div class="form-group col-lg-4">
                <label for="_edEmail" class="text-danger">Email</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edEmail"></label>
            </div>
            <div class="form-group col-lg-2">
                <label for="_edDtCadastro">Data Cadastro</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edDtCadastro"></label>
            </div>
        </div>
        <div class="row bg-dark text-white" style="margin-top:5px;">
            <div class="col-lg-12 text-center">
                Dados do Veiculo
            </div>
        </div>
        <div class="row bg-warning text-white" style="margin-top:5px; padding:10px;">
            <div class="col-lg-2" class="text-dark">
                <img id="_edImagemCapa" src="../assets/img/sem-foto.gif" style="width: 100%;" alt="">
            </div>
            <div class="col-lg-10 text-right" style="padding-top: 50px;">
                <label class="text-dark" style="font-weight: 700; font-size:25px;" id="_edVeiculo"></label>
            </div>
        </div>
        <div class="row bg-white" style="margin-top:5px;">
            <div class="form-group col-lg-3">
                <label for="_edMarca">Marca</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edMarca"></label>
            </div>
            <div class="form-group col-lg-3">
                <label for="_edModelo">Modelo</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edModelo"></label>
            </div>
            <div class="form-group col-lg-1">
                <label for="_edAno" >Ano</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edAno"></label>
            </div>
            <div class="form-group col-lg-2">
                <label for="_edCor">Cor</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edCor"></label>
            </div>
            <div class="form-group col-lg-3">
                <label for="_edCombustivel">Combustivel</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edCombustivel"></label>
            </div>
        </div>

        <div class="row bg-white" style="margin-top:5px;">
            <div class="form-group col-lg-3">
                <label for="_edCambio">Câmbio</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edCambio"></label>
            </div>
            <div class="form-group col-lg-3">
                <label for="_edKm" >Quilometragem</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edKm"></label>
            </div>
            <div class="form-group col-lg-3">
                <label for="_edPreco" >Preço</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edPreco"></label>
            </div>
            <div class="form-group col-lg-3">
                <label for="_edTroca">Aceita Troca?</label>
                <br>
                <label class="text-dark" style="font-weight: 700" id="_edTroca"></label>
            </div>
        </div>

    </form>
</div>





<script>
    $(document).ready(function() {
        atualizaGridPrincipal();

        $("#_btnCarregaImg").click(function() {
            self.executar();
        });

        $('#_formPub').submit(function() {
            
            var codAnuncio = $('#_edCodAnuncio').val();

            // Captura os dados do formulário
            var formulario = document.getElementById('_formPub');

            // Instância o FormData passando como parâmetro o formulário
            var formData = new FormData(formulario);
            formData.append('image', $('#_edImagemCapa').prop('files')[0]);
            if (!codAnuncio) { //INSERT
                showLoad('Aguarde! <br> Cadastrando Anuncio.');
                // Envia O FormData através da requisição AJAX
                $.ajax({
                    url: "../Service/InsereAnuncio.php",
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
                            $('#_edCodAnuncio').val(dados[0].UltCod)
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
            } else {
                showLoad('Aguarde! <br> Atualizando Anuncio.');
                // Envia O FormData através da requisição AJAX
                $.ajax({
                    url: "../Service/AtualizaAnuncio.php",
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
        $('#_edCodAnuncio').val('');
        $('#_edAnunciante').val('');
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


        showLoad('Aguarde!<br>Validando Informações do Anuncio.');

        var codAnuncio = $('#_edCodAnuncio').val();
        var empresa = $('#_edAnunciante').val();
        var titulo = $('#_edEmail').val();
        var link = $('#_edDtCadastro').val();
        //var img =  $('#_edImagemCapa').prop('files')[0];
        //console.log(img);

        if (!empresa) {
            $('#_edAnunciante').focus();
            hideLoad();
            WarningBox('O campo empresa é obrigatório');
            return;
        }

        if (!titulo) {
            $('#_edAnunciante').focus();
            hideLoad();
            WarningBox('O campo titulo é obrigatório');
            return;
        }

        if (!link) {
            $('#_edAnunciante').focus();
            hideLoad();
            WarningBox('O campo link é obrigatório');
            return;
        }


        if (!codAnuncio) { //INSERT
            $('#_formPub').submit();
        } else { //UPDATE
            $('#_formPub').submit();
            // $.ajax({
            //     url: "../Service/AtualizaAnuncio.php",
            //     type: 'GET',
            //     contentType: "application/json; charset=utf-8",
            //     dataType: "json",
            //     data: {},
            //     success: function(data) {
            //         debugger;
            //         console.log(data);
            //         var dados = JSON.parse(data);
            //         console.log(dados[0]);
            //         switch(dados[0].TransCod){
            //             case 0:
            //                 hideLoad();
            //                 ErrorBox('Não Foi Possivel Cadastrar este Anuncio.'); 
            //             break;
            //             case 1:
            //                 $('#_edCodAnuncio').val(dados[0].UltCod);
            //                 hideLoad();
            //                 SuccessBox('Anuncio cadastrado com Sucesso.'); 
            //             break;
            //             case 2:
            //                 hideLoad();
            //                 SuccessBox('Anuncio Atualizado com Sucesso.'); 
            //             break;
            //         }
            //     }
            // });
        }
    }

    function AtualizaAnuncio(codAnuncio) {
        showLoad('Aguarde!<br>Carregando as informações da Anuncio.');
        TrocaTela('#pnl_Pesq', '#Pnl_CadAtu');
        $('#_edCodAnuncio').text(codAnuncio);
        BuscaDadosAnuncio(codAnuncio);
    }

    function CadastrarUsu() {
        showLoad('Aguarde!');
        TrocaTela('#pnl_Pesq', '#Pnl_CadAtu');
        hideLoad();
    }

    function DeletaAnuncio(codAnuncio) {
        showLoad('Aguarde <br> Excluindo Anuncio Selecionada.');
        $.ajax({
            url: "../Service/DeletaAnuncio.php?cod=" + codAnuncio,
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
                    SuccessBox('Anuncio Deletada com Sucesso.');
                    atualizaGridPrincipal();
                }
            }
        });
    }

    function BuscaDadosAnuncio(codAnuncio) {
        $.ajax({
            url: "../Service/BuscaDadosAnuncio.php?cod=" + codAnuncio,
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
                    $('#_edAnunciante').text(dados[0].anunciante);
                    $('#_edEmail').text(dados[0].email);
                    $('#_edDtCadastro').text(dados[0].dtCadastro);
                    $("#_edImagemCapa").attr('src','../assets/img/Anuncios/'+dados[0].imagem);
                    $('#_edVeiculo').text(dados[0].veiculo);
                    $('#_edMarca').text(dados[0].marca);
                    $('#_edModelo').text(dados[0].modelo);
                    $('#_edAno').text(dados[0].ano);
                    $('#_edCor').text(dados[0].cor);
                    $('#_edCambio').text(dados[0].cambio);
                    $('#_edCombustivel').text(dados[0].combustivel);
                    var km = dados[0].km;
                    km = km.replace('.',',');
                    $('#_edKm').text(km);
                    var preco = dados[0].preco;
                    console.log(preco);
                    if (preco.indexOf('.') > -1)
                    {
                        
                    }
                    else{
                        preco = preco + '.00';
                    }
                    preco = preco.replace('.',',');
                    $('#_edPreco').text('R$ '+ preco);
                    if(dados[0].troca == 'S'){
                        $('#_edTroca').text('SIM');
                    }
                    else{
                        $('#_edTroca').text('NÃO');
                    }
                    
                    hideLoad();
                }
            }
        });
    }

    //Carregando Grid Pincipal
    function CarregaGridPrincipal() {
        showLoad('Carregando Informações!');

        $.ajax({
            url: "../Service/BuscaAnuncios.php",
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
                                    data = '<img style="width:150px; height:150px;" src="../assets/img/Anuncios/' + data + '" />';
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
                            "data": "anunciante",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "email",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "veiculo",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "dtcadastro",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "editar",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<div style="cursor:pointer;" onClick="AtualizaAnuncio(' + data + ')" class="btn btn-success"><i class="icone-forward"></i></div>';
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