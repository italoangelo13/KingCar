<?php

class Institucional{
    public $Sobre;
    public $Diferencial;
    public $Visao;
    public $Missao;
    public $Valores;

    public function __construct()
    {
        $Sobre = null;
        $Diferencial = null;
        $Visao = null;
        $Missao = null;
        $Valores = null;
    }


    public function InsereInstitucional(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("INSERT INTO KGCTBLINST 
        (INSTSOBRENOS, INSTDIFERENCIAL, INSTVISAO, INSTMISSAO, INSTVALORES)
        VALUES
        ('$this->Sobre','$this->Diferencial','$this->Visao','$this->Missao','$this->Valores')");
        $smtp->execute();
        $res = $smtp->rowCount();
        if ($res > 0) {
            return true;
        }
        else{
            return false;
        }
    } 

    
    public function AtualizaInstitucional()
    {
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("UPDATE KGCTBLINST SET
            INSTSOBRENOS = '$this->Sobre'
            ,INSTDIFERENCIAL = '$this->Diferencial'
            ,INSTVISAO = '$this->Visao'
            ,INSTMISSAO = '$this->Missao'
            ,INSTVALORES = '$this->Valores'");
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
    
    public function ExisteInstitucional(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT count(*) as linhas FROM KGCTBLINST");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            $result = $smtp->fetchAll(PDO::FETCH_CLASS);
            if($result[0]->linhas > 0){
                return true;
            }
            else{
                return false;
            }
        }
    }  



    


    public function SelecionarInfoInstitucional()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $smtp = $pdo->prepare("SELECT INSTSOBRENOS, INSTDIFERENCIAL, INSTVISAO, INSTMISSAO, INSTVALORES FROM KGCTBLINST");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
             $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }

        return $result;
    }
}
?>