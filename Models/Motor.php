<?php

class Motor{
    public $id;
    public $potencia;
    public $dtCadastro;
    public $user;

    public function Anuncios()
    {
        $id = null;
        $potencia = null;
        $dtCadastro = null;
        $user = null;
    }

    public function InserirMotor()
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


    public function SelecionarMotorPorCod($codMot)
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
        FROM kgctblsolanu
        inner join KGCTBLMAR   ON MARCOD = SOLCODMARCA
        INNER JOIN KGCTBLMOD   ON MODCOD = SOLCODMODELO
        inner join KGCTBLCOR   ON CORCOD = SOLCOR
        inner join KGCTBLCAM   ON CAMCOD = SOLCAMBIO
        inner join KGCTBLCOM   ON COMCOD = SOLCOMBUSTIVEL where SOLCOD = $codMot");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
        
    }

    public function SelecionarListaMotor()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT
                                MOTCOD,
                                MOTPOTENCIA
                                FROM kgctblMOT");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }
}

?>