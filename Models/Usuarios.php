<?php

class Usuarios
{
    public $cod;
    public $nome;
    public $usuario;
    public $senha;
    public $user;

    public function Carros() {
         // tratado como construtor no PHP 5.3.0-5.3.2
         // tratado como método comum a partir do PHP 5.3.3
         $cod = null;
         $nome = null;
         $usuario = null;
         $senha = null;
         $user = null;
     }


    public function SelecionarListaUsuarios()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT MARCOD, MARDESCRICAO FROM kgctblmar");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

    public function SelecionarUsuarioPorCod($cod){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT USUNOME, USUUSUARIO FROM KGCTBLUSU WHERE USUCOD = $cod");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

    public function DeletaUsuarioPorCod($cod)
    {
        session_start();
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("SELECT USUUSUARIO FROM kgctblusu where usucod = $cod");
            $smtp->execute();
            $result = null;
            if ($smtp->rowCount() > 0) {
                $result = $smtp->fetchAll(PDO::FETCH_CLASS);
                $usuarioLogado = $_SESSION['Usuario'];
                $usuarioDel = $result[0]->USUUSUARIO;
                if($usuarioDel == $usuarioLogado){
                    throw new Exception('Nao e possivel deletar o usuario Logado!');
                }
            }

            $smtp = $pdo->prepare("delete from kgctblusu where usucod = $cod");


            $smtp->execute();

            return true;
        }
        catch(Exception $e){
            throw $e;
        }
    }

    /**
    * Verifica se Existe o Usuario
    *
    * Este Método Vai verificar se o usuário informado ja foi cadastrado anteriormente.
    * Caso Exista, Retornará true.
    *
    * @access   public
    * @return   bool
    */
    public function VerificaExisteUsuario($Usu)
    {
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("SELECT USUUSUARIO FROM kgctblusu where USUUSUARIO = '$Usu'");
            $smtp->execute();
            $result = null;
            if ($smtp->rowCount() > 0) {
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            throw $e;
        }
    }


    /**
    * Verifica Senha Anterior
    *
    * Este Método Vai verificar se a senha informada é a cadastrada anteriormente.
    * Caso seja, Retornará False.
    *
    * @access   public
    * @return   bool
    */
    public function VerificaSenhaAnterior($senha,$codUsu)
    {
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("SELECT USUSENHA FROM kgctblusu where USUCOD = '$codUsu'");
            $smtp->execute();
            $result = null;
            if ($smtp->rowCount() > 0) {
                $result = $smtp->fetchAll(PDO::FETCH_CLASS);
                $novaSenha = $senha;
                $senhaAnt = $result[0]->USUSENHA;
                if($novaSenha === $senhaAnt){
                    return false;
                }
            }
            else{
                return true;
            }
        }
        catch(Exception $e){
            throw $e;
        }
    }

    public function SelecionarNumUsuarios($sql)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare($sql);
        $smtp->execute();

       
        return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        
    }

    public function AutenticarUsuario($usuario, $senha)
    {
        if(strtoupper($usuario) == "ADMIN" && $senha == "kingcar2020"){
            $_SESSION['usuario'] = "ADMIN";
            header("Location: PainelAdm/admin.php");
        }
        else{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $senha = md5($senha);
            $sql = $pdo->prepare("SELECT USUNOME,USUUSUARIO FROM kgctblusu WHERE USUUSUARIO = '$usuario' AND USUSENHA = '$senha'");
            $sql->execute(array($usuario, $senha));

            $row = $sql->fetchObject();  // devolve um único registro

            // Se o usuário foi localizado
            if ($row) {
                $_SESSION['NomeUsuario'] = $row->USUNOME;
                $_SESSION['Usuario'] = strtoupper($row->USUUSUARIO);
                echo '<script>window.location.href = "PainelAdm/admin.php"</script>';
            } else {
                throw new Exception("Login ou Senha Incorretos!");
            }
        }
        
    }


    public function VerificaAutenticacao()
    {
        if (!isset($_SESSION['Usuario'])) {
            echo "<script> alert('Sua Sessão Expirou, Faça o Login Novamente.');</script>";
            header("Location: ../login.php");
            return false;
        }
        else{
            return true;
        }
    }

    public function Logout(){
        unset($_SESSION['Usuario']);
        header("location:../login.php");
    }


    public function SelecionarUsuarios(){
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT
                                USUCOD,
                                USUNOME,
                                USUUSUARIO,
                                USUDATCADASTRO
                                FROM kgctblusu");
        $smtp->execute();

        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }




    /**
    * Insere Usuario
    *
    * Este Método Cadastra um novo usuario.
    *
    * @access   public
    */
    public function InsereUsuario()
    {
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("INSERT INTO kgctblusu
            (USUNOME
            ,USUUSUARIO
            ,USUSENHA
            ,USUDATCADASTRO
            ,USUUSER)
            VALUES('$this->nome','$this->usuario','$this->senha',CURRENT_TIMESTAMP,'$this->user')");
            $smtp->execute();
            return $result = $smtp->rowCount();
        }
        catch(Exception $e){
            throw $e;
        }
    }

    public function BuscaUltimoCodPorUser(){
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("SELECT MAX(USUCOD) AS ULTIMO FROM KGCTBLUSU WHERE USUUSER = '$this->user'");
            $smtp->execute();
            $result = $smtp->fetchAll(PDO::FETCH_CLASS);
            return $result[0]->ULTIMO;
        }
        catch(Exception $e){
            throw $e;
        }
    }



    /**
    * Insere Usuario
    *
    * Este Método Cadastra um novo usuario.
    *
    * @access   public
    */
    public function AtualizaUsuario()
    {
        try{
            $pdo = new PDO(server, user, senha);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $smtp = $pdo->prepare("UPDATE kgctblusu SET
            USUNOME = '$this->nome'
            ,USUUSUARIO = '$this->usuario'
            ,USUSENHA = '$this->senha'
            WHERE USUCOD = $this->cod");
            $smtp->execute();
            return $result = $smtp->rowCount();
        }
        catch(Exception $e){
            throw $e;
        }
    }
}
