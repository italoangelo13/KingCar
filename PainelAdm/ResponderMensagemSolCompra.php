<?php
include 'header.inc.php';
require_once '../Config/PHPMailer/src/PHPMailer.php';
require_once '../Config/PHPMailer/src/Exception.php';
require_once '../Config/PHPMailer/src/SMTP.php';
require_once '../Config/Util.php';
require_once '../Models/Compra.php';

$util = new Util();
$compra = new Compra();
$serverSMTP = $util->SelecionarParametroPorCod(1);
$UsernameSMTP = $util->SelecionarParametroPorCod(2);
$PasswordSMTP = $util->SelecionarParametroPorCod(3);
$AuthSMTP = $util->SelecionarParametroPorCod(4);
$PortaSMTP = $util->SelecionarParametroPorCod(5);
$NomeSMTP = $util->SelecionarParametroPorCod(6);

$mail = new PHPMailer\PHPMailer\PHPMailer(true);


if(!isset($_GET['codSol']) && !isset($_POST['responderEmail'])){
    echo "<script> location.href='SolicitacoesCompra.php?msg=1'; </script>";
}

if(isset($_GET['codSol'])){
    $codSol = $_GET['codSol'];
}
else if (isset($_POST['responderEmail'])){
    $codSol = $_POST['codSol'];
}


$dadosSol = $compra->SelecionarSolicitacaoPorCod($codSol);
if(isset($_POST['responderEmail'])){
    try {
        $destinatario = $_POST['destinatario'];
        $assunto = $_POST['assunto'];
        $mensagem = $_POST['mensagem'];
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = $serverSMTP[0]->PRMVAL;                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $UsernameSMTP[0]->PRMVAL;                     // SMTP username
        $mail->Password   = $PasswordSMTP[0]->PRMVAL;                               // SMTP password
        $mail->SMTPSecure = $AuthSMTP[0]->PRMVAL;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = intval($PortaSMTP[0]->PRMVAL);                                    // TCP port to connect to
        $mail->CharSet    = 'utf-8';
    
        //Recipients
        $mail->setFrom($UsernameSMTP[0]->PRMVAL, $NomeSMTP[0]->PRMVAL);
        $mail->addAddress($destinatario);     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo($UsernameSMTP[0]->PRMVAL, $NomeSMTP[0]->PRMVAL);
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
    
        // Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $assunto;
        $mail->Body    = $mensagem;
    
        $mail->send();
        echo "<script> location.href='SolicitacoesCompra.php?msg=2'; </script>";
    } catch (Exception $e) {
        echo "<script> ErrorBox(".$mail->ErrorInfo."); </script>";
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
<form action="ResponderMensagemSolCompra.php" method="post">
    <div class="row bg-light" style="margin-top:5px; padding:5px;">
        <div class="form-group col-lg-12">
            <a href="SolicitacoesCompra.php" class="btn btn-dark"><i class="icone-back"></i> Voltar</a>
            <button type="submit" name="responderEmail" class="btn btn-success"><i class="icone-paper-plane-empty"></i> Enviar</button>
        </div>
    </div>
    <div class="row bg-dark text-white" style="margin-top:5px;">
        <div class="col-lg-12 text-center">
            Dados da Mensagem
        </div>
    </div>

    <div class="row bg-light" style="margin-top:5px;">
        <input type="hidden" name="codSol" value="<?php echo $dadosSol[0]->COMCOD; ?>">
        <div class="form-group col-lg-6 ">
           <label for="_edDestinatario">Destinatario</label>
           <input type="text" name="destinatario" id="_edDestinatario" readonly class="form-control" value="<?php echo $dadosSol[0]->COMEMAIL; ?>">
        </div>
        <div class="form-group col-lg-6 ">
        <label for="_edDestinatario">Assunto</label>
           <input type="text" name="assunto" id="_edAssunto" class="form-control" readonly value="Res: <?php echo '#'.$dadosSol[0]->CARCOD.' - '.$dadosSol[0]->MARDESCRICAO.' '.$dadosSol[0]->MODDESCRICAO.' '.$dadosSol[0]->CARANO.' - KINGCAR'; ?>" >
        </div>
    </div>
    <div class="row bg-light" style="margin-top:5px;">
        <div class="form-group col-lg-12 ">
           <label for="_edMensagem">Mensagem</label>
           <textarea name="mensagem" rows="10" style="width: 100%;resize: none;" id="_edMensagem" class="form-control"></textarea>
        </div>
    </div>
</form>


