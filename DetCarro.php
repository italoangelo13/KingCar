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

if(isset($_POST['compra'])){
    echo "<script>showLoad('Aguarde <br> Estamos Enviando a sua solicitação.');</script> ";
    $codCarro = $_POST['codCarro'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $telefone = $util->FormatarTelefone($telefone);
    $mensagem = $_POST['mensagem'];

    if($compra->CadastraSolicitacaoCompra($codCarro,$nome,$email,$telefone,$mensagem)){
        echo "<script>SuccessBox('Solicitação Enviada com Sucesso.');</script>";
        echo "<script>hideLoad();</script>";
    }
    else{
        echo "<script>hideLoad();</script>";
        echo "<script>ErrorBox('Ocorreu um erro ao Enviar a Sua Solicitação.');</script>";
    }
}

if(!isset($_GET['id'])){
    header("Location:index.php");
}
else{
    $codCarro = $_GET['id'];
    if(!$carro->UtualizaNumVisitas($codCarro)){
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
            <img class="img-thumbnail"  src="assets/img/Carros/<?php echo $Carro[0]->CARFOTO; ?>" alt="Capa do Anuncio">
        </div>
    <div class="col-lg-8 ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 text-right">
                <h3 class="display-4 text-warning" style="font-weight: 600"><?php echo strtoupper(utf8_encode($Carro[0]->MARDESCRICAO)) . " " . strtoupper(utf8_encode($Carro[0]->MODDESCRICAO)). " " . strtoupper(utf8_encode($Carro[0]->CARANO)); ?></h3>
            <?php if($Carro[0]->CARDESTAQUE == "S"){ ?>
            <h6 class="text-warning" style="font-weight: 700"><i class="icone-crown"></i> Este Veículo é um Destaque King Car!</h6>
            <?php } ?>
                </div>
            </div>

            <div class="row bg-warning" style="margin-top: 10px;">
                <div class="col-lg-3 text-dark">
                    <h6>Marca</h6>
                </div>
                <div class="col-lg-3 text-dark">
                    <h6>Modelo</h6>
                </div>
                <div class="col-lg-3 text-dark">
                    <h6>Ano</h6>
                </div>
                <div class="col-lg-3 text-dark">
                    <h6>Câmbio</h6>
                </div>
            </div>
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-3 text-warning">
                    <label ><?php echo strtoupper(utf8_encode($Carro[0]->MARDESCRICAO)); ?></label>
                </div>
                <div class="col-lg-3 text-warning">
                    <label ><?php echo strtoupper(utf8_encode($Carro[0]->MODDESCRICAO)); ?></label>
                </div>
                <div class="col-lg-3 text-warning">
                    <label ><?php echo strtoupper(utf8_encode($Carro[0]->CARANO)); ?></label>
                </div>
                <div class="col-lg-3 text-warning">
                    <label ><?php echo strtoupper(utf8_encode($Carro[0]->CAMDESCRICAO)); ?></label>
                </div>
            </div>

            <div class="row bg-warning" style="margin-top: 10px;">
                <div class="col-lg-3 text-dark">
                    <h6>Portas</h6>
                </div>
                <div class="col-lg-3 text-dark">
                    <h6>Combustivel</h6>
                </div>
                <div class="col-lg-3 text-dark">
                    <h6>Cor</h6>
                </div>
                <div class="col-lg-3 text-dark">
                    <h6>Quilometragem</h6>
                </div>
            </div>
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-3 text-warning">
                    <label ><?php echo strtoupper(utf8_encode($Carro[0]->CARPORTAS)); ?> Portas</label>
                </div>
                <div class="col-lg-3 text-warning">
                    <label ><?php echo strtoupper(utf8_encode($Carro[0]->COMDESCRICAO)); ?></label>
                </div>
                <div class="col-lg-3 text-warning">
                    <label ><?php echo strtoupper(utf8_encode($Carro[0]->CORDESCRICAO)); ?></label>
                </div>
                <div class="col-lg-3 text-warning">
                    <label ><?php echo FormatarValorDecimal(strtoupper(utf8_encode($Carro[0]->CARKM))); ?> km</label>
                </div>
            </div>

            <div class="row bg-warning" style="margin-top: 10px;">
                <div class="col-lg-3 text-dark">
                    <h6>Aceita Troca</h6>
                </div>
                <div class="col-lg-3 text-dark">
                    <h6>Localização</h6>
                </div>
            </div>

            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-3 text-warning">
                    <label ><?php if($Carro[0]->CARTROCA == 'S'){ echo "Sim"; } else{ echo "Não";} ?></label>
                </div>
                <div class="col-lg-3 text-warning">
                    <label><?php echo strtoupper(utf8_encode($Carro[0]->LOCALIZACAO)); ?></label>
                </div>
            </div>
        </div>
            
        </div>
</div>

<div class="row bg-dark" style="margin-top: 5px; padding:5px;">
    <section class="col-lg-8">
       <h6 class="display-4 text-warning">
            Itens do Veículo
       </h6>
       <hr>

       <div class="container-fluid">
           <div class="row">
               <?php
                    if($Detcarro){
                        foreach($Detcarro as $det){
                            foreach($InfoComp as $info){
                                $valor = $det[$info->COMPNOMCAMPO];
                                $DescCampo = $info->COMPDESC;

                                if($valor == 'S'){ ?>
                                <div class="col-lg-6" style="margin-top: 10px;">
                                <i class="icone-check-3 text-success"></i> <label class="text-warning" style="font-weight: 700"> <?php echo utf8_encode($DescCampo); ?></label>
                                </div>
                                <?php
                                }
                            }
                        }
                    }
                    else{
                        ?>
                                <div class="col-lg-12 text-warning" style="margin-top: 10px;">
                                    Nenhum item vinculado a este Veículo!
                                </div>
                                <?php
                    }
                ?>
           </div>

           <div class="row" style="margin-top: 15px;">
               <div class="col-lg-12 bg-light">
                    <?php if($Detcarro){
                    if($Detcarro[0]['DETINFOCOMP']){ ?>
                        <h5 class="text-justify"><?php echo $util->convert_from_latin1_to_utf8_recursively($Detcarro[0]['DETINFOCOMP']); ?> </h5>
                    <?php }} ?>
               </div>
           </div>
       </div>
     
    </section>
    <aside class="col-lg-4" style="border-left: 2px solid yellow; border-right: 2px solid yellow;">
        <h1 class="text-warning text-center" style="font-weight: 600"><?php echo "R$ ". FormatarMoeda(strtoupper(utf8_encode($Carro[0]->CARPRECO))); ?></h1>
        <div class="container-fluid" style="padding: 5px;">
            <form action="" method="post">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="text-warning text-center">Ficou Interessado? Preencha o Formulário abaixo e entraremos em contato.</label>
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


<div class="row bg-dark"  style="margin-top: 5px; padding: 5px;">
    <div class="col-lg-12">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 bg-warning" style="margin-bottom: 5px;">
                    <h3 class="text-dark">Fotos</h3>
                </div>
            </div>
            <?php if($codCarro){ ?>
            <div id="gallery" class="row">
            <?php
                    $dir = 'assets/img/Carros/'.$codCarro;
                    if(!is_dir($dir)){
                        mkdir($dir);
                    }

                    $files = scandir($dir,1);
                    if(count($files) > 2){
                        foreach($files as $f){
                            if($f != '.' && $f != '..'){ ?>
                                <a class="col-lg-2" href="<?php echo $dir.'/'.$f; ?>" style="margin-top: 5px;">
                                    <img class="card-img-top" style="width: 100%; border-radius: 2px;" src="<?php echo $dir.'/'.$f; ?>" title="<?php echo $dir.'/'.$f; ?>" alt="<?php echo utf8_encode($f); ?>">
                                </a>
                    <?php
                            }
                        }
                    }
                    else{ ?>
                        <div class="col-lg-12">
                            <h4 class="alert alert-warning">Nenhuma Foto Encontrada.</h4>
                        </div>
                    <?php
                    }
            ?>
            </div>
            <?php } else{ ?>
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="alert alert-warning">Nenhuma Foto Encontrada.</h4>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    
    
</div>


<script>
$(document).ready(function () {
    $("#gallery").lightGallery();
});
</script>
<?php include 'footer.inc.php'; ?>