<?php

class Versoes{
    public $Id;
    public $Versao;
    public $Marca;
    public $Modelo;
    public $DtCadastro;
    public $User;

    public function __construct()
    {
        $Id          = null;
        $Versao      = null;
        $Marca       = null;
        $Modelo      = null;
        $DtCadastro  = null;
        $User        = null;
    }

    public function InsereVersao(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("INSERT INTO KGCTBLVER (MARCOD,MODCOD,VERNOME,VERUSER,VERDTCADASTRO)
            VALUES(
            $this->Marca,
            $this->Modelo,
            '$this->Versao',
            '$this->User',
            CURRENT_TIMESTAMP)");
        $smtp->execute();
        $res = $smtp->rowCount();
        if ($res > 0) {
            return true;
        }
        else{
            return false;
        }
    } 

    public function BuscaUltimoCodPorUser(){
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("SELECT MAX(VERCOD) AS ULTIMO FROM KGCTBLVER WHERE VERUSER = '$this->User'");
            $smtp->execute();
            $result = $smtp->fetchAll(PDO::FETCH_CLASS);
            return $result[0]->ULTIMO;
        }
        catch(Exception $e){
            throw $e;
        }
    }

    public function SelecionarVersaoPorModelo($codModelo, $codMarca){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT VERCOD, VERNOME FROM KGCTBLVER
        WHERE MARCOD = $codMarca
        AND MODCOD = $codModelo");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 

    public function SelecionarModeloPorNome($Modelo){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MODCOD, MODDESCRICAO, MODCODMARCA, MODDATCADASTRO FROM KGCTBLMOD where MODDESCRICAO like '%$Modelo%'");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 

    public function DeletaModeloPorCod($codModelo){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("DELETE FROM KGCTBLMOD where MODCOD = $codModelo");
        $smtp->execute();

        $res = $smtp->rowCount();

        if($res > 0){
            return true;
        }
        else{
            return false;
        }
    } 

    public function AtualizaModelo()
    {
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("UPDATE KGCTBLMOD SET
            MODDESCRICAO = '$this->Descricao'
            ,MODCODMARCA = $this->Marca
            WHERE MODCOD = $this->Id");
            $smtp->execute();
            $res = $smtp->rowCount();

            if($res > 0){
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            throw $e;
        }
    }


    public function SelecionarListaTodosModelos(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MODCOD, MODDESCRICAO, MARDESCRICAO, MODDATCADASTRO FROM KGCTBLMOD
                                INNER JOIN KGCTBLMAR ON MARCOD = MODCODMARCA order by MARDESCRICAO,MODDESCRICAO ASC");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

    public function SelecionarTotalModelos()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COUNT(*) AS NUMMODELOS FROM KGCTBLMOD");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }
    
    public function SelecionarListaModelos(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MODCOD, MODDESCRICAO FROM KGCTBLMOD");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  

    public function SelecionarListaModelosPorVariasMarca($SqlModelo)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare($SqlModelo);
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }


    public function SelecionarListaModelosPorMarca($CODMARCA){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MODCOD, MODDESCRICAO FROM KGCTBLMOD where MODCODMARCA = ".$CODMARCA);
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  

}