<?php
include_once 'header.inc.php';
header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Usuarios.php';

$Usuario = new Usuarios();
$util = new Util();

$numUsuarios = 0;
$dataAtual = date("d/m/Y");
$anoAtual = date("Y");

$sqlusu = "SELECT count(*) as NumUsuarios FROM KGCTBLUSU";
$strCount = $Usuario->SelecionarNumUsuarios($sqlusu);

if (count($strCount)) {
    foreach ($strCount as $row) {
        $numUsuarios = $row->NumUsuarios;
    }
}





?>

<div class="row bg-primary text-white">
    <div class="col-lg-10">
        <h5>Cadastro de Usuarios</h5>
    </div>
    <div class="col-lg-2 text-right">
        <?php echo $numUsuarios; ?> Registro(s)
    </div>
</div>
<div id="pnl_Pesq" class="display-show">
    <div class="row" style="margin-top:5px;">
        <div class="col-lg-12">
            <div class="btn btn-success" onclick="CadastrarUsu()"><i class="icone-plus"></i> Cadastrar Usuario</div>
        </div>
    </div>
    <div class="row bg-light" style="margin-top:5px; padding:5px;">
        <div class="col-lg-12">
            <table id="_gridPesq" class="table table-striped text-center " >
                <thead class="bg-success text-white">
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Usuario</th>
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
    <div class="row" style="margin-top:5px;">
        <div class="col-lg-12">
            <div class="btn-group">
                <div class="btn btn-dark" onclick="VoltarTelaPesq()"> <i class="icone-back"></i>Voltar</div>
                <div class="btn btn-danger" onclick="LimparCampos()"> <i class="icone-cancel"></i> Limpar</div>
                <div class="btn btn-success" onclick="InsereAtualizaUsuario()"><i class="icone-floppy"></i> Salvar</div>
            </div>
        </div>
    </div>
    <div class="row bg-dark text-white" style="margin-top:5px;">
        <div class="col-lg-12 text-center">
            Dados do Usuário
        </div>
    </div>
    <div class="row bg-white" style="margin-top:5px;">
        <div class="form-group col-lg-2">
            <label for="_edCodUsuario">Cod</label>
            <input type="text" value="" class="form-control" id="_edCodUsuario" name="_edCodUsuario" readonly>
        </div>
        <div class="form-group col-lg-3">
            <label for="_edNome" class="text-danger">Nome</label>
            <input type="text" value="" class="form-control" maxlength="255" id="_edNome" name="_edNome" >
        </div>
        <div class="form-group col-lg-3">
            <label for="_edUsuario" class="text-danger">Usuario</label>
            <input type="text" value="" class="form-control" maxlength="50" id="_edUsuario" name="_edUsuario" >
        </div>
        <div class="form-group col-lg-3">
            <label for="_edSenha" class="text-danger">Senha</label>
            <input type="password" value="" class="form-control" maxlength="50" id="_edSenha" name="_edSenha" >
        </div>
    </div>
</div>





<script>
    $(document).ready(function() {
        atualizaGridPrincipal();

    });

    function LimparCampos(){
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

    function TrocaTela(h,s){
        //s -> Tela a ser mostrada
        //h -> Tela a ser ocultada
        $(h).removeClass("display-show");
        $(h).addClass("display-hide");

        $(s).removeClass("display-hide");
        $(s).addClass("display-show");

    }

    function VoltarTelaPesq(){
        showLoad('Aguarde!');
        LimparCampos();
        TrocaTela('#Pnl_CadAtu','#pnl_Pesq');
        atualizaGridPrincipal();
        hideLoad();
    }

    function InsereAtualizaUsuario(){
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

        if(!nome){
            $('#_edNome').focus();
            hideLoad();
            WarningBox('O campo NOME é obrigatório');
        }

        if(!usuario){
            $('#_edUsuario').focus();
            hideLoad();
            WarningBox('O campo USUARIO é obrigatório');
        }

        if(!senha){
            $('#_edSenha').focus();
            hideLoad();
            WarningBox('O campo SENHA é obrigatório');
        }

        if(!codUsu){ //INSERT
            $.ajax({
                url: "../Service/InsereUsuario.php?nome="+nome+"&usuario="+usuario+"&senha="+senha,
                type: 'GET',
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: {},
                success: function(data) {
                    debugger;
                    console.log(data);
                    var dados = JSON.parse(data);
                    console.log(dados[0]);
                    switch(dados[0].TransCod){
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
        else{ //UPDATE
            $.ajax({
                url: "../Service/AtualizaUsuario.php?cod="+codUsu+"&nome="+nome+"&usuario="+usuario+"&senha="+senha,
                type: 'GET',
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: {},
                success: function(data) {
                    debugger;
                    console.log(data);
                    var dados = JSON.parse(data);
                    console.log(dados[0]);
                    switch(dados[0].TransCod){
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

    function AtualizaUsu(codUsu){
        showLoad('Aguarde!<br>Carregando as informações do Usuario.');
        TrocaTela('#pnl_Pesq','#Pnl_CadAtu');
        $('#_edCodUsuario').val(codUsu);
        BuscaDadosUsuario(codUsu);
    }

    function CadastrarUsu(){
        showLoad('Aguarde!');
        TrocaTela('#pnl_Pesq','#Pnl_CadAtu');
        hideLoad();
    }

    function DeletaUsu(codUsu){
        showLoad('Aguarde <br> Excluindo Usuário Selecionado.');
        $.ajax({
            url: "../Service/DeletaUsuario.php?cod="+codUsu,
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: {},
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados[0]);
                if(dados[0].TransCod == 0){
                    hideLoad();
                    ErrorBox(dados[0].msg);
                }
                else{
                    hideLoad();
                    SuccessBox('Usuário Deletado com Sucesso.');
                    atualizaGridPrincipal();
                }
            }
        });
    }

    function BuscaDadosUsuario(codUsu){
        $.ajax({
            url: "../Service/BuscaDadosUsuarios.php?cod="+codUsu,
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: {},
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados[0]);
                if(dados[0].TransCod == 0){
                    hideLoad();
                    ErrorBox(dados[0].msg);
                }
                else{
                    $('#_edNome').val(dados[0].nome);
                    $('#_edUsuario').val(dados[0].usuario);
                    $('#_edsenha').val('');
                    hideLoad();
                }
            }
        });
    }

    //Carregando Grid Pincipal
    function CarregaGridPrincipal() {
        showLoad('Carregando Informações!');

        $.ajax({
            url: "../Service/BuscaUsuarios.php",
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
                            "data": "usuario",
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
                                    data = '<div style="cursor:pointer;" onClick="AtualizaUsu(' + data + ')" class="btn btn-success"><i class="icone-pencil"></i></div>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "excluir",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<div style="cursor:pointer;" onClick="DeletaUsu(' + data + ')" class="btn btn-danger"><i class="icone-trash"></i></div>';
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