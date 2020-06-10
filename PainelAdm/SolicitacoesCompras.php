<?php
include_once 'header.inc.php';
//header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Compra.php';

$Compra = new Compra();
$util = new Util();

$numUsuarios = 0;
$dataAtual = date("d/m/Y");
$anoAtual = date("Y");

$qtdeMsg = $Compra->SelecionarNumSolicitacaoCompra();

if (count($qtdeMsg)) {
    foreach ($qtdeMsg as $row) {
        $numMsg = $row->QTDE;
    }
}

if (isset($_GET['msg'])) {
    $codMsg = $_GET['msg'];

    switch ($codMsg) {
        case 1:
            echo '<script> ErrorBox("Não foi possivel Carregar a tela de Resposta."); </script>';
            break;

        case 2:
            echo '<script> SuccessBox("Email enviado com sucesso."); </script>';
            break;
    }
}



?>

<div class="row bg-primary text-white">
    <div class="col-lg-8">
        <h5>Interesses em Veículos</h5>
    </div>
    <div class="col-lg-4 text-right">
         <label for=""><?php echo $numMsg; ?></label> Registro(s) não Lido(s)!
    </div>
</div>
<div id="pnl_Pesq" class="display-show">
    <div class="row bg-light" style="margin-top:5px; padding:5px;">
        <div class="col-lg-12">
            <table id="_gridPesq" class="table table-striped text-center table-responsive-md" style="width: 100%">
                <thead class="bg-success text-white">
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Data</th>
                        <th>Assunto</th>
                        <th>Ir para Solicitação</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="Pnl_Det" class="display-hide">
    <div class="row" style="margin-top:5px;">
        <div class="col-lg-12">
            <div class="btn-group">
                <div class="btn btn-dark" onclick="VoltarTelaPesq()"> <i class="icone-back"></i>Voltar</div>
            </div>
        </div>
    </div>
    <div class="row bg-light" style="margin-top:5px;">
        <div class="col-lg-1">
            <label for="">Cod.</label>
            <br>
            <label class="form-control form-control-lg" id="_lblCodSolicitacao"></label>
        </div>

        <div class="col-lg-6">
            <label for="">Nome</label>
            <br>
            <label class="form-control form-control-lg" id="_lblNome"></label>
        </div>
        <div class="col-lg-5">
            <label for="">Email</label>
            <br>
            <label class="form-control form-control-lg" id="_lblEmail"></label>
        </div>
    </div>
    <div class="row bg-light">
        <div class="col-lg-6">
            <label for="">Telefone</label>
            <br>
            <label class="form-control form-control-lg" id="_lblTelefone"></label>
        </div>

        <div class="col-lg-6">
            <label for="">Assunto</label>
            <br>
            <label class="form-control form-control-lg" id="_lblAssunto"></label>
        </div>
    </div>
    <div class="row bg-light">
        <div class="col-lg-12">
            <label for="">Mensagem</label>
            <br>
            <textarea name="msg" id="_lblMensagem" class="form-control form-control-lg" style="height: 200px;resize: none;" readonly required></textarea>

        </div>
        <div class="col-lg-12">
            Esta mensagem foi enviada em <label for="" id="_lblDataCadastro"></label>
        </div>
    </div>
</div>





