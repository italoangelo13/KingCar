<?php

class Publicidades{
    public $id;
    public $descricao;
    public $dtCadastro;
    public $user;

    
    public function SelecionarListaPublicidades(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT
            PUBIMG,
            PUBLINK
            FROM kgctblpub
            order by PUBDATCADASTRO desc");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  
}

?>