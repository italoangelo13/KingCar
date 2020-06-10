<?php
header("Content-type:text/html; charset=utf8");

include_once 'Config/ConexaoBD.php';
include_once 'Config/Util.php';
require_once 'Models/Carros.php';
require_once 'Models/Publicidades.php';
require_once 'Models/Marcas.php';
require_once 'Models/Modelos.php';
require_once 'Models/Combustiveis.php';
require_once 'Models/Cambios.php';
require_once 'Models/Cores.php';

$anoAtual = date("Y");
$contador = 80;
$anoMin = $anoAtual - $contador;
$util = new Util();
$carro = new Carros();
$pub = new Publicidades();
$marca = new Marcas();
$modelo = new Modelos();
$cambio = new Cambios();
$combustivel = new Combustiveis();
$cor = new Cores();

$precoMinMax = $carro->SelecionarPrecoMinMax();
$listaMarcas = $marca->SelecionarListaMarcas();
$listacarro = null;
$listaPub = $pub->SelecionarListaPublicidades();
$listacambio = $cambio->SelecionarListaCambio();
$listacombus = $combustivel->SelecionarListaCombustivel();
$listaCor =    $cor->SelecionarListaCores();
$listaModelo = null;

if (isset($_GET['pesquisa'])) {
    if($_GET['_edcodCarro']){
        $vxvfCod = $_GET['_edcodCarro'];
        $listacarro = $carro->SelecionaCarroRepassePorCod($vxvfCod);
    }
    else{
        $sql = "SELECT CONCAT('#',CARCOD,' - ',MODDESCRICAO,' ',CARANO) AS CARNOME,CARCOD,MARDESCRICAO,MODDESCRICAO,CARPRECO,CARANO,CARFOTO,CARKM,CARPORTAS,CARTROCA,CARDESTAQUE,CAMDESCRICAO, COMDESCRICAO,CORDESCRICAO,CORCODHEXADECIMAL,CONCAT(mundescricao,' - ',munuf) AS LOCALIZACAO
        FROM kgctblCAR
        INNER JOIN kgctblmar ON CARCODMARCA = MARCOD
        INNER JOIN kgctblMOD ON CARCODMODELO = MODCOD
        inner join kgctblmun on carcodmunicipio = muncodigoibge
        INNER JOIN kgctblCOR ON CARCODCOR = CORCOD
        INNER JOIN kgctblcom ON CARCODCOMBUSTIVEL = comCOD
        INNER JOIN kgctblCAM ON CARCODCAMBIO = CAMCOD
        WHERE 1 = 1 and CARTIPOANUNCIO = 'R'  ";
        $vxvfMarcas = null;
        $vxvfModelos = null;
        $vxvfAno = null;
        $vxvfPreco = null;
        $vxvfCambios = null;
        $vxvfCombustiveis = null;
        $vxvfCores = null;

        $filtroMarcas = 'AND MARCOD IN (';
        $filtroModelo = 'AND MODCOD IN (';
        $filtroAno = ' and CARANO BETWEEN ';
        $filtroPreco = ' and CARPRECO BETWEEN ';
        $filtroCambio = 'AND CAMCOD IN (';
        $filtroCombustiveis = 'AND COMCOD IN (';
        $filtroCores = 'AND CORCOD IN (';
        $SqlModelo = 'SELECT MODCOD, MODDESCRICAO FROM KGCTBLMOD WHERE MODCODMARCA IN ';


        if(isset($_GET['marca'])){
            $vxvfMarcas = $_GET['marca'];
            $valMarcas = '(';
            foreach ($vxvfMarcas as $marca) {
                $filtroMarcas .= ' '.$marca.',';
                $valMarcas .= ' '.$marca.',';
            }

            $filtroMarcas .= ')';
            $valMarcas .= ')';

            $filtroMarcas = str_replace(',)',')',$filtroMarcas);
            $sql .= $filtroMarcas;

            $valMarcas = str_replace(',)',')',$valMarcas);

            $SqlModelo .= $valMarcas . ' ORDER BY MODDESCRICAO ASC';
            $listaModelo = $modelo->SelecionarListaModelosPorVariasMarca($SqlModelo);
        }

        if(isset($_GET['modelo'])){
            $vxvfModelos = $_GET['modelo'];
            foreach ($vxvfModelos as $modelo) {
                $filtroModelo .= ' '.$modelo.',';
            }
            $filtroModelo .= ')';
            $filtroModelo = str_replace(',)',')',$filtroModelo);
            $sql .= $filtroModelo;
        }

        if(isset($_GET['cambio'])){
            $vxvfCambios = $_GET['cambio'];
            foreach ($vxvfCambios as $cambio) {
                $filtroCambio .= ' '.$cambio.',';
            }
            $filtroCambio .= ')';
            $filtroCambio = str_replace(',)',')',$filtroCambio);
            $sql .= $filtroCambio;
        }

        if(isset($_GET['combustivel'])){
            $vxvfCombustiveis = $_GET['combustivel'];
            foreach ($vxvfCombustiveis as $comb) {
                $filtroCombustiveis .= ' '.$comb.',';
            }
            $filtroCombustiveis .= ')';
            $filtroCombustiveis = str_replace(',)',')',$filtroCombustiveis);
            $sql .= $filtroCombustiveis;
        }

        if(isset($_GET['cor'])){
            $vxvfCores = $_GET['cor'];
            foreach ($vxvfCores as $cor) {
                $filtroCores .= ' '.$cor.',';
            }
            $filtroCores .= ')';
            $filtroCores = str_replace(',)',')',$filtroCores);
            $sql .= $filtroCores;
        }

        if(isset($_GET['ano'])){
            $vxvfAno = $_GET['ano'];
            $vxvfAno = explode('-',$vxvfAno);
            $filtroAno .= $vxvfAno[0]. ' AND '. $vxvfAno[1];
            $sql .= $filtroAno;
        }

        if(isset($_GET['preco'])){
            $vxvfPreco = $_GET['preco'];
            $vxvfPreco = explode('-',$vxvfPreco);
            $filtroPreco .= $vxvfPreco[0]. ' AND '. $vxvfPreco[1];
            $sql .= $filtroPreco;
        }

        $listacarro =  $carro->SelecionarListaCarrosFiltroPaginado($sql);
    }
    
}
else{
    $listacarro =  $carro->SelecionarListaCarrosCompletoRepasse();
}

