<?php
header("Content-type:text/html;charset=utf8");
define("server", "mysql:host=kgcdbs01.mysql.dbaas.com.br;dbname=kgcdbs01;charset=UTF8");
define('user', 'kgcdbs01');
define('senha', 'kgclgn01');
setlocale(LC_MONETARY,"pt_BR", "ptb");




function FormatarMoeda($valor){
    return number_format($valor, 2, ',' , '.');
}
function FormatarMoedaUs($valor){
    return number_format($valor, 2, '.' , ',');
}

function FormatarValorDecimal($valor){
    return number_format($valor, 2, ',' , '.');
}


?>