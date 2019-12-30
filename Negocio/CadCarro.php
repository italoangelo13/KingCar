<?php
require_once('../Models/Carros.php');
session_start();
$carro = new Carros();



    

    try{
        
    }
    catch(Exception $e){
        echo json_encode('{"TransCod":0, "erro":"Não foi possivel Realizar o cadastro deste automovel, contate o suporte tecnico para auxilia-lo."}');
    }
    
    
  

?>