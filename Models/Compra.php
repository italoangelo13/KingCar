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

    public function AtualizaStatusLido($codSol,$status)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("UPDATE KGCTBLSOLCOM SET COMLIDO = '$status' where COMCOD = $codSol");
        $smtp->execute();
        $result = $smtp->rowCount();

        if($result > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function SelecionarSolicitacaoPorCod($codSol)
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COMCOD,
        COMNOME,
        COMEMAIL,
        COMMSG,
        COMTEL,
        COMDATCADASTRO,
        COMLIDO,
        CARCOD,
        MARDESCRICAO,
        MODDESCRICAO,
        CARANO,
        CARFOTO,
        CARPRECO
        FROM kgctblsolcom
        inner join KGCTBLCAR
        ON COMCODCARRO = CARCOD
        INNER JOIN kgctblmar
        ON CARCODMARCA = MARCOD
        INNER JOIN kgctblMOD
        ON CARCODMODELO = MODCOD where COMCOD = $codSol");
        $smtp->execute();
        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
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

    public function SelecionarSolicitacoesCompra()
    {
        $pdo = new PDO(server, user, senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $smtp = $pdo->prepare("SELECT COMCOD,
        COMNOME,
        COMEMAIL,
        COMTEL,
        COMDATCADASTRO,
        COMLIDO,
        CARCOD,
        CONCAT(CARCOD,' - ',MARDESCRICAO,' ',MODDESCRICAO,' ', CARANO) AS VEICULO
        FROM kgctblsolcom
        inner join KGCTBLCAR
        ON COMCODCARRO = CARCOD
        INNER JOIN kgctblmar
        ON CARCODMARCA = MARCOD
        INNER JOIN kgctblMOD
        ON CARCODMODELO = MODCOD ORDER BY COMDATCADASTRO DESC");
        $smtp->execute();
        if ($smtp->rowCount() > 0) {
            return $result = $smtp->fetchAll(PDO::FETCH_CLASS);
        }
    }

}