<?php

class Cores{
    public $id;
    public $descricao;
    public $dtCadastro;
    public $user;

    
    public function SelecionarListaCores(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CORCOD, CORDESCRICAO FROM kgctblcor");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  
}

?>