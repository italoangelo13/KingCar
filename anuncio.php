<?php
session_start();
header("Content-type:text/html; charset=utf8");

include_once 'Config/ConexaoBD.php';
include_once 'Config/Util.php';
require_once 'Models/Anuncios.php';
require_once 'Models/Marcas.php';
require_once 'Models/Cambios.php';
require_once 'Models/Combustiveis.php';
require_once 'Models/Cores.php';

$anuncios = new Anuncios();
$marcas = new Marcas();
$cambios = new Cambios();
$combs = new Combustiveis();
$cores = new Cores();



$listaMarcas = $marcas->SelecionarListaMarcas();
$listaCambio = $cambios->SelecionarListaCambio();
$listaComb = $combs->SelecionarListaCombustivel();
$listaCores = $cores->SelecionarListaCores();

$dataAtual = date("d/m/Y");
$anoAtual = date("Y");
$contador = 80;
$util = new Util();
$anuncio = new Anuncios();

include 'header.inc.php';

if(isset($_POST['enviar'])){
    $troca          = null;
    $nome           = null;
    $email          = null;
    $marca          = null;
    $modelo         = null;
    $cambio         = null;
    $combustivel    = null;
    $ano            = null;
    $cor            = null;
    $km             = null;
    $imagem         = null;


    if(isset($_POST['troca'])){
        $troca = $_POST['troca'];
    }

    $nome           = $_POST['nome'];      
    $email          = $_POST['email'];
    $marca          = $_POST['marca'];
    $modelo         = $_POST['modelo'];
    $cambio         = $_POST['cambio'];
    $combustivel    = $_POST['combustivel'];
    $ano            = $_POST['ano'];
    $preco          = $_POST['preco'];
    $cor            = $_POST['cor'];
    $km             = $_POST['_edKm'];

    

    if(isset($_FILES['imagem'])){
        $imagem = $_FILES['imagem'];
        if (strlen($_FILES["imagem"]["name"]) > 0) {

            $dir                = $path_parts = pathinfo($_FILES['imagem']['name']);
            $dirNovo            = "assets/img/Anuncios/"; //diretorio de destino
            $ext                = $path_parts['extension'];
            $nomeNovo            = trim($nome . '-' . date('YmdGis') . '-' . $marca . $modelo . trim($ano)  . '.' . $ext);
            $destino            = $dirNovo . $nomeNovo;
            $arquivo_tmp        = $_FILES['imagem']['tmp_name'];
            $vxvaImg            = $nomeNovo;
        } else {
            echo "<script>alert('Favor selecionar uma foto para o seu veiculo.');</script>";
            exit;
        }
    }


    $anuncio->nome           = $nome;
    $anuncio->email          = $email;      
    $anuncio->marca          = $marca;      
    $anuncio->modelo         = $modelo;     
    $anuncio->cambio         = $cambio;     
    $anuncio->combustivel    = $combustivel;
    $anuncio->ano            = $ano;        
    $anuncio->preco          = $preco;      
    $anuncio->cor            = $cor;        
    $anuncio->km             = $km ; 
    $anuncio->imagem         = $vxvaImg;       
    $anuncio->user           = 'Visitante';

    

    if($anuncio->InserirSolicitacaoAnuncio()){
        try{
            move_uploaded_file($arquivo_tmp, $destino);
            echo "<script>alert('Sua Solicitação foi enviada com sucesso.');</script>";
        }
        catch(Exception $e){
            echo "<script>alert('Não foi possivel enviar a usa imagem. <br>". $e->getMessage() ."');</script>";
            exit;
        }
        
    }
    else{
        echo "<script>alert('Não foi possivel enviar sua solicitação.');</script>";
    }
}


?>
<div class="row bg-warning" style="margin-top: 5px;">
    <div class="col-lg-12 text-center">
        <h5 class="display-3">Quer Vender ou Trocar seu Veículo?</h5>
        <h6 class="display-4">Anuncíe na KingCar!</h6>
    </div>
</div>

