<?php

class Util{

    public static function convert_from_latin1_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            return utf8_encode($dat);
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

            return $dat;
        } else {
            return $dat;
        }
    }

    public function AtualizaParametroPorCod($val,$codParam)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("UPDATE kgctblprm SET PRMVAL = '$val' WHERE PRMCOD = $codParam");
        $smtp->execute();

        $r = $smtp->rowCount();

        if($r){
            return true;
        }
        else{
            return false;
        }
    }

    public function SelecionarParametros()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT
        PRMCOD, PRMNOMECAMPO, PRMCAMPO, PRMVAL, PRMDESCRICAO
        FROM kgctblprm");
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }


    public function SelecionarInformaçõesComplementares()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COMPDESC, COMPNOMCAMPO FROM KGCTBLINFOCOMP");
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }

    public function SelecionarParametroPorCod($codParametro)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT
        PRMNOMECAMPO, PRMCAMPO, PRMVAL, PRMDESCRICAO
        FROM kgctblprm where PRMCOD = $codParametro");
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }


    public function FormatarTelefone($var)
    {
        $var = str_replace('(','',$var);
        $var = str_replace(')','',$var);
        $var = str_replace('-','',$var);
        $var = str_replace(' ','',$var);
        return $var;
    }


    
}

?>