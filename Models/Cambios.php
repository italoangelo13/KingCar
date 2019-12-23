<?php

class Cambios{
    public $id;
    public $descricao;
    public $dtCadastro;
    public $user;

    
    public function SelecionarListaCambio(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT CAMCOD, CAMDESCRICAO FROM kgctblcam");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  
}
?>