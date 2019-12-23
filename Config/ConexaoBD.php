<?php
header("Content-type:text/html;charset=utf8");
define("server", "mysql:host=localhost;dbname=kingcar");
define('user', 'root');
define('senha', 'root');
setlocale(LC_MONETARY,"pt_BR", "ptb");




function FormatarMoeda($valor){
    return number_format($valor, 2, ',' , '.');
}

function FormatarValorDecimal($valor){
    return number_format($valor, 2, ',' , '.');
}


?>