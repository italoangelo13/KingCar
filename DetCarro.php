<?php
header("Content-type:text/html; charset=utf8");

include_once 'Config/ConexaoBD.php';
require_once 'Config/Util.php';
require_once 'Models/Carros.php';
require_once 'Models/Publicidades.php';
require_once 'Models/Compra.php';
$carro = new Carros();
$util = new Util();
$pub = new Publicidades();
$compra = new Compra();
$codCarro = null;

if (isset($_POST['compra'])) {
    echo "<script>showLoad('Aguarde <br> Estamos Enviando a sua solicitação.');</script> ";
    $codCarro = $_POST['codCarro'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $telefone = $util->FormatarTelefone($telefone);
    $mensagem = $_POST['mensagem'];

    if ($compra->CadastraSolicitacaoCompra($codCarro, $nome, $email, $telefone, $mensagem)) {
        echo "<script>SuccessBox('Solicitação Enviada com Sucesso.');</script>";
        echo "<script>hideLoad();</script>";
    } else {
        echo "<script>hideLoad();</script>";
        echo "<script>ErrorBox('Ocorreu um erro ao Enviar a Sua Solicitação.');</script>";
    }
}

if (!isset($_GET['id'])) {
    header("Location:index.php");
} else {
    $codCarro = $_GET['id'];
    if (!$carro->UtualizaNumVisitas($codCarro)) {
        $msg = "Quantidade não Atualizada.";
    }
}




$Carro = $carro->SelecionarCarro($codCarro);
$Detcarro = $carro->SelecionarDetCarro($codCarro);
$InfoComp = $util->SelecionarInformaçõesComplementares();
$listaPub = $pub->SelecionarListaPublicidades();

?>

<?php include 'header.inc.php'; ?>

<div class="row bg-dark" style="margin-top: 5px; padding:5px;">
    <div class="col-lg-4">
        <img class="img-thumbnail" src="assets/img/Carros/<?php echo $Carro[0]->CARFOTO; ?>" alt="Capa do Anuncio">
    </div>
    <div class="col-lg-8 ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 text-center text-lg-right" style="margin-top: 25px;">
                    <div>
                        <?php if ($Carro[0]->CARDESTAQUE == "S") { ?>
                            <label title="Veículo Destaque" class="text-warning" style="font-weight: 700"><i class="icone-crown"></i></label>
                        <?php } ?>

                        <?php if ($Carro[0]->CARTROCA == "S") { ?>
                            <label title="Aceita Troca" class="text-danger" style="font-weight: 700"><i class="icone-arrows-cw"></i></label>
                        <?php } ?>

                        <?php if ($Carro[0]->CARTIPOANUNCIO == "N") { ?>
                            <label title="Novo/Semi-Novo" class="text-info" style="font-weight: 700"><i class="icone-diamond"></i></label>
                        <?php } else if ($Carro[0]->CARTIPOANUNCIO == "R") { ?>
                            <label title="Veículo para Repasse" class="text-success" style="font-weight: 700"><i class="icone-forward-1"></i></label>
                        <?php } else if ($Carro[0]->CARTIPOANUNCIO == "S") { ?>
                            <label title="Veículo Sinistrado/Recuperado" class="text-primary" style="font-weight: 700"><i class="icone-hammer"></i></label>
                        <?php } ?>
                    </div>
                    <h3 class=" text-white" style="font-weight: 600; font-size: 42pt;"><label for="" class="text-warning"><?php echo strtoupper(utf8_encode($Carro[0]->MARDESCRICAO)); ?></label> <?php echo " " . strtoupper(utf8_encode($Carro[0]->MODDESCRICAO)) ?></h3>
                    <h4 class="display-6 text-warning"><?php echo $Carro[0]->VERNOME; ?></h4>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-warning text-center display-5 text-lg-right" style="font-weight: 600"><?php echo "R$ " . FormatarMoeda(strtoupper(utf8_encode($Carro[0]->CARPRECO))); ?></h1>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="row" style="margin-top: 5px; padding:5px;">
    <section class="col-lg-8" style="padding: 5px;">
        <!-- Dados do Veiculo -->
        <div class="container-fluid bg-dark" style="padding: 20px; border-radius: 5px; ">
            <div class="row" style="margin-top: 5px;">
                <div class="text-warning col-lg-12 display-6">
                    Dados do Veículo
                </div>
            </div>
            <hr>
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-3 col-xs-6 text-warning text-center text-lg-left" style="font-weight: 600;">
                    <label for="" style="font-size: 10pt; margin:0px; padding:0px;">Ano</label>
                    <br />
                    <label for="" style="font-size: 15pt;"><?php echo strtoupper(utf8_encode($Carro[0]->CARANO)); ?></label>
                </div>

                <div class="col-lg-3 col-xs-6 text-warning text-center text-lg-left" style="font-weight: 600;">
                    <label for="" style="font-size: 10pt; margin:0px; padding:0px;">KM</label>
                    <br />
                    <label for="" style="font-size: 15pt;"><?php echo FormatarValorDecimal(strtoupper(utf8_encode($Carro[0]->CARKM))); ?></label>
                </div>

                <div class="col-lg-3 col-xs-6 text-warning text-center text-lg-left" style="font-weight: 600;">
                    <label for="" style="font-size: 10pt; margin:0px; padding:0px;">Câmbio</label>
                    <br />
                    <label for="" style="font-size: 15pt;"><?php echo strtoupper(utf8_encode($Carro[0]->CAMDESCRICAO)); ?></label>
                </div>

                <div class="col-lg-3 col-xs-6 text-warning text-center text-lg-left" style="font-weight: 600;">
                    <label for="" style="font-size: 10pt; margin:0px; padding:0px;">Carroceria</label>
                    <br />
                    <label for="" style="font-size: 15pt;"><?php echo strtoupper(utf8_encode($Carro[0]->CRCDESCRICAO)); ?></label>
                </div>
            </div>

            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-3 col-xs-6 text-warning text-center text-lg-left" style="font-weight: 600;">
                    <label for="" style="font-size: 10pt; margin:0px; padding:0px;">Portas</label>
                    <br />
                    <label for="" style="font-size: 15pt;"><?php echo strtoupper(utf8_encode($Carro[0]->CARPORTAS)); ?></label>
                </div>

                <div class="col-lg-3 col-xs-6 text-warning text-center text-lg-left" style="font-weight: 600;">
                    <label for="" style="font-size: 10pt; margin:0px; padding:0px;">Combustivel</label>
                    <br />
                    <label for="" style="font-size: 15pt;"><?php echo strtoupper(utf8_encode($Carro[0]->COMDESCRICAO)); ?></label>
                </div>

                <div class="col-lg-3 col-xs-6 text-warning text-center text-lg-left" style="font-weight: 600;">
                    <label for="" style="font-size: 10pt; margin:0px; padding:0px;">Cor</label>
                    <br />
                    <label for="" style="font-size: 15pt;"><?php echo strtoupper(utf8_encode($Carro[0]->CORDESCRICAO)); ?></label>
                </div>

                <div class="col-lg-3 col-xs-6 text-warning text-center text-lg-left" style="font-weight: 600;">
                    <label for="" style="font-size: 10pt; margin:0px; padding:0px;">Motor</label>
                    <br />
                    <label for="" style="font-size: 15pt;"><?php echo strtoupper(utf8_encode($Carro[0]->MOTPOTENCIA)); ?></label>
                </div>
            </div>

            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-3 col-xs-6 text-warning text-center text-lg-left" style="font-weight: 600;">
                    <label for="" style="font-size: 10pt; margin:0px; padding:0px;">Valvulas</label>
                    <br />
                    <label for="" style="font-size: 15pt;"><?php echo strtoupper(utf8_encode($Carro[0]->CARVALVULAS)); ?></label>
                </div>

                <div class="col-lg-3 col-xs-6 text-warning text-center text-lg-left" style="font-weight: 600;">
                    <label for="" style="font-size: 10pt; margin:0px; padding:0px;">Localização</label>
                    <br />
                    <label for="" style="font-size: 15pt;"><?php echo strtoupper(utf8_encode($Carro[0]->LOCALIZACAO)); ?></label>
                </div>
            </div>
        </div>



        <!-- Itens do Veiculo -->
        <?php if ($Detcarro) { ?>
            <div class="container-fluid bg-dark" style="padding: 20px; border-radius: 5px; margin-top: 10px;">
                <div class="row" style="margin-top: 5px;">
                    <div class="text-warning col-lg-12 display-6">
                        Itens do Veículo
                    </div>
                </div>
                <hr>
                <div class="row" style="margin-top: 15px;">
                    <?php foreach ($Detcarro as $d) { ?>
                        <div class="col-lg-3 col-xs-6 text-warning text-center text-lg-left" style="font-weight: 600;margin-top: 15px;">
                            <label for="" style="font-size: 12pt;"><?php echo strtoupper(utf8_encode($d['COMPDESC'])); ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="container-fluid bg-dark" style="padding: 20px; border-radius: 5px; ">
                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12 text-warning text-center text-lg-left" style="font-weight: 600;">
                        <label for="" class="text-warning display-5 text-center">
                            Este veículo não possui itens cadastrados!
                        </label>
                    </div>
                </div>
            </div>
        <?php } ?>


        <?php if ($Carro) {
            if ($Carro[0]->CARINFOAD) { ?>
                <div class="container-fluid bg-dark" style="padding: 20px; border-radius: 5px; margin-top: 15px;;">
                    <div class="row" style="margin-top: 5px;">
                        <div class="text-warning col-lg-12 display-6">
                            Informações Adicionais
                        </div>
                    </div>
                    <hr>
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-lg-12 text-warning text-center text-lg-left" style="font-weight: 600;">
                            <label for="" class="text-warning text-left">
                               <?php echo $util->convert_from_latin1_to_utf8_recursively($Carro[0]->CARINFOAD); ?>
                            </label>
                        </div>
                    </div>
                </div>
        <?php
            }
        } ?>




        <!-- Anunciante do Veiculo -->
        <div class="container-fluid bg-dark" style="padding: 20px; border-radius: 5px; margin-top: 10px;">
            <div class="row" style="margin-top: 5px;">
                <div class="text-warning col-lg-12 ">
                    <h6 style="font-size: 10pt;">Este Veiculo foi anunciado por</h6>
                    <h6 class="display-5"><?php echo $Carro[0]->CARNOMEANUNCIANTE; ?></h6>
                    <h6 style="font-size: 10pt;">no dia <?php
                                                        $date = new DateTime($Carro[0]->CARDATCADASTRO);
                                                        $data = date_format($date, 'd/m/Y');
                                                        $hora = date_format($date, 'H:i');
                                                        $dataEnvio = $data . ' ás ' . $hora;
                                                        echo $dataEnvio; ?>
                    </h6>
                </div>
            </div>
        </div>

    </section>
    <aside class="col-lg-4" style="padding: 5px;">
        <div class="container-fluid bg-dark" style="padding: 10px; border-radius: 5px; ">
            <form action="" method="post">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="text-warning text-center display-6">Entre em contato com o Anunciante!</label>
                    </div>
                </div>
                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <input type="hidden" name="codCarro" value="<?php echo $codCarro; ?>">
                        <input class="form-control form-control-lg" required type="text" maxlength="255" name="nome" placeholder="Nome" id="_edNome">
                    </div>
                </div>
                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <input class="form-control form-control-lg" required type="email" name="email" maxlength="255" placeholder="Email" id="_edEmail">
                    </div>
                </div>
                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <input class="form-control form-control-lg" onkeyup="Mascara(this,Telefone)" required type="tel" maxlength="15" name="telefone" placeholder="Telefone" id="_edTelefone">
                    </div>
                </div>
                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <textarea class="form-control form-control-lg" required placeholder="Mensagem" name="mensagem" maxlength="500" id="_edMensagem" style="width: 100%" rows="10"></textarea>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <button type="submit" name="compra" class="btn btn-success btn-block btn-lg"><i class="icone-email"></i> Enviar</button>
                    </div>
                </div>
            </form>

        </div>
    </aside>
</div>


<div class="row bg-dark" style="margin-top: 5px; padding: 5px;">
    <div class="col-lg-12">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 bg-warning" style="margin-bottom: 5px;">
                    <h3 class="text-dark">Fotos</h3>
                </div>
            </div>
            <?php if ($codCarro) { ?>
                <div id="gallery" class="row">
                    <?php
                    $dir = 'assets/img/Carros/' . $codCarro;
                    if (!is_dir($dir)) {
                        mkdir($dir);
                    }

                    $files = scandir($dir, 1);
                    if (count($files) > 2) {
                        foreach ($files as $f) {
                            if ($f != '.' && $f != '..') { ?>
                                <a class="col-lg-2" href="<?php echo $dir . '/' . $f; ?>" style="margin-top: 25px;">
                                    <img class="card-img-top" style="width: 100%; border-radius: 2px;" src="<?php echo $dir . '/' . $f; ?>" title="<?php echo  $f; ?>" alt="<?php echo utf8_encode($f); ?>">
                                </a>
                        <?php
                            }
                        }
                    } else { ?>
                        <div class="col-lg-12">
                            <h4 class="alert alert-warning">Nenhuma Foto Encontrada.</h4>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="alert alert-warning">Nenhuma Foto Encontrada.</h4>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


</div>

<div class="row bg-dark" style="margin-top: 15px; padding:5px;">
    <div class="col-lg-12 display-6 text-warning" style="margin-bottom: 5px; padding:5px;">
        Legendas
    </div>
    <div class="col-lg-2">
        <label for="" class="text-warning">
            <i class="icone-crown"></i> Destaque
        </label>
    </div>
    <div class="col-lg-2">
        <label for="" class="text-danger">
            <i class="icone-arrows-cw"></i> Aceita Troca
        </label>
    </div>
    <div class="col-lg-2">
        <label for="" class="text-info">
            <i class="icone-diamond"></i> Novo/Semi-novo
        </label>
    </div>
    <div class="col-lg-2">
        <label for="" class="text-success">
            <i class="icone-forward-1"></i> Repasse
        </label>
    </div>
    <div class="col-lg-2">
        <label for="" class="text-primary">
            <i class="icone-hammer"></i> Sinistrado/Recuperado
        </label>
    </div>
</div>


<script>
    $(document).ready(function() {
        $("#gallery").lightGallery();
    });
</script>
<?php include 'footer.inc.php'; ?>