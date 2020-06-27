<?php

class Marcas{
    public $Id;
    public $Descricao;
    public $Ativo;
    public $User;
    public $DtCadastro;



    public function __construct()
    {
         $Id = null;
         $Descricao = null;
         $Ativo = null;
         $User = null;
         $DtCadastro = null;
    }


    public function InsereMarca(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("INSERT INTO KGCTBLMAR 
        (MARDESCRICAO, MARATIVO, MARUSER, MARDATCADASTRO)
        VALUES
        ('$this->Descricao','$this->Ativo','$this->User',CURRENT_TIMESTAMP)");
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

            $smtp = $pdo->prepare("SELECT MAX(MARCOD) AS ULTIMO FROM KGCTBLMAR WHERE MARUSER = '$this->User'");
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
    public function AtualizaMarca()
    {
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("UPDATE KGCTBLMAR SET
            MARDESCRICAO = '$this->Descricao'
            ,MARATIVO = '$this->Ativo'
            WHERE MARCOD = $this->Id");
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


    public function SelecionarListaMarcas(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MARCOD, MARDESCRICAO FROM KGCTBLMAR WHERE MARATIVO = 'S' order by MARDESCRICAO ASC");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 
    
    public function SelecionarListaTodasMarcas(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MARCOD, MARDESCRICAO, MARATIVO, MARDATCADASTRO FROM KGCTBLMAR order by MARDESCRICAO ASC");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 




    public function SelecionarMarcaPorCod($codMarca){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MARDESCRICAO, MARATIVO, MARDATCADASTRO FROM KGCTBLMAR where MARCOD = $codMarca");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 

    public function VerificaExisteModeloParaMarca($codMarca){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT * FROM KGCTBLMOD where MODCODMARCA = $codMarca");
        $smtp->execute();


        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 


    public function DeletaMarcaPorCod($codMarca){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("DELETE FROM KGCTBLMAR where MARCOD = $codMarca");
        $smtp->execute();

        $res = $smtp->rowCount();

        if($res > 0){
            return true;
        }
        else{
            return false;
        }
    } 


    public function SelecionarTotalMarcas()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COUNT(*) AS NUMMARCA FROM KGCTBLMAR");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

}