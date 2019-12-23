<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");

    clearstatcache(); // limpa o cache

    include_once('../Config/ConexaoBD.php');
    require_once('../Models/Carros.php');

    $titulo = $_POST["_edTitulo"];
    $dataCad = $_POST["_edDtCadastro"];
    $marca = $_POST["_ddlMarca"];
    $modelo = $_POST["_ddlModelo"];
    $ano = $_POST["_ddlAno"];
    $km = $_POST["_edKm"];
    $cambio = $_POST["_ddlCamb"];
    $combustivel = $_POST["_ddlComb"];
    $portas = $_POST["_edNumPortas"];
    $cor = $_POST["_ddlCor"];
    $uf = $_POST["_ddlUf"];
    $municipio = $_POST["_ddlMun"];
    $img = $_FILES["_edImagemCapa"];
    $dir = $path_parts = pathinfo($_FILES['_edImagemCapa']['name']);
    $ext = $path_parts['extension'];
    $destino = trim(date('YmdGis').'-' .$marca.$modelo.$ano.$uf.$municipio.'.'.$ext);
    $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
    die;
    move_uploaded_file( $arquivo_tmp, $destino  );
  

?>