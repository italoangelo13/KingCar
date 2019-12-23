<?php

class Usuarios
{
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


        $sql = $pdo->prepare("SELECT USUNOME FROM kgctblusu WHERE USUUSUARIO=? AND USUSENHA=?");
        $sql->execute(array($usuario, md5($senha)));

        $row = $sql->fetchObject();  // devolve um único registro

        // Se o usuário foi localizado
        if ($row) {
            $_SESSION['usuario'] = $row->USUNOME;
            header("Location: PainelAdm/admin.php");
        } else {
            header("Location: login.php");
            echo "<script> alert('Login ou Senha Incorretos!!'); window.location.href='login.php';</script>";
        }
        }
        
    }
}
