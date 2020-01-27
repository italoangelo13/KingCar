<?php
header("Content-type:text/html; charset=utf8");

include_once 'Config/ConexaoBD.php';
require_once 'Models/Carros.php';
require_once 'Models/Marcas.php';
require_once 'Models/Modelos.php';
require_once 'Models/Publicidades.php';

$anoAtual = date("Y");
$contador = 40;
$carro = new Carros();
$marca = new Marcas();
$modelo = new Modelos();
$pub = new Publicidades();
$listacarro = $carro->SelecionarListaCarros();
$listacarroDestaque = $carro->SelecionarListaCarrosDestaques();
$listaMarcas = $marca->SelecionarListaMarcas();
$listaPub = $pub->SelecionarListaPublicidades();
?>
<?php include 'header.inc.php'; ?>
<div class="row" style="margin-top: 10px">
    <div class="col-lg-12" style="padding: 0px;">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="assets/img/slide1.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/img/slide2.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/img/slide3.jpg" alt="Third slide">
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

<div class="row bg-dark text-white" style="margin-top: 10px; padding:5px; padding-bottom:15px">
    <div class="col-lg-12 text-warning">
        <h4>Procurando por um modelo específico?</h4>
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
<?php if($listacarroDestaque){ ?>
<div class="row bg-dark" style="padding:5px; margin-top:10px;">
    <div class="col-lg-12 text-warning">
        <h3><small><i class="icone-crown"></i></small> DESTAQUES KING CAR</h3>
    </div>
</div>

<div class="row" style="padding:5px; margin-top:10px;">
    <div class="col-lg-12" style="padding: 0px;">
        <div id="slideDestaques" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $cont = 0;
                foreach ($listacarroDestaque as $destaque) {
                    if ($cont == 0) {
                ?>
                        <div class="carousel-item active">
                            <div class="container-fluid">
                                <div class="row bg-warning" style="padding:5px;">
                                    <div class="col-lg-4">
                                        <img class="card-img-top img-thumbnail" style="width: 100%; height:300px;" src="assets/img/Carros/<?php echo $destaque->CARFOTO; ?>" alt="<?php echo strtoupper(utf8_encode($destaque->CARNOME)); ?>" title="<?php echo strtoupper(utf8_encode($destaque->CARNOME)); ?>">
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h3 class="alert bg-dark text-warning text-center"><?php echo "#" . strtoupper(utf8_encode($destaque->CARCOD)) . " - " . strtoupper(utf8_encode($destaque->MARDESCRICAO)) . " " . strtoupper(utf8_encode($destaque->MODDESCRICAO)) . " " . strtoupper(utf8_encode($destaque->CARANO)) . " " . strtoupper(utf8_encode($destaque->COMDESCRICAO)); ?></h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Marca</h6>
                                                    <label class="text-dark"> <?php echo strtoupper(utf8_encode($destaque->MARDESCRICAO)); ?></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Modelo</h6>
                                                    <label class="text-dark"><?php echo strtoupper(utf8_encode($destaque->MODDESCRICAO)); ?></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Cor</h6>
                                                    <label class="text-dark"> <?php echo strtoupper(utf8_encode($destaque->CORDESCRICAO)); ?></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Portas</h6>
                                                    <label class="text-dark"><?php echo strtoupper(utf8_encode($destaque->CARPORTAS)); ?> Portas</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Ano</h6>
                                                    <label class="text-dark"> <?php echo strtoupper(utf8_encode($destaque->CARANO)); ?></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Localização</h6>
                                                    <label class="text-dark"><?php echo strtoupper(utf8_encode($destaque->LOCALIZACAO)); ?></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Quilometragem</h6>
                                                    <label class="text-dark"> <?php echo FormatarValorDecimal(strtoupper(utf8_encode($destaque->CARKM))); ?> KM</label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Combustivel</h6>
                                                    <label class="text-dark"><?php echo strtoupper(utf8_encode($destaque->COMDESCRICAO)); ?></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <br>
                                                    <a class="btn btn-primary btn-block" href="DetCarro.php?id=<?php echo $destaque->CARCOD; ?>"><i class="icone-doc"></i> Detalhes do Veiculo</a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <h6 class="text-dark">Preço</h6>
                                                    <h1 class="text-danger"><?php echo "R$ " . FormatarMoeda($destaque->CARPRECO); ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        $cont++;
                    } else {
                    ?>
                        <div class="carousel-item">
                            <div class="container-fluid">
                                <div class="row bg-warning" style="padding:5px;">
                                    <div class="col-lg-4">
                                        <img class="card-img-top img-thumbnail" style="width: 100%; height:300px;" src="assets/img/Carros/<?php echo $destaque->CARFOTO; ?>" alt="<?php echo strtoupper(utf8_encode($destaque->CARNOME)); ?>" title="<?php echo strtoupper(utf8_encode($destaque->CARNOME)); ?>">
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h3 class="alert bg-dark text-warning text-center"><?php echo "#" . strtoupper(utf8_encode($destaque->CARCOD)) . " - " . strtoupper(utf8_encode($destaque->MARDESCRICAO)) . " " . strtoupper(utf8_encode($destaque->MODDESCRICAO)) . " " . strtoupper(utf8_encode($destaque->CARANO)) . " " . strtoupper(utf8_encode($destaque->COMDESCRICAO)); ?></h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Marca</h6>
                                                    <label class="text-dark"> <?php echo strtoupper(utf8_encode($destaque->MARDESCRICAO)); ?></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Modelo</h6>
                                                    <label class="text-dark"><?php echo strtoupper(utf8_encode($destaque->MODDESCRICAO)); ?></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Cor</h6>
                                                    <label class="text-dark"> <?php echo strtoupper(utf8_encode($destaque->CORDESCRICAO)); ?></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Portas</h6>
                                                    <label class="text-dark"><?php echo strtoupper(utf8_encode($destaque->CARPORTAS)); ?> Portas</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Ano</h6>
                                                    <label class="text-dark"> <?php echo strtoupper(utf8_encode($destaque->CARANO)); ?></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Localização</h6>
                                                    <label class="text-dark"><?php echo strtoupper(utf8_encode($destaque->LOCALIZACAO)); ?></label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Quilometragem</h6>
                                                    <label class="text-dark"> <?php echo FormatarValorDecimal(strtoupper(utf8_encode($destaque->CARKM))); ?> KM</label>
                                                </div>

                                                <div class="col-lg-3">
                                                    <h6 class="text-dark">Combustivel</h6>
                                                    <label class="text-dark"><?php echo strtoupper(utf8_encode($destaque->COMDESCRICAO)); ?></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <br>
                                                    <a class="btn btn-primary btn-block" href="DetCarro.php?id=<?php echo $destaque->CARCOD; ?>"><i class="icone-doc"></i> Detalhes do Veiculo</a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <h6 class="text-dark">Preço</h6>
                                                    <h1 class="text-danger"><?php echo "R$ " . FormatarMoeda($destaque->CARPRECO); ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#slideDestaques" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#slideDestaques" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
<?php } ?>
<div class="row bg-dark" style="padding:5px; margin-top:10px;">
    <div class="col-lg-12 text-warning">
        <h3><small><i class="icone-crown"></i></small> Os Carros mais visitados</h3>
    </div>
</div>
<?php if($listaPub){ ?>
<div class="row bg-dark" style="margin-top: 5px">
    <section class="col-lg-10">
        <div class="container-fluid">
            <div class="row" style="padding: 10px;">
                <?php if ($listacarro) : ?>
                    <?php foreach ($listacarro as $carros) : ?>
                        <div class="col-lg-4" style="padding-top: 10px; padding-bottom: 10px;">
                            <div class="card bg-light" style="width: 100%; padding: 5px;">

                                <img class="card-img-top" style="width: 100%; height: 260px" src="assets/img/Carros/<?php echo $carros->CARFOTO; ?>" title="<?php echo strtoupper(utf8_encode($carros->CARNOME)); ?>" alt="<?php echo utf8_encode($carros->CARNOME); ?>">

                                <div class="card-title bg-dark" style="padding-left:5px; margin:0px;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h6 class="text-white"><?php echo "#" . strtoupper(utf8_encode($carros->CARCOD)) . " - " . strtoupper(utf8_encode($carros->MARDESCRICAO)) . " " . strtoupper(utf8_encode($carros->MODDESCRICAO)) . " " . strtoupper(utf8_encode($carros->CARANO)) . " " . strtoupper(utf8_encode($carros->COMDESCRICAO)); ?></h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body " style="width: 100%">

                                    <p class="card-text" style="margin:0px">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <i class="fas fa-gas-pump"></i> <?php echo $carros->COMDESCRICAO; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <i class="fas fa-car-side"></i> <?php echo $carros->CORDESCRICAO; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <i class="fas fa-tachometer-alt"></i> <?php echo FormatarValorDecimal($carros->CARKM) . " km"; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
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
                                    <a href="DetCarro.php?id=<?php echo $carros->CARCOD; ?>" class="btn btn-primary btn-block"><i class="icone-doc"></i> Detalhes do Veiculo</a>
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
    <section class="col-lg-2" style="border-left: 2px whitesmoke solid;">
        <div class="container-fluid">
            <div class="row bg-warning text-center" style="margin-top: 15px;">
                <div class="col-lg-12">
                    <h6>Nossos Parceiros</h6>
                </div>
            </div>
            <?php foreach($listaPub as $pub){ ?>
            <div class="row" style="margin-top: 15px;">
                <div class="col-lg-12">
                    <a href="<?php echo $pub->PUBLINK;?>" target="_blank">
                        <img style="width: 100%" src="assets/img/Pub/<?php echo $pub->PUBIMG;?> " alt="Publicidade" title="<?php echo $pub->PUBLINK;?>" >
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>

    </section>
</div>
<?php }
else{ ?>
    <div class="row bg-dark" style="margin-top: 5px">
    <section class="col-lg-12">
        <div class="container-fluid">
            <div class="row" style="padding: 10px;">
                <?php if ($listacarro) : ?>
                    <?php foreach ($listacarro as $carros) : ?>
                        <div class="col-lg-4" style="padding-top: 10px; padding-bottom: 10px;">
                            <div class="card bg-light" style="width: 100%; padding: 5px;">

                                <img class="card-img-top" style="width: 391px; height: 260px" src="assets/img/Carros/<?php echo $carros->CARFOTO; ?>" title="<?php echo strtoupper(utf8_encode($carros->CARNOME)); ?>" alt="<?php echo utf8_encode($carros->CARNOME); ?>">

                                <div class="card-title bg-dark" style="padding-left:5px; margin:0px;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h6 class="text-white"><?php echo "#" . strtoupper(utf8_encode($carros->CARCOD)) . " - " . strtoupper(utf8_encode($carros->MARDESCRICAO)) . " " . strtoupper(utf8_encode($carros->MODDESCRICAO)) . " " . strtoupper(utf8_encode($carros->CARANO)) . " " . strtoupper(utf8_encode($carros->COMDESCRICAO)); ?></h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body " style="width: 100%">

                                    <p class="card-text" style="margin:0px">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <i class="fas fa-gas-pump"></i> <?php echo $carros->COMDESCRICAO; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <i class="fas fa-car-side"></i> <?php echo $carros->CORDESCRICAO; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <i class="fas fa-tachometer-alt"></i> <?php echo FormatarValorDecimal($carros->CARKM) . " km"; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
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
                                    <a href="DetCarro.php?id=<?php echo $carros->CARCOD; ?>" class="btn btn-primary btn-block"><i class="icone-doc"></i> Detalhes do Veiculo</a>
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
</div>
<?php
} ?>
<?php include 'footer.inc.php'; ?>