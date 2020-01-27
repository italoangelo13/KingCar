<?php
header("Content-type:text/html; charset=utf8");

include_once 'Config/ConexaoBD.php';
include_once 'Config/Util.php';
require_once 'Models/Anuncios.php';

$anoAtual = date("Y");
$contador = 80;
$anoMin = $anoAtual - $contador;
$util = new Util();
$anuncio = new Anuncios();

include 'header.inc.php';
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
                        <input type="text" name="nome" id="_edNome" class="form-control">
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="text-warning" for="_edNome">Email</label>
                        <input type="email" name="email" id="_edEmail" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4">
                    <label class="text-warning" for="_edMarca">Marca</label>
                        <select class="form-control" name="marca" id="_edMarca">
                            <option value="">Selecionar</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label class="text-warning" for="_edModelo">Modelo</label>
                        <select class="form-control" name="modelo" id="_edModelo">
                            <option value="">Selecionar</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label class="text-warning" for="_edCombustivel">Combustivel</label>
                        <select class="form-control" name="combustivel" id="_edCombustivel">
                            <option value="">Selecionar</option>
                        </select>
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