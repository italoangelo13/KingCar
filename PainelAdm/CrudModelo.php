<?php
include_once 'header.inc.php';
//header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Modelos.php';

$Modelo = new Modelos();
$util = new Util();

$numModelos = 0;
$dataAtual = date("d/m/Y");
$anoAtual = date("Y");

$strCount = $Modelo->SelecionarTotalModelos();

if (count($strCount)) {
    foreach ($strCount as $row) {
        $numModelos = $row->NUMMODELOS;
    }
}





?>

<div class="row bg-primary text-white">
    <div class="col-lg-10">
        <h5>Cadastro de Modelos</h5>
    </div>
    <div class="col-lg-2 text-right">
        <?php echo $numModelos; ?> Registro(s)
    </div>
</div>
<div id="pnl_Pesq" class="display-show">
    <div class="row" style="margin-top:5px;">
        <div class="col-lg-12">
            <div class="btn btn-success" onclick="CadastrarUsu()"><i class="icone-plus"></i> Cadastrar Modelo</div>
        </div>
    </div>
    <div class="row bg-light" style="margin-top:5px; padding:5px;">
        <div class="col-lg-12">
            <table id="_gridPesq" class="table table-striped text-center " >
                <thead class="bg-success text-white">
                    <tr>
                        <th>Id</th>
                        <th>Marca</th>
                        <th>Modelo</th>
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
            Dados do Modelo
        </div>
    </div>
    <div class="row bg-white" style="margin-top:5px;">
        <div class="form-group col-lg-2">
            <label for="_edCodModelo">Cod</label>
            <input type="text" value="" class="form-control" id="_edCodModelo" name="_edCodModelo" readonly>
        </div>
        <div class="form-group col-lg-4">
            <label for="_edModelo" class="text-danger">Modelo</label>
            <input type="text" value="" class="form-control" maxlength="255" id="_edModelo" name="_edModelo" >
        </div>
        <div class="form-group col-lg-4">
            <label for="_ddlMarca" class="text-danger">Marca</label>
            <Select class="form-control" required id="_ddlMarca" name="_ddlMarca">
                <option value="">Selecionar</option>
            </Select>
        </div>
    </div>
</div>





<script>
    $(document).ready(function() {
        atualizaGridPrincipal();
        BuscaDadosTodasMarca();
    });

    function LimparCampos(){
        $('#_edCodModelo').val('');
        $('#_edModelo').val('');
        $('#_ddlMarca').val('S');
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
        //2 - marca JÁ CADASTRADO
        //3 - SENHA IGUAL A ANTERIOR


        showLoad('Aguarde!<br>Validando Informações do marca.');
        var codModelo = $('#_edCodModelo').val();
        var modelo = $('#_edModelo').val();
        var marca = $('#_ddlMarca').val();

        if(!modelo){
            $('#_edModelo').focus();
            hideLoad();
            WarningBox('O campo modelo é obrigatório');
            return;
        }

        if(!marca){
            $('#_ddlMarca').focus();
            hideLoad();
            WarningBox('O campo marca é obrigatório');
            return;
        }


        if(!codModelo){ //INSERT
            $.ajax({
                url: "../Service/InsereModelo.php?modelo="+modelo+"&marca="+marca,
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
                            ErrorBox('Não Foi Possivel Cadastrar este Modelo.'); 
                        break;
                        case 1:
                            $('#_edCodModelo').val(dados[0].UltCod);
                            hideLoad();
                            SuccessBox('Modelo cadastrado com Sucesso.'); 
                        break;
                        case 2:
                            hideLoad();
                            SuccessBox('Modelo Atualizado com Sucesso.'); 
                        break;
                    }
                }
            });
        }
        else{ //UPDATE
            $.ajax({
                url: "../Service/AtualizaModelo.php?cod="+codModelo+"&modelo="+modelo+"&marca="+marca,
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
                            ErrorBox('Não Foi Possivel Cadastrar este Modelo.'); 
                        break;
                        case 1:
                            $('#_edCodModelo').val(dados[0].UltCod);
                            hideLoad();
                            SuccessBox('Modelo cadastrado com Sucesso.'); 
                        break;
                        case 2:
                            hideLoad();
                            SuccessBox('Modelo Atualizado com Sucesso.'); 
                        break;
                    }
                }
            });
        }
    }

    function AtualizaModelo(codModelo){
        showLoad('Aguarde!<br>Carregando as informações do Modelo.');
        TrocaTela('#pnl_Pesq','#Pnl_CadAtu');
        $('#_edCodModelo').val(codModelo);
        BuscaDadosModelo(codModelo);
    }

    function CadastrarUsu(){
        showLoad('Aguarde!');
        TrocaTela('#pnl_Pesq','#Pnl_CadAtu');
        hideLoad();
    }

    function DeletaModelo(codModelo){
        showLoad('Aguarde <br> Excluindo Modelo Selecionado.');
        $.ajax({
            url: "../Service/DeletaModelo.php?cod="+codModelo,
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
                    SuccessBox('Modelo Deletado com Sucesso.');
                    atualizaGridPrincipal();
                }
            }
        });
    }

    function BuscaDadosModelo(codModelo){
        $.ajax({
            url: "../Service/BuscaDadosModelo.php?cod="+codModelo,
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
                    $('#_edModelo').val(dados[0].modelo);
                    $('#_ddlMarca').val(dados[0].marca);
                    hideLoad();
                }
            }
        });
    }

    function BuscaDadosTodasMarca(){
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
                    $('<option>').val(o.id).text(o.marca).appendTo(selectbox);
                });
                $('<option>').val('').text('Selecionar').appendTo(selectbox);
                $('#_ddlMarca option[value=""]').attr('selected', 'selected');
            }
        });
    }

    //Carregando Grid Pincipal
    function CarregaGridPrincipal() {
        showLoad('Carregando Informações!');

        $.ajax({
            url: "../Service/BuscaTodosModelos.php",
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
                                    data = '<div style="cursor:pointer;" onClick="AtualizaModelo(' + data + ')" class="btn btn-success"><i class="icone-pencil"></i></div>';
                                }

                                return data;
                            }
                        },
                        {
                            "data": "excluir",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<div style="cursor:pointer;" onClick="DeletaModelo(' + data + ')" class="btn btn-danger"><i class="icone-trash"></i></div>';
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