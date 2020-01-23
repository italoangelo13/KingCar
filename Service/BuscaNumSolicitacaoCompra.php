<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");
    
    clearstatcache(); // limpa o cache

    include_once('../Config/ConexaoBD.php');
    require_once('../Models/Compra.php');

    try{
        $compra = new Compra();
        $r = $compra->SelecionarNumSolicitacaoCompra();
        
        if (!$r)
		{
			echo '[{"TransCod":0, "erro":"Nenhum modelo encontrado para esta marca."}]';
        }
        
        echo json_encode('[{"Msg":'.$r[0]->QTDE.'}]');
    }
    catch(Exception $e){
        echo '[{"TransCod":0, "erro":"' . $e->getMessage() .'"}]'; // opcional, apenas para teste
    }

    ?>