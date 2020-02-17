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
    public $imagem;
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
        $imagem = null;
    }

    public function InserirSolicitacaoAnuncio()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO KGCTBLSOLANU
        (SOLANOME,
        SOLEMAIL,
        SOLCODMARCA,
        SOLCODMODELO,
        SOLCAMBIO,
        SOLCOMBUSTIVEL,
        SOLCOR,
        SOLANO,
        SOLKM,
        SOLPRECO,
        SOLFOTOCAPA,
        SOLUSER,
        SOLDTCADASTRO)
        VALUES
        ('$this->nome',
        '$this->email',
        $this->marca,
        $this->modelo,
        $this->cambio,
        $this->combustivel,
        $this->cor,
        $this->ano,
        $this->km,
        $this->preco,
        '$this->imagem',
        '$this->user',
        CURRENT_TIMESTAMP)";

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
}

?>