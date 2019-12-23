<?php

class Modelos{
    public $id;
    public $descricao;
    public $codMarca;
    public $dtCadastro;
    public $user;

    
    public function SelecionarListaModelos(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MODCOD, MODDESCRICAO FROM KGCTBLMOD");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  


    public function SelecionarListaModelosPorMarca($CODMARCA){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MODCOD, MODDESCRICAO FROM KGCTBLMOD where MODCODMARCA = ".$CODMARCA);
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  

}