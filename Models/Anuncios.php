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

    public function __construct()
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


    public function SelecionarTotalAnuncio()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COUNT(*) AS NUMANUNCIO FROM KGCTBLSOLANU");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

    public function SelecionarAnuncioPorCod($codAnun)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT
        SOLCOD,
        SOLANOME,
        SOLEMAIL,
        CONCAT(MARDESCRICAO,' ',MODDESCRICAO,' ',SOLANO) AS VEICULO,
        SOLDTCADASTRO,
        SOLANO,
        SOLFOTOCAPA,
        MARDESCRICAO,
        MODDESCRICAO,
        CORDESCRICAO,
        CAMDESCRICAO,
        COMDESCRICAO,
        SOLKM,
        SOLPRECO,
        SOLTROCA
        FROM KGCTBLSOLANU
        inner join KGCTBLMAR   ON MARCOD = SOLCODMARCA
        INNER JOIN KGCTBLMOD   ON MODCOD = SOLCODMODELO
        inner join KGCTBLCOR   ON CORCOD = SOLCOR
        inner join KGCTBLCAM   ON CAMCOD = SOLCAMBIO
        inner join KGCTBLCOM   ON COMCOD = SOLCOMBUSTIVEL where SOLCOD = $codAnun");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
        
    }

    public function SelecionarListaAnuncio()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT
                                SOLCOD,
                                SOLANOME,
                                SOLEMAIL,
                                CONCAT(MARDESCRICAO,' ',MODDESCRICAO,' ',SOLANO) AS VEICULO,
                                SOLDTCADASTRO,
                                SOLFOTOCAPA
                                FROM KGCTBLSOLANU
                                inner join KGCTBLMAR
                                ON MARCOD = SOLCODMARCA
                                INNER JOIN KGCTBLMOD
                                ON MODCOD = SOLCODMODELO");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }
}

?>