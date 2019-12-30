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
