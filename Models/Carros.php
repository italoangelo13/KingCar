<?php

class Carros
{
    // public $Id;
    // public $DtCadastro;
    // public $User;
    // public $Titulo;
    // public $Marca;
    // public $Modelo;
    // public $Ano;
    // public $Km;
    // public $Cambio;
    // public $Combustivel;
    // public $Portas;
    // public $Cor;
    // public $Uf;
    // public $Municipio;
    // public $ImgCapa;

    // public function Carros() {
    //     // tratado como construtor no PHP 5.3.0-5.3.2
    //     // tratado como método comum a partir do PHP 5.3.3
    //     $Id           = "";
    //     $DtCadastro   = "";
    //     $User         = "";
    //     $Titulo       = "";
    //     $Marca        = "";
    //     $Modelo       = "";
    //     $Ano          = "";
    //     $Km           = "";
    //     $Cambio       = "";
    //     $Combustivel  = "";
    //     $Portas       = "";
    //     $Cor          = "";
    //     $Uf           = "";
    //     $Municipio    = "";
    //     $ImgCapa      = "";
    // }

    public function SelecionarListaCarros()
    {
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
        WHERE CARDESTAQUE = 'N'
        ORDER BY CARQTDEVISITAS DESC");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

    public function SelecionarListaCarrosDestaques()
    {
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
        CONCAT(mundescricao,'/',munuf) AS LOCALIZACAO,
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
        WHERE CARDESTAQUE = 'S'
        ORDER BY CARDATCADASTRO DESC");
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

    public function SelecionarNumCarrosDetIncompletos($SQLCARDET){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare($SQLCARDET);
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

    function SelecionaCarrosPaginados($inicio, $maximo)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CARCOD,
                                        MARDESCRICAO,
                                        MODDESCRICAO,
                                        CARPRECO,
                                        CARANO,
                                        CARFOTO,
                                        CARPORTAS,
                                        CONCAT(mundescricao,' - ',munuf) AS Localizacao
                                        FROM kgctblcar
                                        INNER JOIN kgctblmar
                                        ON CARCODMARCA = MARCOD
                                        INNER JOIN kgctblMOD
                                        ON CARCODMODELO = MODCOD
                                        inner join kgctblmun
                                        on carcodmunicipio = muncodigoibge
                                LIMIT $inicio,$maximo ");
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }

    function SelecionaCarrosPaginadosPesq($inicio, $maximo,$filtro,$ord){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT CARCOD,
                                        MARDESCRICAO,
                                        MODDESCRICAO,
                                        CARPRECO,
                                        CARANO,
                                        CARFOTO,
                                        CARPORTAS,
                                        CONCAT(mundescricao,' - ',munuf) AS Localizacao
                                        FROM kgctblcar
                                        INNER JOIN kgctblmar
                                        ON CARCODMARCA = MARCOD
                                        INNER JOIN kgctblMOD
                                        ON CARCODMODELO = MODCOD
                                        inner join kgctblmun
                                        on carcodmunicipio = muncodigoibge
                                        where 1=1 $filtro $ord LIMIT $inicio,$maximo";
        $smtp = $pdo->prepare($query);
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }

    function DeletaCarroPorCod($cod){
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("delete from kgctblcar where carcod = $cod");


            $smtp->execute();

            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    public function AtualizaInfoComp($sqlInfoComp)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare($sqlInfoComp);
        $smtp->execute();

        $result = $smtp->rowCount();

        if($result > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function VerificaExisteInfoComp($codCar){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT DETCOD FROM kgctbldetcar where DETCODCARRO = $codCar");
        $smtp->execute();


        $result = $smtp->rowCount();

        if($result > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function BuscaCodInfoComp($codCar){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT min(DETCOD) as DETCOD FROM kgctbldetcar where DETCODCARRO = $codCar");
        $smtp->execute();


        $result = $smtp->fetchAll(PDO::FETCH_CLASS);

        return $result[0]->DETCOD;
    }

    public function InsereDetCarro($codCar,$usu){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("INSERT INTO kgctbldetcar (DETUSER, DETDATCADASTRO,DETCODCARRO) values ('$usu',CURRENT_TIMESTAMP,$codCar)");
        $smtp->execute();

        return $result = $smtp->rowCount();
    }

    function SelecionaCarroPorCod($cod){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CARNOME,
                                        CARCODMARCA,
                                        CARCODMODELO,
                                        CARPRECO,
                                        CARANO,
                                        CARFOTO,
                                        CARCODSTATUS,
                                        CARKM,
                                        CARCODCAMBIO,
                                        CARPORTAS,
                                        CARCODCOMBUSTIVEL,
                                        CARCODCOR,
                                        CARTROCA,
                                        CARDESTAQUE,
                                        CARDATCADASTRO,
                                        CARCODMUNICIPIO,
                                        CARUF
                                FROM kgctblcar
                                WHERE CARCOD = $cod");
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }


    function InsereCarro($sqlInsert)
    {  
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $smtp = $pdo->prepare($sqlInsert);
        $smtp->execute();


        return $result = $smtp->rowCount();
    }
    

    function AtualizaCarro($sqlUpdate)
    {  
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $smtp = $pdo->prepare($sqlUpdate);
        $smtp->execute();


        return $result = $smtp->rowCount();
    }

    public function BuscaUltimoCodCarroUser($vxvaUser){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("select max(carcod) AS CARCOD FROM KGCTBLCAR WHERE CARUSER = '$vxvaUser' ORDER BY CARCOD DESC;");
        $smtp->execute();
        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }
}
