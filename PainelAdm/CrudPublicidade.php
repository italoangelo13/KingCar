<?php
include_once 'header.inc.php';
//header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Publicidades.php';

$Publicidade = new Publicidades();
$util = new Util();

$numPublicidades = 0;
$dataAtual = date("d/m/Y");
$anoAtual = date("Y");

$strCount = $Publicidade->SelecionarTotalPublicidade();

if (count($strCount)) {
    foreach ($strCount as $row) {
        $numPublicidades = $row->NUMPUB;
    }
}





?>

<div class="row bg-primary text-white">
    <div class="col-lg-10">
        <h5>Cadastro de Publicidades</h5>
    </div>
    <div class="col-lg-2 text-right">
        <?php echo $numPublicidades; ?> Registro(s)
    </div>
</div>
<div id="pnl_Pesq" class="display-show">
    <div class="row" style="margin-top:5px;">
        <div class="col-lg-12">
            <div class="btn btn-success" onclick="CadastrarUsu()"><i class="icone-plus"></i> Cadastrar Publicidade</div>
        </div>
    </div>
    <div class="row bg-light" style="margin-top:5px; padding:5px;">
        <div class="col-lg-12">
            <table id="_gridPesq" class="table table-striped text-center ">
                <thead class="bg-success text-white">
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Empresa</th>
                        <th>Titulo</th>
                        <th>Dt. Cadastro</th>
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
    <form id="_formPub" action="" method="post" enctype="multipart/form-data">
        <div class="row" style="margin-top:5px;">
            <div class="col-lg-12">
                <div class="btn-group">
                    <div class="btn btn-dark" onclick="VoltarTelaPesq()"> <i class="icone-back"></i>Voltar</div>
                    <div class="btn btn-danger" onclick="LimparCampos()"> <i class="icone-cancel"></i> Limpar</div>
                    <div class="btn btn-success" onclick="InsereAtualiza()"><i class="icone-floppy"></i> Salvar</div>
                </div>
            </div>
        </div>
        <div class="row bg-dark text-white" style="margin-top:5px;">
            <div class="col-lg-12 text-center">
                Dados do Publicidade
            </div>
        </div>
        <div class="row bg-white" style="margin-top:5px;">
            <div class="form-group col-lg-1">
                <label for="_edCodPublicidade">Cod</label>
                <input type="text" value="" class="form-control" id="_edCodPublicidade" name="_edCodPublicidade" readonly>
            </div>
            <div class="form-group col-lg-3">
                <label for="_edEmpresa" class="text-danger">Empresa</label>
                <input type="text" value="" class="form-control" maxlength="255" id="_edEmpresa" name="_edEmpresa">
            </div>
            <div class="form-group col-lg-4">
                <label for="_edTitulo" class="text-danger">Titulo</label>
                <input type="text" value="" class="form-control" maxlength="255" id="_edTitulo" name="_edTitulo">
            </div>
            <div class="form-group col-lg-4">
                <label for="_edLink">link</label>
                <input type="text" value="" class="form-control" maxlength="255" id="_edLink" name="_edLink">
            </div>
        </div>
        <div class="row bg-white" style="margin-top:5px;">
            <div class="form-group col-lg-12">
                <label for="_btnCarregaImg">Imagem Publicidade</label>
                <br>
                <img name="_ImgCapaPreview" id="_ImgCapaPreview" src="../assets/img/sem-foto.gif" style="width: 300px; height: 300px;" alt="Capa do Anuncio" class="img-thumbnail">
                <br />
                <br />
                <input hidden type="file" name="_edImagemCapa" id="_edImagemCapa">
                <input hidden type="text" value="" name="_edImagemCapaAntiga" id="_edImagemCapaAntiga">

                <a class="btn btn-success text-white" style="width: 300px;" id="_btnCarregaImg"><i class="icone-image"></i> Carregar Imagem</a>
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
            
            var codPublicidade = $('#_edCodPublicidade').val();

            // Captura os dados do formulário
            var formulario = document.getElementById('_formPub');

            // Instância o FormData passando como parâmetro o formulário
            var formData = new FormData(formulario);
            formData.append('image', $('#_edImagemCapa').prop('files')[0]);
            if (!codPublicidade) { //INSERT
                showLoad('Aguarde! <br> Cadastrando Publicidade.');
                // Envia O FormData através da requisição AJAX
                $.ajax({
                    url: "../Service/InserePublicidade.php",
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
                            $('#_edCodPublicidade').val(dados[0].UltCod)
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
        $('#_edCodPublicidade').val('');
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


        showLoad('Aguarde!<br>Validando Informações do Publicidade.');

        var codPublicidade = $('#_edCodPublicidade').val();
        var empresa = $('#_edEmpresa').val();
        var titulo = $('#_edTitulo').val();
        var link = $('#_edLink').val();
        //var img =  $('#_edImagemCapa').prop('files')[0];
        //console.log(img);

        if (!empresa) {
            $('#_edEmpresa').focus();
            hideLoad();
            WarningBox('O campo empresa é obrigatório');
            return;
        }

        if (!titulo) {
            $('#_edEmpresa').focus();
            hideLoad();
            WarningBox('O campo titulo é obrigatório');
            return;
        }

        // if (!link) {
        //     $('#_edEmpresa').focus();
        //     hideLoad();
        //     WarningBox('O campo link é obrigatório');
        //     return;
        // }


        if (!codPublicidade) { //INSERT
            $('#_formPub').submit();
        } else { //UPDATE
            $('#_formPub').submit();
            // $.ajax({
            //     url: "../Service/AtualizaPublicidade.php",
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
            //                 ErrorBox('Não Foi Possivel Cadastrar este Publicidade.'); 
            //             break;
            //             case 1:
            //                 $('#_edCodPublicidade').val(dados[0].UltCod);
            //                 hideLoad();
            //                 SuccessBox('Publicidade cadastrado com Sucesso.'); 
            //             break;
            //             case 2:
            //                 hideLoad();
            //                 SuccessBox('Publicidade Atualizado com Sucesso.'); 
            //             break;
            //         }
            //     }
            // });
        }
    }

    function AtualizaPublicidade(codPublicidade) {
        showLoad('Aguarde!<br>Carregando as informações da Publicidade.');
        TrocaTela('#pnl_Pesq', '#Pnl_CadAtu');
        $('#_edCodPublicidade').val(codPublicidade);
        BuscaDadosPublicidade(codPublicidade);
    }

    function CadastrarUsu() {
        showLoad('Aguarde!');
        TrocaTela('#pnl_Pesq', '#Pnl_CadAtu');
        hideLoad();
    }

    function DeletaPublicidade(codPublicidade) {
        showLoad('Aguarde <br> Excluindo Publicidade Selecionada.');
        $.ajax({
            url: "../Service/DeletaPublicidade.php?cod=" + codPublicidade,
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

    function BuscaDadosPublicidade(codPublicidade) {
        $.ajax({
            url: "../Service/BuscaDadosPublicidade.php?cod=" + codPublicidade,
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
                    $('#_edEmpresa').val(dados[0].empresa);
                    $('#_edTitulo').val(dados[0].titulo);
                    $('#_edLink').val(dados[0].link);
                    $("#_ImgCapaPreview").attr('src','../assets/img/Pub/'+dados[0].imagem);
                    $('#_edImagemCapaAntiga').val(dados[0].imagem);
                    hideLoad();
                }
            }
        });
    }

    //Carregando Grid Pincipal
    function CarregaGridPrincipal() {
        showLoad('Carregando Informações!');

        $.ajax({
            url: "../Service/BuscaPublicidades.php",
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
                                    data = '<img style="width:75px; height:75px;" src="../assets/img/Pub/' + data + '" />';
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
                            "data": "empresa",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "titulo",
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