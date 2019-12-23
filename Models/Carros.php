<?php

class Carros{
    public function SelecionarListaCarros(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CARCOD,
        MARDESCRICAO,
        MODDESCRICAO,
        CARPRECO,
        CARANO,
        CARFOTO,
        CARPORTAS,
        COMDESCRICAO,
        CORDESCRICAO,
        CORCODHEXADECIMAL,
        CARDESTAQUE,
        CARKM,
        mundescricao,
        munuf,
        CONCAT('#',CARCOD,' - ',MODDESCRICAO,' ',CARANO) AS CARNOME
        FROM kgctblcar
        INNER JOIN kgctblmar
        ON CARCODMARCA = MARCOD
        INNER JOIN kgctblMOD
        ON CARCODMODELO = MODCOD
        INNER JOIN kgctblCOR
        ON CARCODCOR = CORCOD
        INNER JOIN kgctblcom
        ON CARCODCOMBUSTIVEL = comCOD
        inner join kgctblmun
        on carcodmunicipio = muncodigoibge
        ORDER BY CARQTDEVISITAS DESC");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  


    public function SelecionarNumCarros($sql)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare($sql);
        $smtp->execute();

       
        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        
    }


    public function SelecionaTotalNumCarros()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COUNT(*) AS NUMCARROS FROM KGCTBLCAR");
        $smtp->execute();

       
        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        
    }

    function SelecionaCarrosPaginados($inicio,$maximo){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT * FROM KGCTBLCAR LIMIT $inicio,$maximo");
        $smtp->execute();

       
        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }
    

}