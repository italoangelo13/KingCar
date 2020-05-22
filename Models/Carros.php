<?php

class Carros
{
    public $Id;
    public $DtCadastro;
    public $User;
    public $Placa;
    public $TipoAnuncio;
    public $Carroceria;
    public $Destaque;
    public $Status;
    public $Marca;
    public $Modelo;
    public $Versao;
    public $AnoFab;
    public $AnoMod;
    public $Motor;
    public $Valvulas;
    public $Km;
    public $Cambio;
    public $Combustivel;
    public $Portas;
    public $Cor;
    public $Uf;
    public $Municipio;
    public $ImgCapa;
    public $Troca;
    public $NomeAnunciante;
    public $EmailAnunciante;
    public $TelAnunciante;
    public $Preco;

    public function Carros() {
        $Id = null;
        $DtCadastro = null;
        $User = null;
        $Placa = null;
        $TipoAnuncio = null;
        $Carroceria = null;
        $Destaque = null;
        $Status = null;
        $Marca = null;
        $Modelo = null;
        $Versao = null;
        $AnoFab = null;
        $AnoMod = null;
        $Motor = null;
        $Valvulas = null;
        $Km = null;
        $Cambio = null;
        $Combustivel = null;
        $Portas = null;
        $Cor = null;
        $Uf = null;
        $Municipio = null;
        $ImgCapa = null;
        $Troca = null;
        $NomeAnunciante = null;
        $EmailAnunciante = null;
        $TelAnunciante = null;
        $Preco = null;
    }

    


    public function SelecionarVeiculosGrid()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CARCOD,
        MARDESCRICAO,
        MODDESCRICAO,
        CARPRECO,
        CONCAT(CARANOFAB,'/',CARANOMOD) AS CARANO,
        CARFOTO
        FROM kgctblcar
        INNER JOIN kgctblmar
        ON CARCODMARCA = MARCOD
        INNER JOIN kgctblMOD
        ON CARCODMODELO = MODCOD");

        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

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
        CONCAT(mundescricao,' - ',munuf) AS LOCALIZACAO,
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
        ORDER BY CARQTDEVISITAS DESC limit 12");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

    public function SelecionarListaCarrosCompleto()
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
        CONCAT(mundescricao,' - ',munuf) AS LOCALIZACAO,
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

    public function SelecionarListaCarrosCompletoRepasse()
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
        CONCAT(mundescricao,' - ',munuf) AS LOCALIZACAO,
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
        on carcodmunicipio = muncodigoibge where CARREPASSE = 'S'
        ORDER BY CARQTDEVISITAS DESC");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

    public function SelecionarListaCarrosCompletoSinistrados()
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
        CONCAT(mundescricao,' - ',munuf) AS LOCALIZACAO,
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
        on carcodmunicipio = muncodigoibge where CARSINISTRADO = 'S'
        ORDER BY CARQTDEVISITAS DESC");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

    public function UtualizaNumVisitas($codCarro)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $smtp = $pdo->prepare("SELECT (CARQTDEVISITAS + 1) AS QTDE FROM KGCTBLCAR WHERE CARCOD = $codCarro");
        $smtp->execute();
        $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        $qtdeAtu = $result[0]->QTDE;
        $smtp = $pdo->prepare("UPDATE KGCTBLCAR SET CARQTDEVISITAS = $qtdeAtu WHERE CARCOD = $codCarro");
        $smtp->execute();
        $result = $smtp->rowCount();
        if ($result > 0) {
            return true;
        } else {
            return false;
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

    public function SelecionarPrecoMinMax()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT min(CARPRECO) as MENOR, max(CARPRECO) as MAIOR FROM kgctblcar");
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

    public function SelecionarNumCarrosDetIncompletos($SQLCARDET)
    {
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

    public function SelecionarListaCarrosFiltroPaginado($sql)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare($sql);
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }

    public function SelecionarCarro($codCarro)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CARCOD,MARDESCRICAO,MODDESCRICAO,CARPRECO,CARANO,CARFOTO,CARKM,CARPORTAS,CARTROCA,CARDESTAQUE,CAMDESCRICAO, COMDESCRICAO,CORDESCRICAO,CORCODHEXADECIMAL,CONCAT(mundescricao,' - ',munuf) AS LOCALIZACAO
                                FROM kgctblCAR
                                INNER JOIN kgctblmar ON CARCODMARCA = MARCOD
                                INNER JOIN kgctblMOD ON CARCODMODELO = MODCOD
                                inner join kgctblmun on carcodmunicipio = muncodigoibge
                                INNER JOIN kgctblCOR ON CARCODCOR = CORCOD
                                INNER JOIN kgctblcom ON CARCODCOMBUSTIVEL = comCOD
                                INNER JOIN kgctblCAM ON CARCODCAMBIO = CAMCOD
                                where carcod =" . $codCarro);
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }

    public function SelecionarDetCarro($codCarro)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT DETVIDELETRICA, DETTRAELETRICA, DETDIRHIDRAULICA, DETALARME, DETFARMILHA, DETFARXENON, DETARQUENTE, DETARCONDICIONADO, DETBANCOURO, DETSOMVOLANTE, DETDESEMBTRASEIRO, DETDIRELETRICA, DETFARNEBLINA, DETFREIOABS, DETGPS, DETMULTIMIDIA, DETPORTACOPOS, DETRETROELETRICO, DETRODLIGA, DETTETOSOLAR, DETAIRBAGLAT, DETAIRBAGMOT, DETAIRBAGPAS, DETBANAJUSTAVEL, DETCAMRE, DETCD, DETDVD, DETBLUERAY, DETCOMPBORDO, DETENCTRASEIRO, DETUSB, DETPILOTOAUTO, DETSENSOREST, DETVOLAJUSTAVEL, DETUNICODONO, DETINFOCOMP
                                FROM kgctbldetcar where DETCODCARRO =" . $codCarro);
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_ASSOC);
    }

    function SelecionaCarrosPaginadosPesq($inicio, $maximo, $filtro, $ord)
    {
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

    function DeletaCarroPorCod($cod)
    {
        try {
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("delete from kgctblcar where carcod = $cod");


            $smtp->execute();

            return true;
        } catch (Exception $e) {
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

        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function VerificaExisteInfoComp($codCar)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT DETCOD FROM kgctbldetcar where DETCODCARRO = $codCar");
        $smtp->execute();


        $result = $smtp->rowCount();

        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function BuscaCodInfoComp($codCar)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT min(DETCOD) as DETCOD FROM kgctbldetcar where DETCODCARRO = $codCar");
        $smtp->execute();


        $result = $smtp->fetchAll(PDO::FETCH_CLASS);

        return $result[0]->DETCOD;
    }

    public function InsereDetCarro($codCar, $usu)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("INSERT INTO kgctbldetcar (DETUSER, DETDATCADASTRO,DETCODCARRO) values ('$usu',CURRENT_TIMESTAMP,$codCar)");
        $smtp->execute();

        return $result = $smtp->rowCount();
    }

    function InsereItensCarro($item,$codCarro,$usuario)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $smtp = $pdo->prepare("INSERT INTO KGCTBLIVE
                                (IVECODCARRO, IVECODITEM, IVEUSER, IVEDTCADASTRO)
                                VALUES
                                ($codCarro, $item, '$usuario', CURRENT_TIMESTAMP)");
        $smtp->execute();
        $result = $smtp->rowCount();
        if($result > 0){
            return true;
        }
        else{
            return false;
        }
    }

    function SelecionaCarroPorCod($cod)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CARCOD,CARCODSTATUS,CARDATCADASTRO,CARUF,CARCODMUNICIPIO,CARCODCAMBIO,CARCODCOMBUSTIVEL,CARCODMARCA,CARCODMODELO,CARCODCOR,MARDESCRICAO,MODDESCRICAO,CARPRECO,CARANO,CARFOTO,CARKM,CARPORTAS,CARTROCA,CARDESTAQUE,CAMDESCRICAO, COMDESCRICAO,CORDESCRICAO,CORCODHEXADECIMAL,CONCAT('#',CARCOD,' - ',MODDESCRICAO,' ',CARANO) AS CARNOME,CONCAT(mundescricao,' - ',munuf) AS LOCALIZACAO
        FROM kgctblCAR
        INNER JOIN kgctblmar ON CARCODMARCA = MARCOD
        INNER JOIN kgctblMOD ON CARCODMODELO = MODCOD
        inner join kgctblmun on carcodmunicipio = muncodigoibge
        INNER JOIN kgctblCOR ON CARCODCOR = CORCOD
        INNER JOIN kgctblcom ON CARCODCOMBUSTIVEL = comCOD
        INNER JOIN kgctblCAM ON CARCODCAMBIO = CAMCOD
                                WHERE CARCOD = $cod");
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }

    function SelecionaVeiculoPorCodParaAtualizacao($cod)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CARCOD, CARCODMARCA, CARCODMODELO, CARPRECO, CARANOFAB, CARFOTO, CARCODSTATUS, CARKM, CARCODCAMBIO, CARPORTAS, CARCODCOMBUSTIVEL, CARCODCOR, CARPLACA, CARTROCA, CARDESTAQUE, CARCODMUNICIPIO, CARUF, CARANOMOD, CARVERSAO, CARREPASSE, CARSINISTRADO, CARMOTOR, CARVALVULAS, CARCARROCERIA, CARNOMEANUNCIANTE, CAREMAILANUNCIANTE, CARTELANUNCIANTE
        FROM kgctblcar WHERE CARCOD = $cod");
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }

    function SelecionaCarroRepassePorCod($cod)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CARCOD,CARCODSTATUS,CARDATCADASTRO,CARUF,CARCODMUNICIPIO,CARCODCAMBIO,CARCODCOMBUSTIVEL,CARCODMARCA,CARCODMODELO,CARCODCOR,MARDESCRICAO,MODDESCRICAO,CARPRECO,CARANO,CARFOTO,CARKM,CARPORTAS,CARTROCA,CARDESTAQUE,CAMDESCRICAO, COMDESCRICAO,CORDESCRICAO,CORCODHEXADECIMAL,CONCAT('#',CARCOD,' - ',MODDESCRICAO,' ',CARANO) AS CARNOME,CONCAT(mundescricao,' - ',munuf) AS LOCALIZACAO
        FROM kgctblCAR
        INNER JOIN kgctblmar ON CARCODMARCA = MARCOD
        INNER JOIN kgctblMOD ON CARCODMODELO = MODCOD
        inner join kgctblmun on carcodmunicipio = muncodigoibge
        INNER JOIN kgctblCOR ON CARCODCOR = CORCOD
        INNER JOIN kgctblcom ON CARCODCOMBUSTIVEL = comCOD
        INNER JOIN kgctblCAM ON CARCODCAMBIO = CAMCOD
                                WHERE CARCOD = $cod and CARREPASSE = 'S'");
        $smtp->execute();


        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }

    function SelecionaCarroSinistradoPorCod($cod)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CARCOD,CARCODSTATUS,CARDATCADASTRO,CARUF,CARCODMUNICIPIO,CARCODCAMBIO,CARCODCOMBUSTIVEL,CARCODMARCA,CARCODMODELO,CARCODCOR,MARDESCRICAO,MODDESCRICAO,CARPRECO,CARANO,CARFOTO,CARKM,CARPORTAS,CARTROCA,CARDESTAQUE,CAMDESCRICAO, COMDESCRICAO,CORDESCRICAO,CORCODHEXADECIMAL,CONCAT('#',CARCOD,' - ',MODDESCRICAO,' ',CARANO) AS CARNOME,CONCAT(mundescricao,' - ',munuf) AS LOCALIZACAO
        FROM kgctblCAR
        INNER JOIN kgctblmar ON CARCODMARCA = MARCOD
        INNER JOIN kgctblMOD ON CARCODMODELO = MODCOD
        inner join kgctblmun on carcodmunicipio = muncodigoibge
        INNER JOIN kgctblCOR ON CARCODCOR = CORCOD
        INNER JOIN kgctblcom ON CARCODCOMBUSTIVEL = comCOD
        INNER JOIN kgctblCAM ON CARCODCAMBIO = CAMCOD
                                WHERE CARCOD = $cod and CARSINISTRADO = 'S'");
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

    function InsereCarroSemiNovo()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $smtp = $pdo->prepare("INSERT INTO KGCTBLCAR
        (CARCODMARCA, CARCODMODELO, CARPRECO, CARANOFAB, CARFOTO, CARCODSTATUS, CARKM, CARCODCAMBIO, CARPORTAS, CARCODCOMBUSTIVEL, CARCODCOR, CARPLACA, CARTROCA, CARDESTAQUE, CARDATCADASTRO, CARUSER, CARCODMUNICIPIO, CARUF, CARQTDEVISITAS, CARANOMOD, CARVERSAO, CARREPASSE, CARSINISTRADO, CARMOTOR, CARVALVULAS, CARCARROCERIA, CARCATEGORIA, CARNOMEANUNCIANTE, CAREMAILANUNCIANTE, CARTELANUNCIANTE)
        VALUES
        ($this->Marca, $this->Modelo, $this->Preco, '$this->AnoFab', '$this->ImgCapa', '$this->Status', $this->Km, $this->Cambio, $this->Portas, $this->Combustivel, $this->Cor, '$this->Placa', '$this->Troca', '$this->Destaque', CURRENT_TIMESTAMP, '$this->User', $this->Municipio, '$this->Uf', 0, '$this->AnoMod', $this->Versao, 'N', 'N', $this->Motor, $this->Valvulas, $this->Carroceria, 1, '$this->NomeAnunciante', '$this->EmailAnunciante', '$this->TelAnunciante')");
        $smtp->execute();
        $result = $smtp->rowCount();
        if($result > 0){
            return true;
        }
        else{
            return false;
        }
    }

    function InsereCarroRepasse()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $smtp = $pdo->prepare("INSERT INTO KGCTBLCAR
        (CARCODMARCA, CARCODMODELO, CARPRECO, CARANOFAB, CARFOTO, CARCODSTATUS, CARKM, CARCODCAMBIO, CARPORTAS, CARCODCOMBUSTIVEL, CARCODCOR, CARPLACA, CARTROCA, CARDESTAQUE, CARDATCADASTRO, CARUSER, CARCODMUNICIPIO, CARUF, CARQTDEVISITAS, CARANOMOD, CARVERSAO, CARREPASSE, CARSINISTRADO, CARMOTOR, CARVALVULAS, CARCARROCERIA, CARCATEGORIA, CARNOMEANUNCIANTE, CAREMAILANUNCIANTE, CARTELANUNCIANTE)
        VALUES
        ($this->Marca, $this->Modelo, $this->Preco, '$this->AnoFab', '$this->ImgCapa', '$this->Status', $this->Km, $this->Cambio, $this->Portas, $this->Combustivel, $this->Cor, '$this->Placa', '$this->Troca', '$this->Destaque', CURRENT_TIMESTAMP, '$this->User', $this->Municipio, '$this->Uf', 0, '$this->AnoMod', $this->Versao, 'S', 'N', $this->Motor, $this->Valvulas, $this->Carroceria, 1, '$this->NomeAnunciante', '$this->EmailAnunciante', '$this->TelAnunciante')");
        $smtp->execute();
        $result = $smtp->rowCount();
        if($result > 0){
            return true;
        }
        else{
            return false;
        }
    }

    function InsereCarroSinistrado()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $smtp = $pdo->prepare("INSERT INTO KGCTBLCAR
        (CARCODMARCA, CARCODMODELO, CARPRECO, CARANOFAB, CARFOTO, CARCODSTATUS, CARKM, CARCODCAMBIO, CARPORTAS, CARCODCOMBUSTIVEL, CARCODCOR, CARPLACA, CARTROCA, CARDESTAQUE, CARDATCADASTRO, CARUSER, CARCODMUNICIPIO, CARUF, CARQTDEVISITAS, CARANOMOD, CARVERSAO, CARREPASSE, CARSINISTRADO, CARMOTOR, CARVALVULAS, CARCARROCERIA, CARCATEGORIA, CARNOMEANUNCIANTE, CAREMAILANUNCIANTE, CARTELANUNCIANTE)
        VALUES
        ($this->Marca, $this->Modelo, $this->Preco, '$this->AnoFab', '$this->ImgCapa', '$this->Status', $this->Km, $this->Cambio, $this->Portas, $this->Combustivel, $this->Cor, '$this->Placa', '$this->Troca', '$this->Destaque', CURRENT_TIMESTAMP, '$this->User', $this->Municipio, '$this->Uf', 0, '$this->AnoMod', $this->Versao, 'N', 'S', $this->Motor, $this->Valvulas, $this->Carroceria, 1, '$this->NomeAnunciante', '$this->EmailAnunciante', '$this->TelAnunciante')");
        $smtp->execute();
        $result = $smtp->rowCount();
        if($result > 0){
            return true;
        }
        else{
            return false;
        }
    }


    function AtualizaCarro($sqlUpdate)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $smtp = $pdo->prepare($sqlUpdate);
        $smtp->execute();


        return $result = $smtp->rowCount();
    }

    public function BuscaItemPorCod($d)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("select COMPCOD FROM kgctblinfocomp WHERE COMPNOMCAMPO = '$d'");
        $smtp->execute();
        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }

    public function BuscaUltimoCodCarroUser($vxvaUser)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("select max(carcod) AS CARCOD FROM KGCTBLCAR WHERE CARUSER = '$vxvaUser';");
        $smtp->execute();
        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }

    public function SelecionarVeiculosPorQtdeVisitas()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT
        CARCOD,
        CONCAT(MARDESCRICAO,' ',MODDESCRICAO,' ',CORDESCRICAO,' ',CARANO,' - ',COMDESCRICAO) AS VEICULO,
        CARPRECO,
        CARDESTAQUE,
        CARTROCA,
        CARQTDEVISITAS
        FROM kgctblcar
        inner join KGCTBLMAR   ON MARCOD = CARCODMARCA
        INNER JOIN KGCTBLMOD   ON MODCOD = CARCODMODELO
        inner join KGCTBLCOR   ON CORCOD = CARCODCOR
        inner join KGCTBLCOM   ON COMCOD = CARCODCOMBUSTIVEL
        order by carqtdevisitas desc
        limit 10");
        $smtp->execute();
        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }
}
