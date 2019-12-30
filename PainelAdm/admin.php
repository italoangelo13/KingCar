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
$sqlusu = "SELECT count(*) as NumUsuarios FROM KGCTBLUSU WHERE MONTH(usudatcadastro) = '".$numMes."'";
$QtdeUsu = $USUARIO->SelecionarNumUsuarios($sqlusu);
$UsuariosMes = $QtdeUsu[0]->NumUsuarios;

//Buscando Qtde Carros
$sqlcar = "SELECT count(*) as NumCarros FROM KGCTBLCAR WHERE MONTH(cardatcadastro) = '".$numMes."'";
$QtdeCar = $CARRO->SelecionarNumCarros($sqlcar);
$CarrosMes = $QtdeCar[0]->NumCarros;

// //Buscando Qtde publicidades
// $sqlusu = "SELECT count(*) as NumUsuarios FROM usuario WHERE MONTH(usudatcadastro) = '".$numMes."'";
// $QtdeUsu = Select($sqlusu);
// $UsuariosMes = $QtdeUsu[0]->NumUsuarios;

// //Buscando Qtde Anuncios
// $sqlusu = "SELECT count(*) as NumUsuarios FROM usuario WHERE MONTH(usudatcadastro) = '".$numMes."'";
// $QtdeUsu = Select($sqlusu);
// $UsuariosMes = $QtdeUsu[0]->NumUsuarios;


?>

<div class="row bg-info">
            <div class="col-lg-12">
                <label class="text-white">Período: <?php echo strtoupper($mes); ?> </label>
            </div>
        </div>
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
            <div class="col-lg-12 bg-painel-dash">
                <h4 class="alert alert-warning">Ultimas Solicitações de Anuncio</h4>
                <table class="table table-stripped table-responsive" width="100%">
                    <thead class="bg-warning">
                        <tr>
                            <th>Id</th>
                            <th>Data</th>
                            <th>Anunciante</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Ano</th>
                            <th>Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>02/12/2019</td>
                            <td>Marcelo Pontes Silva</td>
                            <td>Fiat</td>
                            <td>Palio EDX</td>
                            <td>97</td>
                            <td>R$ 5.800,00</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>02/12/2019</td>
                            <td>Marcelo Pontes Silva</td>
                            <td>Fiat</td>
                            <td>Palio Weekend</td>
                            <td>09</td>
                            <td>R$ 13.500,00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

<?php
include_once 'footer.inc.php';
?>