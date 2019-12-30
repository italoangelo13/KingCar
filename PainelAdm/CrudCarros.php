<?php
include_once 'header.inc.php';
header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Carros.php';

$Carro = new Carros();
$util = new Util();

$numCarros = 0;
$dataAtual = date("d/m/Y");
$anoAtual = date("Y");
$contador = 40;
$caminhoImg = null;





//determina o numero de registros que serão mostrados na tela
$maximo = 10;
//armazenamos o valor da pagina atual
$pagina = isset($_GET['pagina']) ? ($_GET['pagina']) : '1';
//subtraimos 1, porque os registros sempre começam do 0 (zero), como num array
$inicio = $pagina - 1;
//multiplicamos a quantidade de registros da pagina pelo valor da pagina atual 
$inicio = $maximo * $inicio;
$total = 0; 
BuscaTotalCarros($Carro);

function BuscaTotalCarros($Carro){
    $strCount = $Carro->SelecionaTotalNumCarros();
    
    if (count($strCount)) {
        foreach ($strCount as $row) {
            //armazeno o total de registros da tabela para fazer a paginação
            $total = $row->NUMCARROS;
            $numCarros = $row->NUMCARROS;
        }
    }
}


if(!isset($_GET['acao'])){
    echo "<script>showLoad('Aguarde <br> Carregando os Veiculos Cadastrados.');</script> ";
    $resultado = carregaGrid($Carro,$inicio,$maximo);
    echo "<script>hideLoad();</script>";
}
else if(isset($_GET['acao'])){
    if($_GET['acao'] == "del"){
        echo "<script>showLoad('Aguarde <br> Excluindo Veiculo Selecionado.');</script> ";
        if($Carro->DeletaCarroPorCod($_GET['cod'])){
            echo "<script>hideLoad();</script>";
            echo "<script>SuccessBox('Veiculo Excluido com Sucesso.');</script>";
        }
        else{
            echo "<script>hideLoad();</script>";
            echo "<script>ErrorBox('Não Foi Possivel Excluir este Veiculo.');</script>";
        }
        echo "<script>showLoad('Aguarde <br> Carregando os Veiculos Cadastrados.');</script> ";
        $resultado = carregaGrid($Carro,$inicio,$maximo);
        BuscaTotalCarros($Carro);
        echo "<script>hideLoad();</script>";
    }
}

function carregaGrid($Carro,$inicio,$maximo){
    return $Carro->SelecionaCarrosPaginados($inicio, $maximo);
}



