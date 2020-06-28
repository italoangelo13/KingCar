<?php
include_once 'header.inc.php';
require_once('../Models/Carros.php');
require_once('../Models/Publicidades.php');
require_once('../Models/Anuncios.php');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

//INSTANCIANDO OBJETOS

$CARRO = new Carros();
$Pub = new Publicidades();
$Anun = new Anuncios();

$mes = strftime('%B de %Y', strtotime('today'));
$numMes = date("m");



//INFORMAÇÕES DO DASHBOARD

$CarrosMes = 0;
$AnunciosMes = 0;
$SolicitacoesMes = 0;
$UsuariosMes = 0;

//Buscando Qtde Usuario
$sqlusu = "SELECT count(*) as NumUsuarios FROM KGCTBLUSU";
$QtdeUsu = $USUARIO->SelecionarNumUsuarios($sqlusu);
$UsuariosMes = $QtdeUsu[0]->NumUsuarios;

//Buscando Qtde Carros
$sqlcar = "SELECT count(*) as NumCarros FROM KGCTBLCAR";
$QtdeCar = $CARRO->SelecionarNumCarros($sqlcar);
$CarrosMes = $QtdeCar[0]->NumCarros;


//Buscando Qtde publicidades
$QtdePub = $Pub->SelecionarTotalPublicidade();
$AnunciosMes = $QtdePub[0]->NUMPUB;

//Buscando Qtde Anuncios
$QtdeAnu = $Anun->SelecionarTotalAnuncio();
$SolicitacoesMes = $QtdeAnu[0]->NUMANUNCIO;


?>
<div class="row" style="margin-top:10px;">
    <!-- Box Carros -->
    <div class="col-lg-4 " style="margin-bottom: 3px;">
        <div class="container box-dash bg-secondary">
            <div class="row">
                <div class="col-6 text-white">
                    <h6>Veículos</h6>
                    <i class="fas fa-car" style="font-size:50pt;"></i>
                </div>
                <div class="col-6 text-center">
                    <label class="text-warning" style="font-size:50pt;"><?php echo $CarrosMes; ?></label>
                </div>
            </div>
        </div>
    </div>

    <!-- Box Anuncios -->
    <div class="col-lg-4 " style="margin-bottom: 3px;">
        <div class="container box-dash bg-danger">
            <div class="row">
                <div class="col-6 text-white">
                    <h6>Publicidades</h6>
                    <i class="fas fa-newspaper" style="font-size:50pt;"></i>
                </div>
                <div class="col-6 text-center">
                    <label class="text-warning" style="font-size:50pt;"><?php echo $AnunciosMes; ?></label>
                </div>
            </div>
        </div>

    </div>

    <!-- Box Sol. Anuncio
    <div class="col-lg-3" style="margin-bottom: 3px;">
        <div class="container box-dash bg-info">
            <div class="row">
                <div class="col-6 text-white">
                    <h6>Sol. Anuncio</h6>
                    <i class="fas fa-envelope-open-text" style="font-size:50pt;"></i></i>
                </div>
                <div class="col-6 text-center">
                    <label class="text-warning" style="font-size:50pt;"><?php echo $SolicitacoesMes; ?></label>
                </div>
            </div>
        </div>

    </div> -->

    <!-- Box Usuarios -->
    <div class="col-lg-4" style="margin-bottom: 3px;">
        <div class="container box-dash bg-success">
            <div class="row">
                <div class="col-6 text-white">
                    <h6>Usuarios</h6>
                    <i class="fas fa-user" style="font-size:50pt;"></i>
                </div>
                <div class="col-6 text-center">
                    <label class="text-warning" style="font-size:50pt;"><?php echo $UsuariosMes; ?></label>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row" style="padding:10px;">
    <div class="col-lg-6" style="padding: 5px;">
        <div style="background-color: white; border-radius: 5px; padding:2px;">
            <h5 class="alert alert-primary">Carros por Mês</h5>
            <canvas id="_grafCarros" width="100%"></canvas>
            <div class="text-center" style="display: none;" id="msg-empty-vei">

            </div>
        </div>
    </div>

    <div class="col-lg-6" style="padding: 5px;">
        <div style="background-color: white; border-radius: 5px; padding:2px;">
            <h5 class="alert alert-primary">Publicidades por Mês</h5>
            <canvas id="_grafPub" width="100%"></canvas>
            <div class="text-center" style="display: none;" id="msg-empty-pub">

            </div>
        </div>
    </div>

    <!-- <div class="col-lg-4" style="padding: 5px;">
        <div style="background-color: white; border-radius: 5px; padding:2px;">
            <h5 class="alert alert-primary">Sol. Anuncios por Mês</h5>
            <canvas id="_grafAnun" width="100%"></canvas>
            
        </div>
    </div> -->
</div>


