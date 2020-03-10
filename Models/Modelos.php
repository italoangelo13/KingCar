<?php

class Modelos{
    public $Id;
    public $Descricao;
    public $Marca;
    public $DtCadastro;
    public $User;

    public function Modelos()
    {
        $Id = null;
        $Descricao = null;
        $Marca = null;
        $DtCadastro = null;
        $User = null;
    }

    public function InsereModelo(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("INSERT INTO kgctblmod
        (MODDESCRICAO, MODCODMARCA, MODUSER, MODDATCADASTRO)
        VALUES
        ('$this->Descricao','$this->Marca','$this->User',CURRENT_TIMESTAMP)");
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

            $smtp = $pdo->prepare("SELECT MAX(MODCOD) AS ULTIMO FROM KGCTBLMOD WHERE MODUSER = '$this->User'");
            $smtp->execute();
            $result = $smtp->fetchAll(PDO::FETCH_CLASS);
            return $result[0]->ULTIMO;
        }
        catch(Exception $e){
            throw $e;
        }
    }

    public function SelecionarModeloPorCod($codModelo){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MODCOD, MODDESCRICAO, MODCODMARCA, MODDATCADASTRO FROM kgctblMOD where MODCOD = $codModelo");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 

    public function DeletaModeloPorCod($codModelo){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("DELETE FROM kgctblmod where MODCOD = $codModelo");
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

            $smtp = $pdo->prepare("UPDATE kgctblmod SET
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

        $smtp = $pdo->prepare("SELECT MODCOD, MODDESCRICAO, MARDESCRICAO, MODDATCADASTRO FROM kgctblmod
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

        $smtp = $pdo->prepare("SELECT COUNT(*) AS NUMMODELOS FROM kgctblmod");
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