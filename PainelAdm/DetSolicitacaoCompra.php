<?php
include_once 'header.inc.php';
//header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Compra.php';

$Compra = new Compra();
$util = new Util();
$codSol = null;
$numUsuarios = 0;
$dataAtual = date("d/m/Y");
$anoAtual = date("Y");

if(!isset($_GET['cod'])){
    echo "<script> location.href='SolicitacoesCompra.php'; </script>";
}
else{
    $codSol = $_GET['cod'];
}

$qtdeMsg = $Compra->SelecionarNumSolicitacaoCompra();
$solCompra = $Compra->SelecionarSolicitacaoPorCod($codSol);

if($Compra->AtualizaStatusLido($codSol,'S')){
    
}

if (count($qtdeMsg)) {
    foreach ($qtdeMsg as $row) {
        $numMsg = $row->QTDE;
    }
}





?>


<div class="row bg-primary text-white">
    <div class="col-lg-8">
        <h5>Solicitações de Compra</h5>
    </div>
    <div class="col-lg-4 text-right">
        <?php echo $numMsg; ?> Registro(s) não Lido(s)!
    </div>
</div>
    <div class="row bg-secondary" style="margin-top:5px; padding:5px;">
        <div class="col-lg-12">
            <a href="SolicitacoesCompra.php" class="btn btn-dark"><i class="icone-back"></i> Voltar</a>
            <a href="ResponderMensagemSolCompra.php?codSol=<?php echo $codSol; ?>" class="btn btn-success"><i class="icone-paper-plane-empty"></i> Responder Mensagem</a>
        </div>
    </div>
    <div class="row bg-dark text-white" style="margin-top:5px;">
        <div class="col-lg-12 text-center">
            Dados da Solicitação
        </div>
    </div>
    <div class="row bg-white" style="margin-top:5px;">
        <div class="form-group col-lg-2">
            <label for="_lblCodSolicitacao">Cod</label>
            <label type="text" class="form-control" id="_lblCodSolicitacao" name="_lblCodSolicitacao" readonly>
                <?php echo $codSol; ?>
            </label>
        </div>
        <div class="form-group col-lg-3">
            <label for="_lblNome" >Nome</label>
            <label type="text" class="form-control" id="_lblNome" name="_lblNome" readonly>
            <?php echo $solCompra[0]->COMNOME; ?>
            </label>
        </div>
        <div class="form-group col-lg-3">
            <label for="_lblEmail">Email</label>
            <label type="text" class="form-control" id="_lblEmail" name="_lblEmail" readonly>
            <?php echo $solCompra[0]->COMEMAIL; ?>
            </label>
        </div>
        <div class="form-group col-lg-2">
            <label for="_lblTelefone">Telefone</label>
            <label type="text" class="form-control" id="_lblTelefone" name="_lblTelefone" readonly>
            <?php echo $solCompra[0]->COMTEL; ?>
            </label>
        </div>
        <div class="form-group col-lg-2">
            <label for="_lblDtSolicitacao">Dt. Solicitação</label>
            <label type="text" class="form-control" id="_lblDtSolicitacao" name="_lblDtSolicitacao" readonly>
            <?php echo $solCompra[0]->COMDATCADASTRO; ?>
            </label>
        </div>
    </div>

    <div class="row bg-white" style="margin-top:5px;">
        <div class="form-group col-lg-12">
            <label for="_lblMensagem">Mensagem</label>
            <label class="form-control" id="_lblMensagem" name="_lblMensagem" style="height: 100px;" readonly>
                <?php echo $solCompra[0]->COMMSG; ?>   
            </label>
        </div>
    </div>

    <div class="row bg-dark text-white" style="margin-top:10px;">
        <div class="col-lg-12 text-center">
            Dados do Veículo
        </div>
    </div>

    <div class="row bg-secondary" style="margin-top:5px;padding:10px; margin-bottom: 10px;">
        <div class="col-lg-3">
            <img style="width: 100%" src="../assets/img/Carros/<?php echo $solCompra[0]->CARFOTO; ?>" alt="Capa do Veículo">
        </div>
        <div class="col-lg-9">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 bg-dark">
                        <h3 class="text-light text-center"><?php echo $solCompra[0]->MARDESCRICAO. ' ' .$solCompra[0]->MODDESCRICAO. ' '. $solCompra[0]->CARANO; ?> </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="" class="text-warning"><strong>Cod.</strong></label>
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-warning"><strong>Marca</strong></label>
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-warning"><strong>Modelo</strong></label>
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-warning"><strong>Ano</strong></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="" class="text-light"><?php echo $solCompra[0]->CARCOD; ?></label>
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-light"><?php echo $solCompra[0]->MARDESCRICAO; ?></label>
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-light"><?php echo $solCompra[0]->MODDESCRICAO; ?></label>
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-light"><?php echo $solCompra[0]->CARANO; ?></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                    <label for="" class="text-warning"><strong>Preço</strong></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label for="" class="display-4 text-light"><?php echo 'R$ '.FormatarMoeda($solCompra[0]->CARPRECO); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>