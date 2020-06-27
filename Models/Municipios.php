<?php

class Municipios{
    public $id;
    public $descricao;
    public $Uf;
    public $dtCadastro;
    public $user;

    
    public function SelecionarListaMunicipios(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MUNCODIGOIBGE, MUNDESCRICAO FROM KGCTBLMUN");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  

    

public function SelecionarListaUf(){
    $pdo = new PDO(server, user, senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $smtp = $pdo->prepare("SELECT MUNUF FROM KGCTBLMUN GROUP BY MUNUF");
    $smtp->execute();

    if ($smtp->rowCount() > 0) {
        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
    }
}  

    public function SelecionarListaMunicipiosPorUf($Uf){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MUNCODIGOIBGE, MUNDESCRICAO FROM KGCTBLMUN
                                where MUNUF = '".$Uf."'");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }  


    

}