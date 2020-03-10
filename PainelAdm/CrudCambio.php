<?php
include_once 'header.inc.php';
//header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Cambios.php';

$Cambio = new Cambios();
$util = new Util();

$numCambios = 0;
$dataAtual = date("d/m/Y");
$anoAtual = date("Y");

$strCount = $Cambio->SelecionarTotalCambios();

if (count($strCount)) {
    foreach ($strCount as $row) {
        $numCambios = $row->NUMCAMBIO;
    }
}





?>

<div class="row bg-primary text-white">
    <div class="col-lg-10">
        <h5>Cadastro de Cambios</h5>
    </div>
    <div class="col-lg-2 text-right">
        <?php echo $numCambios; ?> Registro(s)
    </div>
</div>
<div id="pnl_Pesq" class="display-show">
    <div class="row" style="margin-top:5px;">
        <div class="col-lg-12">
            <div class="btn btn-success" onclick="CadastrarUsu()"><i class="icone-plus"></i> Cadastrar Cambio</div>
        </div>
    </div>
    <div class="row bg-light" style="margin-top:5px; padding:5px;">
        <div class="col-lg-12">
            <table id="_gridPesq" class="table table-striped text-center " >
                <thead class="bg-success text-white">
                    <tr>
                        <th>Id</th>
                        <th>Cambio</th>
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
                <div class="btn btn-success" onclick="InsereAtualiza()"><i class="icone-floppy"></i> Salvar</div>
            </div>
        </div>
    </div>
    <div class="row bg-dark text-white" style="margin-top:5px;">
        <div class="col-lg-12 text-center">
            Dados do Cambio
        </div>
    </div>
    <div class="row bg-white" style="margin-top:5px;">
        <div class="form-group col-lg-2">
            <label for="_edCodCambio">Cod</label>
            <input type="text" value="" class="form-control" id="_edCodCambio" name="_edCodCambio" readonly>
        </div>
        <div class="form-group col-lg-5">
            <label for="_edCambio" class="text-danger">Cambio</label>
            <input type="text" value="" class="form-control" maxlength="255" id="_edCambio" name="_edCambio" >
        </div>
    </div>
</div>





<script>
    $(document).ready(function() {
        atualizaGridPrincipal();

    });

    function LimparCampos(){
        $('#_edCodCambio').val('');
        $('#_edCambio').val('');
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

    function InsereAtualiza(){
        //TRANSCOD
        //0 - ERRO DE CODIGO
        //1 - OPERAÇÃO CONCLUIDA COM SUCESSO
        //2 - ativo JÁ CADASTRADO
        //3 - SENHA IGUAL A ANTERIOR


        showLoad('Aguarde!<br>Validando Informações do Cambio.');
        var codCambio = $('#_edCodCambio').val();
        var cambio = $('#_edCambio').val();

        if(!cambio){
            $('#_edCambio').focus();
            hideLoad();
            WarningBox('O campo cambio é obrigatório');
        }


        if(!codCambio){ //INSERT
            $.ajax({
                url: "../Service/InsereCambio.php?cambio="+cambio,
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
                            ErrorBox('Não Foi Possivel Cadastrar este Cambio.'); 
                        break;
                        case 1:
                            $('#_edCodCambio').val(dados[0].UltCod);
                            hideLoad();
                            SuccessBox('Cambio cadastrado com Sucesso.'); 
                        break;
                        case 2:
                            hideLoad();
                            SuccessBox('Cambio Atualizado com Sucesso.'); 
                        break;
                    }
                }
            });
        }
        else{ //UPDATE
            $.ajax({
                url: "../Service/AtualizaCambio.php?cod="+codCambio+"&cambio="+cambio,
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
                            ErrorBox('Não Foi Possivel Cadastrar este Cambio.'); 
                        break;
                        case 1:
                            $('#_edCodCambio').val(dados[0].UltCod);
                            hideLoad();
                            SuccessBox('Cambio cadastrado com Sucesso.'); 
                        break;
                        case 2:
                            hideLoad();
                            SuccessBox('Cambio Atualizado com Sucesso.'); 
                        break;
                    }
                }
            });
        }
    }

    function AtualizaCambio(codCambio){
        showLoad('Aguarde!<br>Carregando as informações da Cambio.');
        TrocaTela('#pnl_Pesq','#Pnl_CadAtu');
        $('#_edCodCambio').val(codCambio);
        BuscaDadosCambio(codCambio);
    }

    function CadastrarUsu(){
        showLoad('Aguarde!');
        TrocaTela('#pnl_Pesq','#Pnl_CadAtu');
        hideLoad();
    }

    function DeletaCambio(codCambio){
        showLoad('Aguarde <br> Excluindo Cambio Selecionado.');
        $.ajax({
            url: "../Service/DeletaCambio.php?cod="+codCambio,
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            data: {},
            success: function(data) {
                debugger;
                console.log(data);
                var dados = JSON.parse(data);
                console.log(dados[0]);
                if(dados[0].TransCod == 0 || dados[0].TransCod == 2){
                    hideLoad();
                    ErrorBox(dados[0].msg);
                }
                else{
                    hideLoad();
                    SuccessBox('Cambio Deletado com Sucesso.');
                    atualizaGridPrincipal();
                }
            }
        });
    }

    function BuscaDadosCambio(codCambio){
        $.ajax({
            url: "../Service/BuscaDadosCambio.php?cod="+codCambio,
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
                    $('#_edCambio').val(dados[0].cambio);
                    $('#_ddlAtivo').val(dados[0].ativo);
                    hideLoad();
                }
            }
        });
    }

    //Carregando Grid Pincipal
    function CarregaGridPrincipal() {
        showLoad('Carregando Informações!');

        $.ajax({
            url: "../Service/BuscaCambios.php",
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
                            "data": "cambio",
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
                                    data = '<div style="cursor:pointer;" onClick="AtualizaCambio(' + data + ')" class="btn btn-success"><i class="icone-pencil"></i></div>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "excluir",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<div style="cursor:pointer;" onClick="DeletaCambio(' + data + ')" class="btn btn-danger"><i class="icone-trash"></i></div>';
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