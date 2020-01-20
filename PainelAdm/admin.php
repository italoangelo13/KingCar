<?php
include_once 'header.inc.php';
require_once('../Models/Carros.php');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

//INSTANCIANDO OBJETOS

$CARRO = new Carros();


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

$SQLCARDET = 'SELECT COUNT(*) AS QTDE FROM KGCTBLCAR
WHERE NOT EXISTS(SELECT 1 FROM KGCTBLDETCAR WHERE CARCOD = DETCODCARRO)';
$QTDEDETCAR = $CARRO->SelecionarNumCarrosDetIncompletos($SQLCARDET);
$CarrosIncomp = $QTDEDETCAR[0]->QTDE;

// //Buscando Qtde publicidades
// $sqlusu = "SELECT count(*) as NumUsuarios FROM usuario WHERE MONTH(usudatcadastro) = '".$numMes."'";
// $QtdeUsu = Select($sqlusu);
// $UsuariosMes = $QtdeUsu[0]->NumUsuarios;

// //Buscando Qtde Anuncios
// $sqlusu = "SELECT count(*) as NumUsuarios FROM usuario WHERE MONTH(usudatcadastro) = '".$numMes."'";
// $QtdeUsu = Select($sqlusu);
// $UsuariosMes = $QtdeUsu[0]->NumUsuarios;


?>
<?php
if($CarrosIncomp){
?>
<div class="row alert-warning" style="margin-top:10px;">
    <div class="col-lg-12">
        <h5><i class="icone-warning"></i> Existe <?php echo $CarrosIncomp; ?> Veiculo(s) com pendencias de cadastros, <a href="relatorioCarrosIncompletos.php">Clique Aqui</a> para Visualizar os Veiculos Inconsistentes.</h5>
    </div>
</div>
<?php } ?>
<div class="row" style="margin-top:10px;">
    <!-- Box Carros -->
    <div class="col-lg-3 " style="margin-bottom: 3px;">
        <div class="container box-dash bg-secondary">
            <div class="row">
                <div class="col-6 text-white">
                    <h6>Carros</h6>
                    <i class="fas fa-car" style="font-size:50pt;"></i>
                </div>
                <div class="col-6 text-center">
                    <label class="text-warning" style="font-size:50pt;"><?php echo $CarrosMes; ?></label>
                </div>
            </div>
        </div>
    </div>

    <!-- Box Anuncios -->
    <div class="col-lg-3 " style="margin-bottom: 3px;">
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

    <!-- Box Sol. Anuncio -->
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

    </div>

    <!-- Box Usuarios -->
    <div class="col-lg-3" style="margin-bottom: 3px;">
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
    <div class="col-lg-4" style="padding: 5px;">
        <div style="background-color: white; border-radius: 5px; padding:2px;">
            <h5 class="alert alert-primary">Carros por Mês</h5>
            <canvas id="_grafCarros" width="100%"></canvas>
        </div>
    </div>

    <div class="col-lg-4" style="padding: 5px;">
        <div style="background-color: white; border-radius: 5px; padding:2px;">
            <h5 class="alert alert-primary">Publicidades por Mês</h5>
            <canvas id="_grafPub" width="100%"></canvas>
        </div>
    </div>

    <div class="col-lg-4" style="padding: 5px;">
        <div style="background-color: white; border-radius: 5px; padding:2px;">
            <h5 class="alert alert-primary">Sol. Anuncios por Mês</h5>
            <canvas id="_grafAnun" width="100%"></canvas>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        CaregaGrafCarros();
        CaregaGrafPub();
        CaregaGrafAnun();
    });



    function CaregaGrafCarros() {
        debugger;
        $.ajax({
            url: "../service/CarrosPorMes.php",
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
        var ctx = $('#_grafPub');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Dez/19', 'Jan/20', 'Fev/20', 'Mar/20', 'Abr/20', 'Mai/20'],
                datasets: [{
                    label: 'Publicidades',
                    data: [2, 5, 17, 20, 45, 15],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
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


    function CaregaGrafAnun() {
        var ctx = $('#_grafAnun');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Dez/19', 'Jan/20', 'Fev/20', 'Mar/20', 'Abr/20', 'Mai/20'],
                datasets: [{
                    label: 'Sol. Anuncios',
                    data: [2, 5, 17, 20, 45, 15],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
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
</script>

<?php
include_once 'footer.inc.php';
?>