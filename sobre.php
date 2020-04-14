<?php
header("Content-type:text/html; charset=utf8");

include_once 'Config/ConexaoBD.php';
include_once 'Config/Util.php';
require_once 'Models/Anuncios.php';
require_once 'Models/Institucional.php';

$anoAtual = date("Y");
$contador = 80;
$anoMin = $anoAtual - $contador;


$vxobInst = new Institucional();
$util = new Util();
$sobre = null;
$dif = null;
$missao = null;
$visao = null;
$valores = null;

    $Inst = $vxobInst->SelecionarInfoInstitucional();
    if ($Inst) {
        $sobre = $Inst[0]->INSTSOBRENOS;
        $dif = $Inst[0]->INSTDIFERENCIAL;
        $missao = $Inst[0]->INSTMISSAO;
        $visao = $Inst[0]->INSTVISAO;
        $valores = $Inst[0]->INSTVALORES;
    }

include 'header.inc.php';
?>

<div class="row bg-dark text-warning" style="margin-top: 10px;">
    <div class="col-lg-3" style="padding: 10px;">
    <img src="assets/img/sobre.jpg" class="img-thumbnail" alt="" srcset="" width="100%">
    </div>

    <div class="col-lg-9">
        <h1>Historia</h1>
        <hr>
        <p>
            <?php echo $sobre; ?> 
        </p>
    </div>
</div>



<?php 
if($missao){
    ?>
<div class="row bg-dark text-warning" style="margin-top: 10px;">
<div class="col-lg-3" style="padding: 10px;">
<img src="assets/img/missao.jpg" class="img-thumbnail" alt="" srcset="" width="100%">
    </div>

<div class="col-lg-9">
        <h1>Missão</h1>
        <hr>
        <p>
            <?php echo $missao; ?> 
        </p>
    </div>
</div>
    <?php
}
?>



<?php 
if($visao){
    ?>
<div class="row bg-dark text-warning" style="margin-top: 10px;">
<div class="col-lg-3" style="padding: 10px;">
<img src="assets/img/visao.jpg" class="img-thumbnail" alt="" srcset="" width="100%">
    </div>

<div class="col-lg-9">
        <h1>Visão</h1>
        <hr>
        <p>
            <?php echo $visao; ?> 
        </p>
    </div>
</div>
    <?php
}
?>

<?php 
if($dif){
    ?>
<div class="row bg-dark text-warning" style="margin-top: 10px;">
<div class="col-lg-3" style="padding: 10px;">
<img src="assets/img/diferencial.jpg" class="img-thumbnail" alt="" srcset="" width="100%">
    </div>

<div class="col-lg-9">
        <h1>Diferencial</h1>
        <hr>
        <p>
            <?php echo $dif; ?> 
        </p>
    </div>
</div>
    <?php
}
?>


<?php 
if($valores){
    ?>
<div class="row bg-dark text-warning" style="margin-top: 10px;">
<div class="col-lg-3" style="padding: 10px;">
        <img src="assets/img/valores.png" class="img-thumbnail" alt="" srcset="" width="100%">
    </div>

<div class="col-lg-9">
        <h1>Valores</h1>
        <hr>
        <p>
            <?php echo $valores; ?> 
        </p>
    </div>
</div>
    <?php
}
?>


<?php include 'footer.inc.php'; ?>
