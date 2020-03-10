<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

clearstatcache(); // limpa o cache






include_once('../Config/ConexaoBD.php');
include_once('../Config/Util.php');
require_once('../Models/Publicidades.php');
$vxobPub = new Publicidades();
$util = new Util();
$imagem = null;
$Json = null;
try {
    
    if(isset($_POST)){
        $date = date('dmYHis');
        $empresa = $util->tirarAcento(strtoupper($_POST['_edEmpresa']));
        $titulo = $util->tirarAcento(strtoupper($_POST['_edTitulo']));
        $link = $_POST['_edLink'];
        $dir = $path_parts = pathinfo($_FILES['_edImagemCapa']['name']);
        $ext = $path_parts['extension'];
        $imagemTemp = $_FILES['_edImagemCapa']['tmp_name'];
        $destTemp = '../assets/img/temp_img/img_temp_'.$empresa.$date.'.'.$ext;
        
        if(is_dir('../assets/img/temp_img'))
        {
            move_uploaded_file($imagemTemp, $destTemp);
        }
        else
        {
          mkdir('../assets/img/temp_img');
          move_uploaded_file($imagemTemp, $destTemp);
        }

        list($largura_original, $altura_original) = getimagesize($destTemp);
        $tamImg = $largura_original/$altura_original;
        // if($tamImg != 1){
        //     $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"A imagem deve possuir um tamanho de 500x500 pixels."}]'); 
        //     echo json_encode($Json);
        //     exit;
        // }
    }

   

    session_start();
    $destino = '../assets/img/Pub/';
    $nomeImagem = 'pub_'.$date.$empresa.'.'.$ext;
    $novoDest = $destino.$nomeImagem;
    $vxobPub->Titulo = $titulo;
    $vxobPub->Link = $link;
    $vxobPub->Empresa = $empresa;
    $vxobPub->Imagem = $nomeImagem;
    $vxobPub->User = $_SESSION['Usuario'];
    if($vxobPub->InserePublicidade()){
        rename($destTemp,$novoDest);
        $Ultcod = $vxobPub->BuscaUltimoCodPorUser();
        //unlink($destTemp);
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":1, "msg":"Publicidade Cadstrada com Sucesso.","UltCod":'.$Ultcod.'}]');
    }
    else{
        $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"Não foi Possivel Cadastrar esta Publicidade."}]'); 
    }

    echo json_encode($Json);
    
} catch (Exception $e) {
    $Json = $util->convert_from_latin1_to_utf8_recursively('[{"TransCod":0, "msg":"' . $e->getMessage() . '"}]'); // opcional, apenas para teste
    echo json_encode($Json);
}
