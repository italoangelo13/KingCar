<?php

class Carrocerias{
    public $Id;
    public $Descricao;
    public $DtCadastro;
    public $User;



    public function __construct()
    {
        $Id = null;
        $Descricao = null;
        $DtCadastro = null;
        $User = null;
    }

    public function SelecionarListaCarrocerias(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CRCCOD, CRCDESCRICAO FROM KGCTBLCRC order by CRCDESCRICAO asc");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  

}

?>