<form action="anuncio.php" method="post" enctype=multipart/form-data>
    <div class="row bg-dark" style="margin-top: 5px; padding: 10px;">
        <div class="col-lg-4">
            <img name="_ImgCapaPreview" id="_ImgCapaPreview" class="img-thumbnail" src="assets/img/sem-foto.gif" alt="" style="width: 100%">
            <br><br>
            <input type="file" hidden name="imagem" id="_edImagemCapa">
            <div id="_btnCarregaImg" style="cursor: pointer;" class="btn btn-lg btn-success btn-block"><i class="icone-upload"></i> Carregar Imagem</div>
        </div>
        <div class="col-lg-8" style="border-left: 2px solid yellow">
            <div class="container-fluid">
                <div class="row alert alert-warning" style="margin-top: 5px;">
                    <div class="col-lg-12 text-center">
                        <i class="icone-warning"></i> Preencha o formulário abaixo com as principais informações do seu veiculo, juntamente com uma foto e iremos entrar em contato.
                    </div>
                </div>
                    
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label class="text-warning" for="_edNome">Nome</label>
                        <input type="text" name="nome" id="_edNome" class="form-control" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="text-warning" for="_edNome">Email</label>
                        <input type="email" name="email" id="_edEmail" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                    <label class="text-warning" for="_edMarca">Marca</label>
                        <select class="form-control" name="marca" id="_ddlMarca" required>
                            <option value="">Selecionar</option>
                            <?php if ($listaMarcas) : ?>
                                <?php foreach ($listaMarcas as $marca) : ?>
                                    <option value="<?php echo $marca->MARCOD; ?>"><?php echo $marca->MARDESCRICAO; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label class="text-warning" for="_edModelo">Modelo</label>
                        <select class="form-control" name="modelo" id="_ddlModelo" required>
                            <option value="">Selecionar</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label class="text-warning" for="_edCombustivel">Combustivel</label>
                        <select class="form-control" name="combustivel" id="_edCombustivel" required>
                            <option value="">Selecionar</option>
                            <?php if ($listaComb) : ?>
                                <?php foreach ($listaComb as $comb) : ?>
                                    <option value="<?php echo $comb->COMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($comb->COMDESCRICAO); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="text-warning" for="_edCambio">Cambio</label>
                        <select class="form-control" name="cambio" id="_edCambio" required>
                            <option value="">Selecionar</option>
                            <?php if ($listaCambio) : ?>
                                <?php foreach ($listaCambio as $camb) : ?>
                                    <option value="<?php echo $camb->CAMCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($camb->CAMDESCRICAO); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-4">
                        <label class="text-warning" for="_edCor">Cor</label>
                        <select class="form-control" name="cor" id="_edCor" required>
                            <option value="">Selecionar</option>
                            <?php if ($listaCores) : ?>
                                <?php foreach ($listaCores as $cor) : ?>
                                    <option value="<?php echo $cor->CORCOD; ?>"><?php echo $util->convert_from_latin1_to_utf8_recursively($cor->CORDESCRICAO); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-4">
                        <label class="text-warning" for="_edKm">Quilometragem</label>
                        <input required type="text" class="form-control" value="" id="km" name="_edKm" maxlength="10" placeholder="0,00" onkeydown="Mascara(this,Valor);">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="text-warning" for="_edAno">Ano</label>
                        <select class="form-control" name="ano" id="_edAno" required>
                            <option value="">Selecionar</option>
                            <?php for ($i = 0; $i <= $contador; $i++) : ?>
                                    <?php $anoitem = $anoAtual - $i; ?>
                                    <option value="<?php echo $anoitem; ?> "><?php echo $anoitem; ?></option>
                                <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-4">
                        <label class="text-warning" for="_edCor">Preço</label>
                        <input required type="text" class="form-control" value="" id="_edPreco" name="preco" maxlength="10" placeholder="0.00" onkeydown="Mascara(this,Valor);">
                    </div>

                    <div class="form-group col-lg-4">
                        <br>
                        <br>
                        <input type="checkbox" class="" value="" id="_ckTroca" name="troca"> <label class="text-warning" for="_ckTroca">Aceita Troca</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <button type="submit" name="enviar" class="btn btn-success btn-lg btn-block"><i class="icone-paper-plane-1"></i> Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
$(document).ready(function() {

        $("#_btnCarregaImg").click(function() {
            self.executar();
        });

        $("#_edImagemCapa").click(function() {
            const $ = document.querySelector.bind(document);
            const previewImg = $('#_ImgCapaPreview');
            const fileChooser = $('#_edImagemCapa');

            fileChooser.onchange = e => {
                const fileToUpload = e.target.files.item(0);
                const reader = new FileReader();

                // evento disparado quando o reader terminar de ler 
                reader.onload = e => previewImg.src = e.target.result;

                // solicita ao reader que leia o arquivo 
                // transformando-o para DataURL. 
                // Isso disparará o evento reader.onload.
                reader.readAsDataURL(fileToUpload);
            };
        });


    });



    function executar() {
        $('#_edImagemCapa').trigger('click');
    }
</script>

<?php 
    include 'footer.inc.php';
?>