<?php

class Anuncios{
    public $id;
    public $nome;
    public $email;
    public $marca;
    public $modelo;
    public $cambio;
    public $combustivel;
    public $ano;
    public $preco;
    public $km;
    public $cor;
    public $troca;
    public $dtCadastro;
    public $user;

    public function Anuncios()
    {
        $id = null;
        $nome = null;
        $email = null;
        $marca = null;
        $modelo = null;
        $cambio = null;
        $combustivel = null;
        $ano = null;
        $preco = null;
        $km = null;
        $cor = null;
        $troca = null;
        $dtCadastro = null;
        $user = null;
    }

    public function InserirSolicitacaoAnuncio()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "";
        $smtp = $pdo->prepare($sql);
        $smtp->execute();


        return $result = $smtp->rowCount();
    }
}

?>