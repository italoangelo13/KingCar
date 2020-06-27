<?php

class Cores{
    public $Id;
    public $Descricao;
    public $Hexadecimal;
    public $DtCadastro;
    public $User;



    public function __construct()
    {
        $Id = null;
        $Descricao = null;
        $Hexadecimal = null;
        $DtCadastro = null;
        $User = null;
    }

    public function InsereCor(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("INSERT INTO KGCTBLCOR
        (CORDESCRICAO, CORCODHEXADECIMAL, CORUSER, CORDATCADASTRO)
        VALUES
        ('$this->Descricao','$this->Hexadecimal','$this->User',CURRENT_TIMESTAMP)");
        $smtp->execute();
        $res = $smtp->rowCount();
        if ($res > 0) {
            return true;
        }
        else{
            return false;
        }
    } 

    public function SelecionarCorPorCod($codCor){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CORDESCRICAO, CORCODHEXADECIMAL, CORDATCADASTRO FROM KGCTBLCOR where CORCOD = $codCor");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 

    public function BuscaUltimoCodPorUser(){
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("SELECT MAX(CORCOD) AS ULTIMO FROM KGCTBLCOR WHERE CORUSER = '$this->User'");
            $smtp->execute();
            $result = $smtp->fetchAll(PDO::FETCH_CLASS);
            return $result[0]->ULTIMO;
        }
        catch(Exception $e){
            throw $e;
        }
    }

    /**
    * Atualiza Marca
    *
    * Este Método Atualiza uma Marca.
    *
    * @access   public
    */
    public function AtualizaCor()
    {
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("UPDATE KGCTBLCOR SET
            CORDESCRICAO = '$this->Descricao'
            ,CORCODHEXADECIMAL = '$this->Hexadecimal'
            WHERE CORCOD = $this->Id");
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

    public function DeletaCorPorCod($codCor){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("DELETE FROM KGCTBLCOR where CORCOD = $codCor");
        $smtp->execute();

        $res = $smtp->rowCount();

        if($res > 0){
            return true;
        }
        else{
            return false;
        }
    } 
    
    public function SelecionarListaCores(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CORCOD, CORDESCRICAO, CORCODHEXADECIMAL, CORDATCADASTRO FROM KGCTBLCOR");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  

    public function SelecionarTotalCores()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COUNT(*) AS NUMCORES FROM KGCTBLCOR");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }
}

?>