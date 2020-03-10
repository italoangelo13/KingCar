<?php
include_once 'header.inc.php';
//header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Cores.php';

$Cor = new Cores();
$util = new Util();

$numCores = 0;

$strCount = $Cor->SelecionarTotalCores();

if (count($strCount)) {
    foreach ($strCount as $row) {
        $numCores = $row->NUMCORES;
    }
}





?>

<div class="row bg-primary text-white">
    <div class="col-lg-10">
        <h5>Cadastro de Cores</h5>
    </div>
    <div class="col-lg-2 text-right">
        <?php echo $numCores; ?> Registro(s)
    </div>
</div>
<div id="pnl_Pesq" class="display-show">
    <div class="row" style="margin-top:5px;">
        <div class="col-lg-12">
            <div class="btn btn-success" onclick="CadastrarUsu()"><i class="icone-plus"></i> Cadastrar Cor</div>
        </div>
    </div>
    <div class="row bg-light" style="margin-top:5px; padding:5px;">
        <div class="col-lg-12">
            <table id="_gridPesq" class="table table-striped text-center " >
                <thead class="bg-success text-white">
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Cor</th>
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
            Dados da Cor
        </div>
    </div>
    <div class="row bg-white" style="margin-top:5px;">
        <div class="form-group col-lg-2">
            <label for="_edCodCor">Cod</label>
            <input type="text" value="" class="form-control" id="_edCodCor" name="_edCodCor" readonly>
        </div>
        <div class="form-group col-lg-4">
            <label for="_edNomeCor" class="text-danger">Nome</label>
            <input type="text" value="" class="form-control" maxlength="255" id="_edNomeCor" name="_edNomeCor" >
        </div>
        <div class="form-group col-lg-1">
            <label for="_edCorHex" class="text-danger">Cor</label>
            <input type="color" value="#000000" class="form-control" id="_edCorHex" name="_edCorHex" >
        </div>
    </div>
</div>





<script>
    $(document).ready(function() {
        atualizaGridPrincipal();

    });

    function LimparCampos(){
        $('#_edCodCor').val('');
        $('#_edNomeCor').val('');
        $('#_edCorHex').val('#000000');
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
        //2 - hexa JÁ CADASTRADO
        //3 - SENHA IGUAL A ANTERIOR


        showLoad('Aguarde!<br>Validando Informações da Cor.');
        debugger;
        var codCor = $('#_edCodCor').val();
        var cor = $('#_edNomeCor').val();
        var hexa = $('#_edCorHex').val();
        hexa = hexa.replace('#','');

        if(!cor){
            $('#_edNomeCor').focus();
            hideLoad();
            WarningBox('O campo Nome é obrigatório');
        }



        if(!codCor){ //INSERT
            $.ajax({
                url: "../Service/InsereCor.php?cor="+cor+"&hexa="+hexa,
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
                            ErrorBox('Não Foi Possivel Cadastrar esta Cor.'); 
                        break;
                        case 1:
                            $('#_edCodCor').val(dados[0].UltCod);
                            hideLoad();
                            SuccessBox('Cor cadastrada com Sucesso.'); 
                        break;
                        case 2:
                            hideLoad();
                            SuccessBox('Cor Atualizada com Sucesso.'); 
                        break;
                    }
                }
            });
        }
        else{ //UPDATE
            $.ajax({
                url: "../Service/AtualizaCor.php?cod="+codCor+"&cor="+cor+"&hexa="+hexa,
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
                            ErrorBox('Não Foi Possivel Cadastrar esta Cor.'); 
                        break;
                        case 1:
                            $('#_edCodCor').val(dados[0].UltCod);
                            hideLoad();
                            SuccessBox('Cor cadastrada com Sucesso.'); 
                        break;
                        case 2:
                            hideLoad();
                            SuccessBox('Cor Atualizada com Sucesso.'); 
                        break;
                    }
                }
            });
        }
    }

    function AtualizaCor(codCor){
        showLoad('Aguarde!<br>Carregando as informações da Cor.');
        TrocaTela('#pnl_Pesq','#Pnl_CadAtu');
        $('#_edCodCor').val(codCor);
        BuscaDadosCor(codCor);
    }

    function CadastrarUsu(){
        showLoad('Aguarde!');
        TrocaTela('#pnl_Pesq','#Pnl_CadAtu');
        hideLoad();
    }

    function DeletaCor(codCor){
        showLoad('Aguarde <br> Excluindo Cor Selecionada.');
        $.ajax({
            url: "../Service/DeletaCor.php?cod="+codCor,
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
                    SuccessBox('Marca Deletada com Sucesso.');
                    atualizaGridPrincipal();
                }
            }
        });
    }

    function BuscaDadosCor(codCor){
        $.ajax({
            url: "../Service/BuscaDadosCor.php?cod="+codCor,
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
                    $('#_edNomeCor').val(dados[0].cor);
                    $('#_edCorHex').val(dados[0].hexa);
                    hideLoad();
                }
            }
        });
    }

    //Carregando Grid Pincipal
    function CarregaGridPrincipal() {
        showLoad('Carregando Informações!');

        $.ajax({
            url: "../Service/BuscaCores.php",
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
                            "data": "cores",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "hexa",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label style="background:' + data + ';border:1px rgba(0,0,0,0.3) solid; width:40px; height:40px;"></label>';
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
                                    data = '<div style="cursor:pointer;" onClick="AtualizaCor(' + data + ')" class="btn btn-success"><i class="icone-pencil"></i></div>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "excluir",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<div style="cursor:pointer;" onClick="DeletaCor(' + data + ')" class="btn btn-danger"><i class="icone-trash"></i></div>';
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