<div class="row">
    <div class="col-lg-12">
        <div style="background-color: white; border-radius: 5px; padding:10px;">
            <h5 class="alert alert-primary">Veículos Mais Visitados</h5>
            <table id="_gridVeicVisit" style="width: 100%" class="table table-striped text-center table-responsive-md">
                <thead class="bg-success text-white">
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Tipo</th>
                        <th>Id</th>
                        <th>Veiculo</th>
                        <th>Preço</th>
                        <th>Qtde. Visitas</th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="bg-dark text-warning" style="width: 100%; padding:5px;">
                <label for="">Legenda</label>
                <p>
                    <i class="icone-crown"></i> Veículo Destaque
                    <br>
                    <label for="" class="text-danger">
                        <i class="icone-arrows-cw"></i> Aceita Troca
                    </label>
                    <br>
                    <label for="" class="text-info">
                        <i class="icone-diamond"></i> Novo/Semi-novo
                    </label>
                    <br>
                    <label for="" class="text-success">
                        <i class="icone-forward-1"></i> Repasse
                    </label>
                    <br>
                    <label for="" class="text-primary">
                        <i class="icone-hammer"></i> Sinistrado/Recuperado
                    </label>

                </p>
            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        CaregaGrafCarros();
        CaregaGrafPub();
        CaregaGrafAnun();
        atualizaGridVeiculos();
    });

    //Atualiza Grid Veivulos
    function atualizaGridVeiculos() {
        //debugger;
        if ($.fn.DataTable.isDataTable('#_gridVeicVisit')) {
            var table = $('#_gridVeicVisit').DataTable();
            table.destroy();
            CarregaGridVeiculos();
        } else {
            CarregaGridVeiculos();
        }
    }

    //Carregando Grid Pincipal
    function CarregaGridVeiculos() {
        showLoad('Carregando Informações!');

        $.ajax({
            url: "../Service/BuscaVeiculosVisitados.php",
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
                $('#_gridVeicVisit').DataTable({
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
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "searching": false,
                    "data": dados,
                    "columns": [{
                            "data": "destaque",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    if (data === 'S') {
                                        data = '<label><i style="font-size:20px;" class="icone-crown text-warning"></i></label>';
                                    } else {
                                        data = '';
                                    }

                                }

                                return data;
                            }
                        },
                        {
                            "data": "troca",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    if (data === 'S') {
                                        data = '<label><i style="font-size:20px;" class="icone-arrows-cw text-danger"></i></label>';
                                    } else {
                                        data = '';
                                    }

                                }

                                return data;
                            }
                        },
                        {
                            "data": "tipo",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    if (data === 'S') {
                                        data = '<label><i style="font-size:20px;" class="icone-hammer text-primary"></i></label>';
                                    } else if(data === 'R') {
                                        data = '<label><i style="font-size:20px;" class="icone-forward-1 text-success"></i></label>';
                                    }
                                    else if(data === 'N'){
                                        data = '<label><i style="font-size:20px;" class="icone-diamond text-info"></i></label>';
                                    }

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
                            "data": "carro",
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
                            "data": "visitas",
                            "render": function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label>' + data + '</label>';
                                }

                                return data;
                            }
                        }
                        // {
                        //     "data": "editar",
                        //     "render": function(data, type, row, meta) {
                        //         if (type === 'display') {
                        //             data = '<a  href="InsereAtualizaCarro.php?acao=editar&cod=' + data + '" class="btn btn-success"><i class="icone-forward"></i></a>';
                        //         }

                        //         return data;
                        //     }
                        // }
                    ]
                });
            }
        });

    }


    function CaregaGrafCarros() {
        debugger;
        $.ajax({
            url: "../Service/CarrosPorMes.php",
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);

                if(data[0].TransCod == 0){
                    let element = '<h4 class="display-4">Sem Registros de Veiculos no momento!</h4>';
                    $('#_grafCarros').css('display','none');
                    $('#msg-empty-vei').css('display','block');
                    $('#msg-empty-vei').append(element);
                    return;
                }

                var jsonfile = JSON.parse(data);
                console.log(jsonfile);

                var labels = jsonfile.map(function(e) {
                    return e.Mes;
                });
                var dados = jsonfile.map(function(e) {
                    return e.Qtde;
                });

                console.log(labels);
                console.log(dados);

                var ctx = $('#_grafCarros');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Carros',
                            data: dados,
                            backgroundColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        });
    }




    function CaregaGrafPub() {
        $.ajax({
            url: "../Service/PublicidadesPorMes.php",
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);
                if(data[0].TransCod == 0){
                    let element = '<h4 class="display-4">Sem Registros de Publicidade no momento!</h4>';
                    $('#_grafPub').css('display','none');
                    $('#msg-empty-pub').css('display','block');
                    $('#msg-empty-pub').append(element);
                    return;
                }

                var jsonfile = JSON.parse(data);
                console.log(jsonfile);

                var labels = jsonfile.map(function(e) {
                    return e.Mes;
                });
                var dados = jsonfile.map(function(e) {
                    return e.Qtde;
                });

                console.log(labels);
                console.log(dados);

                

                var ctx = $('#_grafPub');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Publicidades',
                            data: dados,
                            backgroundColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        });
    }


    function CaregaGrafAnun() {
        $.ajax({
            url: "../Service/AnunciosPorMes.php",
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);
                var jsonfile = JSON.parse(data);
                console.log(jsonfile);

                var labels = jsonfile.map(function(e) {
                    return e.Mes;
                });
                var dados = jsonfile.map(function(e) {
                    return e.Qtde;
                });


                console.log(labels);
                console.log(dados);
                
                var ctx = $('#_grafAnun');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Solicitações de Anuncio',
                            data: dados,
                            backgroundColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        });
    }
</script>

<?php
include_once 'footer.inc.php';
?>