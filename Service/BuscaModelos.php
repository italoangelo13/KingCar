<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");
    
    clearstatcache(); // limpa o cache

    include_once('../Config/ConexaoBD.php');
    require_once('../Models/Modelos.php');
     if ($_GET){
         $CODMARCA = $_GET['codMarca'];
	 } else {
	 	echo '[{"erro":"Sem parametros na url"}]';
	 	exit(); //para a aplicação PHP
	 }

    try{
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MODCOD, MODDESCRICAO FROM KGCTBLMOD where MODCODMARCA = ".$CODMARCA);
        $smtp->execute(array());
        $result = $smtp->fetchAll(PDO::FETCH_CLASS);

        if (count($result) === 0)
		{
			echo '[{"TransCod":0, "erro":"Nenhum modelo encontrado para esta marca."}]';
        }
        
        if ( count($result) ) {
            echo json_encode($result);
        }
    }
    catch(Exception $e){
        echo '[{"TransCod":0, "erro":"' . $e->getMessage() .'"}]'; // opcional, apenas para teste
    }

    ?>