<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); // limpa o cache
	header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");
    
    clearstatcache(); // limpa o cache

    include_once('../Config/ConexaoBD.php');
    require_once('../Models/Publicidades.php');
     

    try{
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare('SELECT Count(*) AS QTDE,
                                DATE_FORMAT(PUBDATCADASTRO, "%b/%y") AS MES
                               FROM KGCTBLPUB
                               GROUP BY DATE_FORMAT(PUBDATCADASTRO, "%b/%y")
                               ORDER BY PUBDATCADASTRO DESC
                               LIMIT 5');
        $smtp->execute(array());
        $result = $smtp->fetchAll(PDO::FETCH_CLASS);

        if (count($result) === 0)
		{
			echo '[{"TransCod":0, "erro":"Nenhuma informação encontrada."}]';
        }
        
        if ( count($result) ) {
            $json = '[';
            $linhaVal = '';

            foreach($result as $linha){
                $linhaVal .= '{"Mes": "'.$linha->MES.'",';
                $linhaVal .= '"Qtde": '.$linha->QTDE.'},';
            }

            $linhaVal .= ']';

            $linhaVal = str_replace(',]',']',$linhaVal);

            $json .= $linhaVal;

            echo json_encode($json);
        }
    }
    catch(Exception $e){
        echo '[{"TransCod":0, "erro":"' . $e->getMessage() .'"}]'; // opcional, apenas para teste
    }

    ?>