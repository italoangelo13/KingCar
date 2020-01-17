<?php
include_once 'header.inc.php';
header("Content-type:text/html; charset=utf8");
include_once '../Config/Util.php';
require_once '../Models/Usuarios.php';

$Usuario = new Usuarios();
$util = new Util();

$numUsuarios = 0;
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
//BuscaTotalCarros($Carro);
$sqlusu = "SELECT count(*) as NumUsuarios FROM KGCTBLUSU";
$strCount = $Usuario->SelecionarNumUsuarios($sqlusu);

if (count($strCount)) {
    foreach ($strCount as $row) {
        //armazeno o total de registros da tabela para fazer a paginação
        $total = $row->NumUsuarios;
        $numUsuarios = $row->NumUsuarios;
    }
}




if (!isset($_GET['acao'])) {
    if (isset($_POST['pesquisa'])) {
        echo "<script>showLoad('Aguarde <br> Carregando os Usuário Cadastrados.');</script> ";
        $filtro = "";
        if ($_POST['_edPesquisa']) {
            $campo = $_POST['_ddlPesquisa'];
            $valor = $_POST['_edPesquisa'];

            if ($campo == "CARCOD") {
                if (is_numeric($valor)) {
                    $cod = intval($valor);
                } else {
                    echo "<script>hideLoad();</script>";
                    echo "<script>ErrorBox('Codigo Pesquisado é invalido.');</script>";
                    exit();
                }
                $filtro = " AND $campo  = $cod";
            } else {
                $filtro = " AND $campo like '%$valor%'";
            }
        }

        $ord = " order by " . $_POST['_ddlPesquisa'] . ' ' . $_POST['_ddlOrd'];

        $resultado = carregaGridPesq($Carro, $inicio, $maximo, $filtro, $ord);
        echo "<script>hideLoad();</script>";
    } else {
        echo "<script>showLoad('Aguarde <br> Carregando os Usuários Cadastrados.');</script> ";
        //$resultado = carregaGrid($Carro,$inicio,$maximo);
        echo "<script>hideLoad();</script>";
    }
} else if (isset($_GET['acao'])) {
    if ($_GET['acao'] == "del") {
        echo "<script>showLoad('Aguarde <br> Excluindo Usuário Selecionado.');</script> ";
        if ($Carro->DeletaCarroPorCod($_GET['cod'])) {
            echo "<script>hideLoad();</script>";
            echo "<script>SuccessBox('Usuário Excluido com Sucesso.');</script>";
        } else {
            echo "<script>hideLoad();</script>";
            echo "<script>ErrorBox('Não Foi Possivel Excluir este Usuário.');</script>";
        }
        echo "<script>showLoad('Aguarde <br> Carregando os Usuários Cadastrados.');</script> ";
        $resultado = carregaGrid($Carro, $inicio, $maximo);
        echo "<script>hideLoad();</script>";
    }
}

function carregaGrid($Carro, $inicio, $maximo)
{
    //return $Carro->SelecionaCarrosPaginados($inicio, $maximo);
}

function carregaGridPesq($Carro, $inicio, $maximo, $filtro, $ord)
{
    return $Carro->SelecionaCarrosPaginadosPesq($inicio, $maximo, $filtro, $ord);
}



?>

<div class="row bg-primary text-white">
    <div class="col-lg-10">
        <h5>Cadastro de Usuarios</h5>
    </div>
    <div class="col-lg-2 text-right">
        <?php echo $numUsuarios; ?> Registro(s)
    </div>
</div>
<div class="row" style="margin-top:5px;">
    <div class="col-lg-12">
        <a class="btn btn-success" href="InsereAtualizaCarro.php"><i class="icone-plus"></i> Cadastrar Usuario</a>
    </div>
</div>
<div class="row bg-light" style="margin-top:5px; padding:5px;">
    <div class="col-lg-12 ">
        <table id="_gridPesq" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Usuario</th>
                    <th>Dt. Cadastro</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            <tbody>

            </tbody>
            </thead>
        </table>
    </div>
</div>





<script>
    $(document).ready(function() {
        $('#_gridPesq').DataTable({
            "language": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                },
                "select": {
                    "rows": {
                        "_": "Selecionado %d linhas",
                        "0": "Nenhuma linha selecionada",
                        "1": "Selecionado 1 linha"
                    }
                }
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "../Service/BuscaUsuarios.php",
                "dataSrc": "",
                "type": "POST"
            },
            "columns": [
                { "data": "id" },
                { "data": "nome" },
                { "data": "usuario" },
                { "data": "dtcadastro" },
                { "data": "editar" },
                { "data": "excluir" }
            ]
        });
    });
</script>