?>

        <div class="row bg-primary text-white">
            <div class="col-lg-10">
                <h5>Cadastro de Carros</h5>
            </div>
            <div class="col-lg-2 text-right">
                <?php echo $numCarros; ?> Registro(s)
            </div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-lg-12">
                <a class="btn btn-success" href="InsereAtualizaCarro.php"><i class="icone-plus"></i> Cadastrar Carro</a>
            </div>
        </div>

        <form action="" method="post">
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12 bg-secondary">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label for="">Pesquisar Por:</label>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <select name="_ddlPesquisa" id="_ddlPesquisa" class="form-control">
                                                <option value="CODCAR" selected>CÓDIGO</option>
                                                <option value="MARDESCRICAO">MARCA</option>
                                                <option value="MODDESCRICAO">MODELO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="text" name="_edPesquisa" id="_edPesquisa" class="form-control" placeholder="Pesquisar Carro">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" class="btn btn-success" name="pesquisa"><i class="icone-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Ordem de Pesquisa:</label>
                                <select name="_ddlPesquisa" id="_ddlOrd" class="form-control">
                                    <option value="ASC" selected>CRESCENTE</option>
                                    <option value="DESC">DECRESCENTE</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>

        <div class="row" style="margin-top: 10px;">
            <div class="col-lg-12">
                <?php if ($resultado) : ?>
                    <table class="table table-stripped bg-success">
                        <thead class="text-white text-center">
                            <th>
                                
                            </th>
                            <th>
                                Cod.
                            </th>
                            <th>
                                Marca
                            </th>
                            <th>
                                Modelo
                            </th>
                            <th>
                                Ano
                            </th>
                            <th>
                                Preço
                            </th>
                            <th>
                                Localização
                            </th>
                            <th>
                                Editar
                            </th>
                            <th>
                                Excluir
                            </th>
                        </thead>
                        <tbody class="table-success" style="font-size: 12pt; font-weight: 600;">
                            <?php if($resultado):
                            foreach ($resultado as $rowLinha) : 
                            ?>
                                <tr>
                                    <td class="text-center"><img src="../assets/img/Carros/<?php echo $rowLinha->CARFOTO; ?>" alt="" srcset="" width="100px"></td>
                                    <td class="text-center"><?php echo $rowLinha->CARCOD; ?></td>
                                    <td class="text-center"><?php echo $rowLinha->MARDESCRICAO; ?></td>
                                    <td class="text-center"><?php echo $rowLinha->MODDESCRICAO; ?></td>
                                    <td class="text-center"><?php echo $rowLinha->CARANO; ?></td>
                                    <td class="text-center"><?php echo 'R$ '.FormatarMoeda($rowLinha->CARPRECO); ?></td>
                                    <td class="text-center"><?php echo $util->convert_from_latin1_to_utf8_recursively($rowLinha->Localizacao); ?></td>
                                    <td class="text-center"><a class="btn btn-success" href="InsereAtualizaCarro.php?acao=editar&cod=<?php echo $rowLinha->CARCOD; ?>"><i class="icone-pencil"></i></a></td>
                                    <td class="text-center"><a class="btn btn-danger" href="CrudCarros.php?acao=del&cod=<?php echo $rowLinha->CARCOD; ?>"><i class="icone-trash"></i></a></td>
                                </tr>
                            <?php endforeach ;
                            endif;?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <h5 class="alert alert-danger">Nenhum Registro encontrado!</h5>
                <?php endif ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        //determina de quantos em quantos links serão adicionados e removidos
                        $max_links = 10;
                        //dados para os botões
                        $previous = $pagina - 1;
                        $next = $pagina + 1;
                        //usa uma funcção "ceil" para arrendondar o numero pra cima, ex 1,01 será 2
                        $pgs = ceil($total / $maximo);
                        if ($pgs > 1) {
                            //botao anterior
                            if ($previous > 0) {

                        ?>
                                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?pagina=" . $previous; ?>">Anterior</a></li>
                            <?php
                            } else {

                            ?>
                                <li class="page-item" disabled='disabled'><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?pagina=" . $previous; ?>">Anterior</a></li>
                                <?php
                            }

                            for ($i = $pagina - $max_links; $i <= $pgs - 1; $i++) {
                                if ($i <= 0) {
                                    //enquanto for negativo, não faz nada
                                } else {
                                    //senão adiciona os links para outra pagina
                                    if ($i != $pagina) {
                                ?>
                                        <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?pagina=" . ($i); ?>"><?php echo $i; ?></a></li>
                                    <?php

                                    } else {
                                    ?>
                                        <li class="page-item" disabled='disabled'><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] . "?pagina=" . ($i); ?>"><?php echo $i; ?></a></li>
                                <?php
                                    }
                                }
                            }
                            //botao proximo
                            if ($next <= $pgs) {

                                ?>
                                <li class="page-item"><a class="page-link" href="<?php $_SERVER['PHP_SELF'] . "?pagina=" . $next; ?>">Proximo</a></li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item" disabled='disabled'><a class="page-link" href="<?php $_SERVER['PHP_SELF'] . "?pagina=" . $next; ?>">Proximo</a></li>
                        <?php
                            }
                        }

                        ?>
                    </ul>
                </nav>
            </div>
        </div>

    

    <script>
        $(document).ready(function() {
            $("#_ddlMarca").change(function() {
                CarregaDdlModelo();
            });

            $("#_ddlUf").change(function() {
                CarregaDdlCidade();
            });

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

        function LimpaCampos() {
            var img = $('#_ImgCapaPreview');
            img.attr('src', '../assets/img/sem-foto.gif');
        }

        function ValidarCampos() {
            showLoadModal('Validando Informações do veículo', '#CadCarro');
            var titulo = $('#_edTitulo');
            var marca = $('#_ddlMarca');
            var modelo = $('#_ddlModelo');
            var ano = $('#_ddlAno');
            var km = $('#_edKm');
            var cambio = $('#_ddlCamb');
            var combustivel = $('#_ddlComb');
            var portas = $('#_edNumPortas');
            var cor = $('#_ddlCor');
            var uf = $('#_ddlUf');
            var municipio = $('#_ddlMun');
            var img = $('#_edImagemCapa');
            var valor = $('#_edValor');


            if (titulo.val() === "" || titulo.val() === null) {
                hideLoadModal("#CadCarro");
                WarningBox('Campo Titulo é Obrigatório.');
                titulo.focus();
                return;
            }

            if (marca.val() === "" || marca.val() === null || marca.val() === "0") {
                hideLoadModal("#CadCarro");
                WarningBox('Campo marca é Obrigatório.');
                marca.focus();
                return;
            }

            if (modelo.val() === "" || modelo.val() === null || modelo.val() === "0") {
                hideLoadModal("#CadCarro");
                WarningBox('Campo modelo é Obrigatório.');
                modelo.focus();
                return;
            }

            if (ano.val() === "" || ano.val() === null || ano.val() === "0") {
                hideLoadModal("#CadCarro");
                WarningBox('Campo ano é Obrigatório.');
                ano.focus();
                return;
            }

            if (km.val() === "" || km.val() === null) {
                hideLoadModal("#CadCarro");
                WarningBox('Campo Quilometragem é Obrigatório.');
                km.focus();
                return;
            }

            if (cambio.val() === "" || cambio.val() === null || cambio.val() === "0") {
                hideLoadModal("#CadCarro");
                WarningBox('Campo cambio é Obrigatório.');
                cambio.focus();
                return;
            }

            if (combustivel.val() === "" || combustivel.val() === null || combustivel.val() === "0") {
                hideLoadModal("#CadCarro");
                WarningBox('Campo combustivel é Obrigatório.');
                combustivel.focus();
                return;
            }

            if (portas.val() === "" || portas.val() === null) {
                hideLoadModal("#CadCarro");
                WarningBox('Campo portas é Obrigatório.');
                portas.focus();
                return;
            }

            if (cor.val() === "" || cor.val() === null || cor.val() === "0") {
                hideLoadModal("#CadCarro");
                WarningBox('Campo cor é Obrigatório.');
                cor.focus();
                return;
            }

            if (uf.val() === "" || uf.val() === null || uf.val() === "0") {
                hideLoadModal("#CadCarro");
                WarningBox('Campo Estado é Obrigatório.');
                uf.focus();
                return;
            }

            if (municipio.val() === "" || municipio.val() === null || municipio.val() === "0") {
                hideLoadModal("#CadCarro");
                WarningBox('Campo Cidade é Obrigatório.');
                municipio.focus();
                return;
            }

            if (img.val() === "" || municipio.val() === null) {
                hideLoadModal("#CadCarro");
                WarningBox('Capa do Anuncio é Obrigatório.');
                img.focus();
                return;
            }

            if (valor.val() === "" || valor.val() === null || valor.val() === "0" || valor.val() === "0,00" || valor.val() === "0,0") {
                hideLoadModal("#CadCarro");
                WarningBox('Campo valor é Obrigatório.');
                valor.focus();
                return;
            }


            showLoadModal('Aguarde, <br> Salvando informações do Veiculo.', '#CadCarro');

            $('form#_formCadCarro').submit();


        }

        function CarregaDdlModelo() {
            let CodMarca = $("#_ddlMarca option:selected").val(); //$("#_ddlMarca").val();  
            var obj = {
                CODMARCA: CodMarca,
            };

            //var param = JSON.stringify(obj);

            $.ajax({
                url: "../service/BuscaModelos.php?codMarca=" + CodMarca,
                type: 'GET',
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    debugger;
                    console.log(data);
                    var selectbox = $('#_ddlModelo');
                    selectbox.find('option').remove();
                    data.forEach(function(o, index) {
                        $('<option>').val(o.MODCOD).text(o.MODDESCRICAO).appendTo(selectbox);
                    });
                    $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                    $('#_ddlModelo option[value=0]').attr('selected', 'selected');

                }
            });
        }

        function CarregaDdlCidade() {
            let uf = $("#_ddlUf option:selected").val(); //$("#_ddlMarca").val();  
            var obj = {
                Uf: uf,
            };

            //var param = JSON.stringify(obj);
            $.ajax({
                url: "../service/BuscaMunicipios.php?Uf=" + uf,
                type: 'GET',
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    debugger;
                    console.log(data);
                    var dados = JSON.parse(data);
                    console.log(dados);
                    var selectbox = $('#_ddlMun');
                    selectbox.find('option').remove();
                    dados.forEach(function(o, index) {
                        $('<option>').val(o.MUNCODIGOIBGE).text(o.MUNDESCRICAO).appendTo(selectbox);
                    });
                    $('<option>').val('0').text('Selecionar').appendTo(selectbox);
                    $('#_ddlMun option[value=0]').attr('selected', 'selected');

                }
            });
        }
    </script>
<?php
include_once 'footer.inc.php';
?>