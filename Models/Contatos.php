<?php

class Contatos{
    public $id;
    public $nome;
    public $email;
    public $tel;
    public $assunto;
    public $msg;
    public $dtCadastro;
    public $user;
    public $status;

    public function __construct()
    {
        $id = null;
        $nome = null;
        $email = null;
        $tel = null;
        $assunto = null;
        $msg = null;
        $user = null;
        $status = null;
    }

    public function InserirSolicitacaoContato()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO KGCTBLCON(
            CONNOME, CONEMAIL, CONASSUNTO, CONMENSAGEM,CONDATCADASTRO,CONSTATUS, CONTEL)
            VALUES(
            '$this->nome', '$this->email', '$this->assunto', '$this->msg',CURRENT_TIMESTAMP,'N', '$this->tel')";

        $smtp = $pdo->prepare($sql);
        $smtp->execute();


        $result = $smtp->rowCount();

        if($result > 0){
            return true;
        }
        else{
            return false;
        }
    }


    public function SelecionarNumSolicitacaoContatosNaoLidos()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COUNT(*) AS NUMCONTATOS FROM KGCTBLCON where CONSTATUS = 'N'");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

    public function SelecionarContatoPorCod($cod)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CONCOD, CONNOME, CONEMAIL, CONASSUNTO, CONMENSAGEM, CONDATCADASTRO, CONSTATUS,CONTEL FROM KGCTBLCON
        where CONCOD = $cod");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
        
    }

    public function AtualizaStatusContato($cod)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE KGCTBLCON SET CONSTATUS = 'S' WHERE CONCOD = $cod";

        $smtp = $pdo->prepare($sql);
        $smtp->execute();


        $result = $smtp->rowCount();

        if($result > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function SelecionarSolicitacoesContatos()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CONCOD, CONNOME, CONEMAIL, CONASSUNTO, CONMENSAGEM, CONDATCADASTRO, CONSTATUS, CONTEL FROM KGCTBLCON ");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }
}

?>