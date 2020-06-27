<?php
class Erros{
    public $id;
    public $trace;
    public $msg;
    public $tela;
    public $classe;
    public $dtCadastro;

    public function __construct()
    {
        $id = null;
        $trace = null;
        $tela = null;
        $classe = null;
        $dtCadastro = null;
        $msg = null;
    }

    public function InserirErroSistema()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO kgctblerr(
            ERRDATCADASTRO, ERRSTACKTRACE, ERRMSG, ERRTELA, ERRCLASSE)
            VALUES(
            CURRENT_TIMESTAMP, '$this->trace', '$this->assunto', '$this->msg',";
        if($this->tela == null){
            $sql .= "null,";
        }
        else{
            $sql .= "'$this->tela',";
        }

        if($this->classe == null){
            $sql .= "null)";
        }
        else{
            $sql .= "'$this->classe')";
        }
        
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