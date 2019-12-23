<?php
header("Content-type:text/html; charset=utf8");

include_once 'Config/ConexaoBD.php';
require_once 'Models/Carros.php';
require_once 'Models/Marcas.php';
require_once 'Models/Modelos.php';

$anoAtual = date("Y");
$contador = 40;
$carro = new Carros();
$marca = new Marcas();
$modelo = new Modelos();
$listacarro = $carro->SelecionarListaCarros();
$listaMarcas = $marca->SelecionarListaMarcas();
?>
<?php include 'header.inc.php'; ?>
<div class="row" style="margin-top: 10px">
    <div class="col-lg-12" style="padding: 0px;">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="img/slide1.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/slide2.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/slide3.jpg" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

<div class="row bg-secondary text-white" style="margin-top: 10px; padding:5px; padding-bottom:15px">
    <div class="col-lg-12">
        <h4>Busque por um modelo específico!</h4>
        <hr>
    </div>
    <div class="col-lg-4">
        <label for="Sel_Marca_Codigo">Marca</label>
        <select class="form-control form-control" id="_ddlMarca">
            <option value="0" selected="true">Selecionar</option>
            <?php if ($listaMarcas) : ?>
                <?php foreach ($listaMarcas as $marca) : ?>
                    <option value="<?php echo $marca->MARCOD; ?>"><?php echo $marca->MARDESCRICAO; ?></option>
                <?php endforeach; ?>
                <!-- <?php else : ?>
                <option value="0" selected>Selecionar</option>
            <?php endif; ?> -->
        </select>
    </div>
    <div class="col-lg-4">
        <label for="Sel_Mod_Codigo">Modelo</label>
        <select class="form-control form-control" id="_ddlModelo">
            <option value="0" selected="true">Selecionar</option>
        </select>
    </div>
    <div class="col-lg-2">
        <label for="Sel_Ano_Codigo">Ano</label>
        <select class="form-control form-control">
            <option value="0" selected>Selecionar</option>
            <?php for ($i = 0; $i <= $contador; $i++) : ?>
                <?php $anoitem = $anoAtual - $i; ?>
                <option value="<?php echo $anoitem; ?> "><?php echo $anoitem; ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="col-lg-2">
        <br>
        <button type="submit" class="btn btn-success">Buscar</button>
    </div>
</div>
</div>

<div class="row bg-secondary" style="padding:5px; margin-top:10px;">
    <div class="col-lg-12 text-warning bg-light">
        <h3><small><i class="icone-crown"></i></small> Top 10 mais visitados</h3>
    </div>
</div>

<div class="row bg-secondary" style="margin-top: 0px">
    <section class="col-lg-10">
        <div class="container-fluid">
            <div class="row" style="padding: 10px;">
                <?php if ($listacarro) : ?>
                    <?php foreach ($listacarro as $carros) : ?>
                        <div class="col-lg-4" style="padding-top: 10px; padding-bottom: 10px;">
                            <div class="card" style="width: 100%;">
                                <?php if ($carros->CARDESTAQUE == 'N') : ?>
                                    <div class="card-title text-secondary" style="padding-left:5px; margin:0px;">
                                        <h6><?php echo strtoupper(utf8_encode($carros->CARNOME)); ?></h6>
                                    </div>
                                <?php else : ?>
                                    <div class="card-title" style="padding-left:5px; margin:0px;">
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <h6 class="text-secondary"><?php echo strtoupper(utf8_encode($carros->CARNOME)); ?></h6>
                                            </div>
                                            <div class="col-lg-2"><i class="icone-crown text-warning"></i></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <img class="card-img-top" src="img/<?php echo $carros->CARFOTO; ?>" title="<?php echo strtoupper(utf8_encode($carros->CARNOME)); ?>" alt="<?php echo utf8_encode($carros->CARNOME); ?>">
                                <div class="card-body bg-light" style="width: 100%">

                                    <p class="card-text" style="margin:0px">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <i class="fas fa-gas-pump"></i> <?php echo $carros->COMDESCRICAO; ?>
                                                </div>
                                                <div class="col-lg-6">
                                                    <i class="fas fa-car-side"></i> <?php echo $carros->CORDESCRICAO; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <i class="fas fa-tachometer-alt"></i> <?php echo FormatarValorDecimal($carros->CARKM) . " km"; ?>
                                                </div>
                                                <div class="col-lg-6">
                                                    <i class="fas fa-map-marker-alt"></i> <?php echo utf8_encode($carros->mundescricao) . " - " . $carros->munuf; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h3 class="text-danger text-center"><?php echo "R$ " . FormatarMoeda($carros->CARPRECO); ?></h3>
                                                </div>

                                            </div>
                                        </div>
                                    </p>
                                    <a href="detalhescarro.php?id=<?php echo $carros->CARCOD; ?>" class="btn btn-primary btn-block">Quero Este Carro</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-lg-12">
                        <h4 class="alert alert-warning">Nenhum Automovel encontrado!</h4>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>
    <section class="col-lg-2">

    </section>
</div>
<?php include 'footer.inc.php'; ?>