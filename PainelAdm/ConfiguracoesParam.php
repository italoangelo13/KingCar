<?php
include 'header.inc.php';
require_once '../Config/Util.php';
$util = new Util();

if(isset($_POST['salvar'])){
    $total = count($_POST);
    for($i = 0; $i < $total; $i++) {
        if($i != 0){
            $val = $_POST['edvalor_'.$i];
            $codParam = $i;
            try{
                if($util->AtualizaParametroPorCod($val,$codParam)){

                }
            }
            catch(Exception $e){
                echo '<script> ErrorBox("Não foi possivel Atualizar o Parâmetro '. $i .'. <br>Erro Ocorrido: '.$e->getMessage().'"); </script>';
                return;
            }
            
        }
    }

    echo '<script> SuccessBox("Parametros Atualizados com sucesso."); </script>';
}


    $parametros = $util->SelecionarParametros();

?>

<div class="row bg-primary text-white">
    <div class="col-lg-12">
        <h5>Configurações</h5>
    </div>
</div>
<form action="ConfiguracoesParam.php" method="post">
    <div class="row" style="margin-top:5px;">
        <div class="col-lg-12">
            <button type="submit" name="salvar" class="btn btn-success"><i class="icone-floppy"></i> Salvar</button>
        </div>
    </div>

    <div class="row bg-light" style="margin-top:5px; padding: 5px;">
        <div class="col-lg-12">
            <table class="table table-bordered table-stripped">
                <thead class="bg-success text-white">
                    <th>Id</th>
                    <th>Parâmetro</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                </thead>
                <tbody>
                    <?php
                    $cont = 1;
                    foreach ($parametros as $par) {
                        ?>
                        <tr>
                            <td>
                                <label for=""><?php echo $par->PRMCOD; ?></label>
                            </td>
                            <td>
                                <label for=""><?php echo $par->PRMCAMPO; ?></label>
                            </td>
                            <td>
                                <label for=""><?php echo $par->PRMDESCRICAO; ?></label>
                            </td>
                            <td>
                                <input class="form-control form-control-sm" type="text" name="edvalor_<?php echo $cont; ?>" id="edvalor_<?php echo $cont; ?>" value="<?php echo $par->PRMVAL; ?>">
                            </td>
                        </tr>
                        <?php
                        $cont++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</form>