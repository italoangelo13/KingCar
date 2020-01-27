<?php
include_once 'header.inc.php';
//header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Carros.php';

$Carros = new Carros();
$util = new Util();

$numCarros = 0;
$dataAtual = date("d/m/Y");
$anoAtual = date("Y");

$sqlQtdeCarro = "SELECT COUNT(*) AS QTDE FROM KGCTBLCAR
WHERE NOT EXISTS(SELECT 1 FROM KGCTBLDETCAR WHERE CARCOD = DETCODCARRO)";
$strCount = $Carros->SelecionarNumCarrosDetIncompletos($sqlQtdeCarro);

if (count($strCount)) {
    foreach ($strCount as $row) {
        $numCarros = $row->QTDE;
    }
}





?>

<div class="row bg-primary text-white">
    <div class="col-lg-10">
        <h5>Relatório de Veiculos Incompletos</h5>
    </div>
    <div class="col-lg-2 text-right">
        <?php echo $numCarros; ?> Registro(s)
    </div>
</div>
    <div class="row bg-light" style="margin-top:5px; padding:5px;">
        <div class="col-lg-12">
            <table id="_gridPesq" class="table table-striped text-center " >
                <thead class="bg-success text-white">
                    <tr>
                        <th>Foto</th>
                        <th>Id</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                        <th>Usuario</th>
                        <th>Dt. Cadastro</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>






<script>
    $(document).ready(function() {
        atualizaGridPrincipal();

    });


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


    //Carregando Grid Pincipal
    function CarregaGridPrincipal() {
        showLoad('Carregando Informações!');

        $.ajax({
            url: "../Service/BuscaVeiculosImcompletos.php",
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
                            "data": "foto",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<img class="img-fot-ret"  src="../assets/img/Carros/' + data + '" />';
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
                            "data": "link",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<a  href="InsereAtualizaCarro.php?acao=editar&cod=' + data + '" class="btn btn-success"><i class="icone-pencil"></i></a>';
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