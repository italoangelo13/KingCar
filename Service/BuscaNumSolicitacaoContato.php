<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");
    
    clearstatcache(); // limpa o cache

    include_once('../Config/ConexaoBD.php');
    require_once('../Models/Contatos.php');

    try{
        $contato = new Contatos();
        $r = $contato->SelecionarNumSolicitacaoContatosNaoLidos();
        
        if (!$r)
		{
			echo '[{"TransCod":0, "erro":"Nenhum modelo encontrado para esta marca."}]';
        }
        
        echo json_encode('[{"Msg":'.$r[0]->NUMCONTATOS.'}]');
    }
    catch(Exception $e){
        echo '[{"TransCod":0, "erro":"' . $e->getMessage() .'"}]'; // opcional, apenas para teste
    }

    ?>