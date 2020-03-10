<?php

class Combustiveis{
    public $Id;
    public $Descricao;
    public $DtCadastro;
    public $User;

    public function Combustiveis()
    {
         $Id = null;
         $Descricao = null;
         $User = null;
         $DtCadastro = null;
    }


    public function InsereCombustivel(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("INSERT INTO kgctblcOm 
        (COMDESCRICAO, COMUSER, COMDATCADASTRO)
        VALUES
        ('$this->Descricao','$this->User',CURRENT_TIMESTAMP)");
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

            $smtp = $pdo->prepare("SELECT MAX(COMCOD) AS ULTIMO FROM KGCTBLCOM WHERE COMUSER = '$this->User'");
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
    public function AtualizaCombustivel()
    {
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("UPDATE kgctblcOm SET
            COMDESCRICAO = '$this->Descricao'
            WHERE COMCOD = $this->Id");
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
    
    public function SelecionarListaCombustivel(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COMCOD, COMDESCRICAO, COMDATCADASTRO FROM kgctblcom");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  

    public function SelecionarCombustivelPorCod($codComb){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COMCOD, COMDESCRICAO, COMDATCADASTRO FROM kgctblcOm where COMCOD = $codComb");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 


    public function DeletaCombustivelPorCod($codComb){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("DELETE FROM kgctblcom where COMCOD = $codComb");
        $smtp->execute();

        $res = $smtp->rowCount();

        if($res > 0){
            return true;
        }
        else{
            return false;
        }
    } 


    public function SelecionarTotalCombustivel()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COUNT(*) AS NUMCOMBUSTIVEL FROM kgctblcom");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }
}
?>