include 'header.inc.php';
?>
<div class="row" style="margin-top: 5px; background: url('assets/img/bg-Titulos.png') center;">
    <div class="col-lg-12 text-center text-lg-left">
        <label class="text-warning display-4">Veículos Para Repasse</label>
    </div>
</div>

<div class="row" style="margin-top: 5px;">
<?php if($listaPub){ ?>
    <aside class="col-lg-2 bg-warning" style="padding: 3px;">
        <form action="pesqRepasse.php" method="GET">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 text-warning">
                        <button class="btn btn-dark btn-block" name="pesquisa" type="submit"> <i class="icone-filter-1"></i> Filtrar Pesquisa</button>
                    </div>
                </div>
                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12 text-dark">
                        <input placeholder="Codigo do Veículo" class="form-control form-control-sm" type="text" name="_edcodCarro" id="_edcodCarro">
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Marcas</h6>
                    </div>
                    <div class="col-lg-12 text-dark box-pesquisa">
                        <?php
                        if ($listaMarcas) {
                            foreach ($listaMarcas as $lMarca) {
                        ?>
                                <input type="checkbox" name="marca[]" id="_ckMarca-<?php echo $lMarca->MARCOD; ?>" value="<?php echo $lMarca->MARCOD; ?>"> <label for="_ckMarca-<?php echo $lMarca->MARCOD; ?>"><?php echo $lMarca->MARDESCRICAO; ?></label> <br>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Modelos</h6>
                    </div>
                    <div class="col-lg-12 text-dark box-pesquisa">
                        <?php
                        if ($listaModelo) {
                            foreach ($listaModelo as $lMod) {
                        ?>
                                <input type="checkbox" name="modelo[]" id="_ckModelo-<?php echo $lMod->MODCOD; ?>" value="<?php echo $lMod->MODCOD; ?>"><label for="_ckModelo-<?php echo $lMod->MODCOD; ?>"><?php echo $lMod->MODDESCRICAO; ?></label> <br>
                            <?php
                            }
                        } else {
                            ?>
                            <label style="font-size: 10pt;" for="">Nenhuma Marca Selecionada.</label>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Ano</h6>
                    </div>
                    <div class="col-lg-12">
                        <input type="text" name="ano" id="_lblAno" readonly class="form-control bg-warning text-dark" style="border: 0px; font-weight: 500;">
                    </div>
                    <div class="col-lg-12">
                        <div id="slider-ano"></div>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Cambio</h6>
                    </div>
                    <div class="col-lg-12 text-dark box-pesquisa">
                        <?php
                        if ($listacambio) {
                            foreach ($listacambio as $lCambio) {
                        ?>
                                <input type="checkbox" name="cambio[]" id="_ckCambio-<?php echo $lCambio->CAMCOD; ?>" value="<?php echo $lCambio->CAMCOD; ?>"> <label for="_ckCambio-<?php echo $lCambio->CAMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($lCambio->CAMDESCRICAO); ?></label> <br>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Combustivel</h6>
                    </div>
                    <div class="col-lg-12 text-dark box-pesquisa">
                        <?php
                        if ($listacombus) {
                            foreach ($listacombus as $lCom) {
                        ?>
                                <input type="checkbox" name="combustivel[]" id="_ckCombustivel-<?php echo $lCom->COMCOD; ?>" value="<?php echo $lCom->COMCOD; ?>"> <label for="_ckCombustivel-<?php echo $lCom->COMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($lCom->COMDESCRICAO); ?></label> <br>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Cor</h6>
                    </div>
                    <div class="col-lg-12 text-dark box-pesquisa">
                        <?php
                        if ($listaCor) {
                            foreach ($listaCor as $lCor) {
                        ?>
                                <input type="checkbox" name="cor[]" id="_ckCor-<?php echo $lCor->CORCOD; ?>" value="<?php echo $lCor->CORCOD; ?>"> <label for="_ckCor-<?php echo $lCor->CORCOD; ?>"> <i class="icone-tint-1" style="color: <?php echo $lCor->CORCODHEXADECIMAL; ?>"></i> <?php echo $util->convert_from_latin1_to_utf8_recursively($lCor->CORDESCRICAO); ?></label> <br>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>


                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Preço</h6>
                    </div>
                    <div class="col-lg-12">
                        <input type="text" name="preco" id="_lblPreco" readonly class="form-control bg-warning text-dark" style="border: 0px; font-weight: 500;">
                    </div>
                    <div class="col-lg-12">
                        <div id="slider-preco"></div>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

            </div>
        </form>
    </aside>

    <section class="col-lg-8 bg-dark">
    <div class="container-fluid">
            <div class="row" style="padding: 10px;">
                <?php if ($listacarro) : 
                    $numCarros = count($listacarro);
                    ?>
                    <div class="col-lg-12">
                        <label class="text-warning"><?php echo $numCarros.' Registro(s) Encontrado(s).'; ?></label>
                    </div>
                    <?php foreach ($listacarro as $carros) : ?>
                        <div class="col-lg-6" style="padding-top: 10px; padding-bottom: 10px;">
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
                                                    <i class="fas fa-map-marker-alt"></i> <?php echo utf8_encode($carros->LOCALIZACAO); ?>
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

    <aside class="col-lg-2">
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
    </aside>
<?php }
else { ?>
    <aside class="col-lg-2 bg-warning" style="padding: 3px;">
        <form action="pesqRepasse.php" method="GET">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 text-warning">
                        <button class="btn btn-dark btn-block" name="pesquisa" type="submit"> <i class="icone-filter-1"></i> Filtrar Pesquisa</button>
                    </div>
                </div>
                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12 text-dark">
                        <input placeholder="Codigo do Veículo" class="form-control form-control-sm" type="text" name="_edcodCarro" id="_edcodCarro">
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Marcas</h6>
                    </div>
                    <div class="col-lg-12 text-dark box-pesquisa">
                        <?php
                        if ($listaMarcas) {
                            foreach ($listaMarcas as $lMarca) {
                        ?>
                                <input type="checkbox" name="marca[]" id="_ckMarca-<?php echo $lMarca->MARCOD; ?>" value="<?php echo $lMarca->MARCOD; ?>"> <label for="_ckMarca-<?php echo $lMarca->MARCOD; ?>"><?php echo $lMarca->MARDESCRICAO; ?></label> <br>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Modelos</h6>
                    </div>
                    <div class="col-lg-12 text-dark box-pesquisa">
                        <?php
                        if ($listaModelo) {
                            foreach ($listaModelo as $lMod) {
                        ?>
                                <input type="checkbox" name="modelo[]" id="_ckModelo-<?php echo $lMod->MODCOD; ?>" value="<?php echo $lMod->MODCOD; ?>"><label for="_ckModelo-<?php echo $lMod->MODCOD; ?>"><?php echo $lMod->MODDESCRICAO; ?></label> <br>
                            <?php
                            }
                        } else {
                            ?>
                            <label style="font-size: 10pt;" for="">Nenhuma Marca Selecionada.</label>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Ano</h6>
                    </div>
                    <div class="col-lg-12">
                        <input type="text" name="ano" id="_lblAno" readonly class="form-control bg-warning text-dark" style="border: 0px; font-weight: 500;">
                    </div>
                    <div class="col-lg-12">
                        <div id="slider-ano"></div>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Cambio</h6>
                    </div>
                    <div class="col-lg-12 text-dark box-pesquisa">
                        <?php
                        if ($listacambio) {
                            foreach ($listacambio as $lCambio) {
                        ?>
                                <input type="checkbox" name="cambio[]" id="_ckCambio-<?php echo $lCambio->CAMCOD; ?>" value="<?php echo $lCambio->CAMCOD; ?>"> <label for="_ckCambio-<?php echo $lCambio->CAMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($lCambio->CAMDESCRICAO); ?></label> <br>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Combustivel</h6>
                    </div>
                    <div class="col-lg-12 text-dark box-pesquisa">
                        <?php
                        if ($listacombus) {
                            foreach ($listacombus as $lCom) {
                        ?>
                                <input type="checkbox" name="combustivel[]" id="_ckCombustivel-<?php echo $lCom->COMCOD; ?>" value="<?php echo $lCom->COMCOD; ?>"> <label for="_ckCombustivel-<?php echo $lCom->COMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($lCom->COMDESCRICAO); ?></label> <br>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Cor</h6>
                    </div>
                    <div class="col-lg-12 text-dark box-pesquisa">
                        <?php
                        if ($listaCor) {
                            foreach ($listaCor as $lCor) {
                        ?>
                                <input type="checkbox" name="cor[]" id="_ckCor-<?php echo $lCor->CORCOD; ?>" value="<?php echo $lCor->CORCOD; ?>"> <label for="_ckCor-<?php echo $lCor->CORCOD; ?>"> <i class="icone-tint-1" style="color: <?php echo $lCor->CORCODHEXADECIMAL; ?>"></i> <?php echo $util->convert_from_latin1_to_utf8_recursively($lCor->CORDESCRICAO); ?></label> <br>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>


                <div class="row" style="margin-top: 5px;">
                    <div class="col-lg-12">
                        <h6>Preço</h6>
                    </div>
                    <div class="col-lg-12">
                        <input type="text" name="preco" id="_lblPreco" readonly class="form-control bg-warning text-dark" style="border: 0px; font-weight: 500;">
                    </div>
                    <div class="col-lg-12">
                        <div id="slider-preco"></div>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-lg-12">
                        <div class="divider divider-dark"></div>
                    </div>
                </div>

            </div>
        </form>
    </aside>

    <section class="col-lg-10 bg-dark">
    <div class="container-fluid">
            <div class="row" style="padding: 10px;">
                <?php if ($listacarro) : 
                    $numCarros = count($listacarro);
                    ?>
                    <div class="col-lg-12">
                        <label class="text-warning"><?php echo $numCarros.' Registro(s) Encontrado(s).'; ?></label>
                    </div>
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
                                                    <i class="fas fa-map-marker-alt"></i> <?php echo utf8_encode($carros->LOCALIZACAO); ?>
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
<?php } ?>
</div>



<script>
    $("#slider-ano").slider({
        range: true,
        min: <?php echo $anoMin; ?>,
        max: <?php echo $anoAtual; ?>,
        values: [<?php echo $anoMin . ',' . $anoAtual; ?>],
        slide: function(event, ui) {
            $("#_lblAno").val(ui.values[0] + "-" + ui.values[1]);
        }
    });
    $("#_lblAno").val($("#slider-ano").slider("values", 0) + "-" + $("#slider-ano").slider("values", 1));


    $("#slider-preco").slider({
        range: true,
        min: <?php echo $precoMinMax[0]->MENOR; ?>,
        max: <?php echo $precoMinMax[0]->MAIOR; ?>,
        values: [<?php echo $precoMinMax[0]->MENOR . ',' . $precoMinMax[0]->MAIOR; ?>],
        slide: function(event, ui) {
            $("#_lblPreco").val(ui.values[0] + "-" + ui.values[1]);
        }
    });
    $("#_lblPreco").val($("#slider-preco").slider("values", 0) + "-" + $("#slider-preco").slider("values", 1));
</script>