<script>
    $(document).ready(function() {
        atualizaGridPrincipal();
        
    });

    function LimparCampos() {
        $('#_edCodUsuario').val('');
        $('#_edNome').val('');
        $('#_edUsuario').val('');
        $('#_edSenha').val('');
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
        TrocaTela('#Pnl_Det', '#pnl_Pesq');
        atualizaGridPrincipal();
        hideLoad();
    }

    function InsereAtualizaUsuario() {
        //TRANSCOD
        //0 - ERRO DE CODIGO
        //1 - OPERAÇÃO CONCLUIDA COM SUCESSO
        //2 - USUARIO JÁ CADASTRADO
        //3 - SENHA IGUAL A ANTERIOR


        showLoad('Aguarde!<br>Validando Informações do Usuario.');
        var codUsu = $('#_edCodUsuario').val();
        var nome = $('#_edNome').val();
        var usuario = $('#_edUsuario').val();
        var senha = $('#_edSenha').val();

        if (!nome) {
            $('#_edNome').focus();
            hideLoad();
            WarningBox('O campo NOME é obrigatório');
        }

        if (!usuario) {
            $('#_edUsuario').focus();
            hideLoad();
            WarningBox('O campo USUARIO é obrigatório');
        }

        if (!senha) {
            $('#_edSenha').focus();
            hideLoad();
            WarningBox('O campo SENHA é obrigatório');
        }

        if (!codUsu) { //INSERT
            $.ajax({
                url: "../Service/InsereUsuario.php?nome=" + nome + "&usuario=" + usuario + "&senha=" + senha,
                type: 'GET',
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: {},
                success: function(data) {
                    debugger;
                    console.log(data);
                    var dados = JSON.parse(data);
                    console.log(dados[0]);
                    switch (dados[0].TransCod) {
                        case 0:
                            hideLoad();
                            ErrorBox('Não Foi Possivel Cadastrar este Usuario.');
                            break;
                        case 1:
                            $('#_edCodUsuario').val(dados[0].UltCod);
                            hideLoad();
                            SuccessBox('Usuário cadastrado com Sucesso.');
                            break;
                        case 2:
                            hideLoad();
                            WarningBox('Este Usuário já está sendo Utilizado.');
                            break;
                        case 3:
                            hideLoad();
                            WarningBox('Sua Nova senha não pode ser igual a anterior.');
                            break;
                        case 4:
                            hideLoad();
                            SuccessBox('Usuário Atualizado com Sucesso.');
                            break;
                    }
                }
            });
        } else { //UPDATE
            $.ajax({
                url: "../Service/AtualizaUsuario.php?cod=" + codUsu + "&nome=" + nome + "&usuario=" + usuario + "&senha=" + senha,
                type: 'GET',
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: {},
                success: function(data) {
                    debugger;
                    console.log(data);
                    var dados = JSON.parse(data);
                    console.log(dados[0]);
                    switch (dados[0].TransCod) {
                        case 0:
                            hideLoad();
                            ErrorBox('Não Foi Possivel Cadastrar este Usuario.');
                            break;
                        case 1:
                            $('#_edCodUsuario').val(dados[0].UltCod);
                            hideLoad();
                            SuccessBox('Usuário cadastrado com Sucesso.');
                            break;
                        case 2:
                            hideLoad();
                            WarningBox('Este Usuário já está sendo Utilizado.');
                            break;
                        case 3:
                            hideLoad();
                            WarningBox('Sua Nova senha não pode ser igual a anterior.');
                            break;
                        case 4:
                            hideLoad();
                            SuccessBox('Usuário Atualizado com Sucesso.');
                            break;
                    }
                }
            });
        }
    }

    function DetSolicitacao(codSol) {
        showLoad('Aguarde!<br>Carregando as informações da Solicitação.');
        TrocaTela('#pnl_Pesq', '#Pnl_Det');
        $('#_lblCodSolicitacao').text(codSol);
        BuscaDadosSolicitacao(codSol);
    }

    function CadastrarUsu() {
        showLoad('Aguarde!');
        TrocaTela('#pnl_Pesq', '#Pnl_Det');
        hideLoad();
    }

    function DeletaUsu(codUsu) {
        showLoad('Aguarde <br> Excluindo Usuário Selecionado.');
        $.ajax({
            url: "../Service/DeletaUsuario.php?cod=" + codUsu,
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
                    hideLoad();
                    SuccessBox('Usuário Deletado com Sucesso.');
                    atualizaGridPrincipal();
                }
            }
        });
    }

    function BuscaDadosSolicitacao(codSol) {
        $.ajax({
            url: "../Service/BuscaDadosSolicitacao.php?cod=" + codSol,
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: {},
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados);
                if (dados.TransCod == 0) {
                    hideLoad();
                    ErrorBox(dados.msg);
                } else {
                    debugger;
                    $('#_lblNome').text(dados.nome);
                    $('#_lblEmail').text(dados.email);
                    $('#_lblTelefone').text(dados.tel);
                    $('#_lblDataCadastro').text(dados.dataSolicitacao);
                    $('#_lblMensagem').text(dados.msg);
                    $('#_lblAssunto').text(dados.assunto);
                    hideLoad();
                }
            }
        });
    }

    //Carregando Grid Pincipal
    function CarregaGridPrincipal() {
        showLoad('Carregando Informações!');

        $.ajax({
            url: "../Service/BuscaSolicitacoesContato.php",
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
                            "data": "lido",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    if (data == 'N') {
                                        data = '<span class="badge badge-danger">Novo</span>';
                                    } else {
                                        data = '<span class="badge badge-success">Lido</span>';
                                    }

                                }

                                return data;
                            }
                        },
                        {
                            "data": "id",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "nome",
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
                            "data": "dtcadastro",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "assunto",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "det",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<div style="cursor:pointer;" onClick="DetSolicitacao(' + data + ')" class="btn btn-success"><i class="icone-folder-open"></i></div>';
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