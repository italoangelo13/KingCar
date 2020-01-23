<?php

class Compra
{
    public function CadastraSolicitacaoCompra($codCarro, $nome, $email, $tel, $mensagem)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("INSERT INTO KGCTBLSOLCOM (COMNOME, COMEMAIL, COMTEL, COMMSG, COMDATCADASTRO, COMCODCARRO)
        VALUES ('$nome', '$email', '$tel', '$mensagem', CURRENT_TIMESTAMP, $codCarro)");
        $smtp->execute();
        $result = $smtp->rowCount();

        if($result > 0){
            return true;
        }
        else{
            return false;
        }
    }


    public function SelecionarNumSolicitacaoCompra()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT count(*) AS QTDE FROM kgctblsolcom WHERE COMLIDO = 'N'");
        $smtp->execute();
        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

}