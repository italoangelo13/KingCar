<?php

class Publicidades{
    public $Id;
    public $Empresa;
    public $Titulo;
    public $Link;
    public $Imagem;
    public $DtCadastro;
    public $User;



    public function Publicidades()
    {
        $Id = null;
        $Empresa = null;
        $Titulo = null;
        $Link = null;
        $Imagem = null;
        $DtCadastro = null;
        $User = null;
    }

    
    public function SelecionarListaPublicidades(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT
            PUBCOD,
            PUBTITULO,
            PUBIMG,
            PUBEMPRESA,
            PUBDATCADASTRO,
            PUBLINK
            FROM kgctblpub
            order by PUBDATCADASTRO desc");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 

    public function BuscaUltimoCodPorUser(){
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("SELECT MAX(PUBCOD) AS ULTIMO FROM KGCTBLPUB WHERE PUBUSER = '$this->User'");
            $smtp->execute();
            $result = $smtp->fetchAll(PDO::FETCH_CLASS);
            return $result[0]->ULTIMO;
        }
        catch(Exception $e){
            throw $e;
        }
    }

    public function SelecionarTotalPublicidade()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COUNT(*) AS NUMPUB FROM kgctblpub");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

    public function InserePublicidade(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("INSERT INTO kgctblpub
           (PUBTITULO,
            PUBIMG,
            PUBEMPRESA,
            PUBLINK,
            PUBDATCADASTRO,
            PUBUSER)
        VALUES
        ('$this->Titulo','$this->Imagem','$this->Empresa','$this->Link',CURRENT_TIMESTAMP,'$this->User')");
        $smtp->execute();
        $res = $smtp->rowCount();
        if ($res > 0) {
            return true;
        }
        else{
            return false;
        }
    } 

    public function DeletaPublicidadePorCod($codPub){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("DELETE FROM kgctblpub where PUBCOD = $codPub");
        $smtp->execute();

        $res = $smtp->rowCount();

        if($res > 0){
            return true;
        }
        else{
            return false;
        }
    } 

    public function SelecionarPublicidadePorCod($codPub){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT PUBCOD, PUBEMPRESA, PUBTITULO, PUBLINK, PUBIMG, PUBDATCADASTRO FROM kgctblpub where PUBCOD = $codPub");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 

    public function SelecionarImagemPublicidadePorCod($codPub){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT PUBIMG FROM kgctblpub where PUBCOD = $codPub");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    } 

    public function AtualizaPublicidade()
    {
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("UPDATE kgctblpub SET
            PUBEMPRESA = '$this->Empresa',
            PUBTITULO = '$this->Titulo',
            PUBLINK = '$this->Link',
            PUBIMG = '$this->Imagem'
            WHERE PUBCOD = $this->Id");
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

}

?>