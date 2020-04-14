<?php
include_once 'header.inc.php';
//header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Institucional.php';

$vxobInst = new Institucional();
$util = new Util();
$sobre = null;
$dif = null;
$missao = null;
$visao = null;
$valores = null;

if (isset($_POST["atualizar"])) {
    echo "<script>showLoad('Aguarde <br> Atualizando Informações Institucionais.');</script> ";
    $sobre = $_POST["_edTextoHist"];
    $dif = $_POST["_edTextoDif"];
    $missao = $_POST["_edTextoMis"];
    $visao = $_POST["_edTextoVis"];
    $valores = $_POST["_edTextoVal"];


    $vxobInst->Sobre = $sobre;
    $vxobInst->Diferencial = $dif;
    $vxobInst->Missao = $missao;
    $vxobInst->Valores = $valores;
    $vxobInst->Visao = $visao;

    if ($vxobInst->ExisteInstitucional()) {
        if ($vxobInst->AtualizaInstitucional()) {
            echo "<script>hideLoad();</script> ";
            echo "<script>SuccessBox('Informações Institucionais Atualizadas Com Sucesso');</script>";
            exit();
        } else {
            echo "<script>hideLoad();</script> ";
            echo "<script>ErrorBox('Não foi Possivel Atualizar as Informações Institucionais');</script>";
            exit();
        }
    } else {
        if ($vxobInst->InsereInstitucional()) {
            echo "<script>hideLoad();</script> ";
            echo "<script>SuccessBox('Informações Institucionais Atualizadas Com Sucesso');</script>";
            exit();
        } else {
            echo "<script>hideLoad();</script> ";
            echo "<script>ErrorBox('Não foi Possivel Atualizar as Informações Institucionais');</script>";
            exit();
        }
    }
} else {
    $Inst = $vxobInst->SelecionarInfoInstitucional();
    if ($Inst) {
        $sobre = $Inst[0]->INSTSOBRENOS;
        $dif = $Inst[0]->INSTDIFERENCIAL;
        $missao = $Inst[0]->INSTMISSAO;
        $visao = $Inst[0]->INSTVISAO;
        $valores = $Inst[0]->INSTVALORES;
    }
}


?>

<div class="row alert alert-success">
    <div class="col-lg-1 text-center">
        <i class="icone-exclamation" style="font-size: 30px"></i>
    </div>
    <div class="col-lg-11 " style="text-align: justify;">
        Estes Espaços são reservados para a descrição sobre a empresa, fique a vontade para inserir as informações que você achar necessario para seus visitantes.Estas informações serão apresentadas na pagina "INSTITUCIONAL" do seu site.
    </div>
</div>
<form action="institucional.php" method="post" enctype="multipart/form-data">
    <div class="row bg-secondary" style="margin-top: 5px;padding: 5px;">
        <div class="col-lg-12">
            <button class="btn btn-success" name="atualizar" type="submit"><i class="icone-floppy"></i> Salvar</button>
        </div>
    </div>

    <div class="row bg-light" style="margin-top: 5px;padding: 5px;">
        <div class="col-lg-12">
            <i class="text-danger">* Campos Obrigatórios</i>
        </div>
    </div>

    <div class="row bg-light" style="margin-top: 5px; padding: 5px;">
        <div class="col-lg-12" id="contadorHist">
            <h1>Sobre Nós <i class="text-danger">*</i></h1>
            <hr>
            <textarea data-status-message="#contadorHist" name="_edTextoHist" id="_edTextoHist" style="width: 100%" rows="5" required><?php if($sobre){echo $sobre;} ?></textarea>
        </div>
    </div>

    <div class="row bg-light" style="margin-top: 5px; padding: 5px;">
        <div class="col-lg-12" id="contadorDif">
            <h1>Diferenciais</h1>
            <hr>
            <textarea data-status-message="#contadorDif" name="_edTextoDif" id="_edTextoDif" style="width: 100%" rows="5"><?php if($dif){echo $dif;} ?></textarea>
        </div>
    </div>

    <div class="row bg-light" style="margin-top: 5px; padding: 5px;">
        <div class="col-lg-12" id="contadorMis">
            <h1>Missão</h1>
            <hr>
            <textarea data-status-message="#contadorMis" name="_edTextoMis" id="_edTextoMis" style="width: 100%" rows="5"><?php if($missao){echo $missao;} ?></textarea>
        </div>
    </div>

    <div class="row bg-light" style="margin-top: 5px; padding: 5px;">
        <div class="col-lg-12" id="contadorVis">
            <h1>Visão</h1>
            <hr>
            <textarea data-status-message="#contadorVis" name="_edTextoVis" id="_edTextoVis" style="width: 100%" rows="5"><?php if($visao){echo $visao;} ?></textarea>
        </div>
    </div>

    <div class="row bg-light" style="margin-top: 5px; padding: 5px;">
        <div class="col-lg-12" id="contadorVal">
            <h1>Valores</h1>
            <hr>
            <textarea data-status-message="#contadorVal" name="_edTextoVal" id="_edTextoVal" style="width: 100%" rows="5"><?php if($valores){echo $valores;} ?></textarea>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {


        $('#_edTextoHist').limitText({
            limit: 500,
            warningLimit: 150,
            counterClass: 'text-success',
            warningClass: 'text-danger'
        });

        $('#_edTextoDif').limitText({
            limit: 500,
            warningLimit: 150,
            counterClass: 'text-success',
            warningClass: 'text-danger'
        });

        $('#_edTextoMis').limitText({
            limit: 500,
            warningLimit: 150,
            counterClass: 'text-success',
            warningClass: 'text-danger'
        });

        $('#_edTextoVis').limitText({
            limit: 500,
            warningLimit: 150,
            counterClass: 'text-success',
            warningClass: 'text-danger'
        });

        $('#_edTextoVal').limitText({
            limit: 500,
            warningLimit: 150,
            counterClass: 'text-success',
            warningClass: 'text-danger'
        });
    });
</script>

<?php include_once 'footer.inc.php'; ?>