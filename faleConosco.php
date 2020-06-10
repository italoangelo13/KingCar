<?php
header("Content-type:text/html; charset=utf8");

include_once 'Config/ConexaoBD.php';
require_once 'config/PHPMailer/src/PHPMailer.php';
require_once 'config/PHPMailer/src/Exception.php';
require_once 'config/PHPMailer/src/SMTP.php';
include_once 'Config/Util.php';
require_once 'Models/Contatos.php';
include 'header.inc.php';
$util = new Util();
$serverSMTP = $util->SelecionarParametroPorCod(1);
$UsernameSMTP = $util->SelecionarParametroPorCod(2);
$PasswordSMTP = $util->SelecionarParametroPorCod(3);
$AuthSMTP = $util->SelecionarParametroPorCod(4);
$PortaSMTP = $util->SelecionarParametroPorCod(5);
$NomeSMTP = $util->SelecionarParametroPorCod(6);



$contato = new Contatos();

if (isset($_POST['enviar'])) {
    $nome = strtoupper($_POST['nome']);
    $email = $_POST['email'];
    $telefone = $_POST['tel'];
    $assunto = strtoupper($_POST['assunto']);
    $mensagem = strtoupper($_POST['msg']);

    $contato->nome = $nome;
    $contato->email = $email;
    $contato->tel = $telefone;
    $contato->assunto = $assunto;
    $contato->msg = $mensagem;
    if ($contato->InserirSolicitacaoContato()) {
        echo "<script>SuccessBox('Sua Mensagem foi enviada, Logo Mais Entraremos em contato.');</script>";
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
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
            $mail->addAddress($email);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo($UsernameSMTP[0]->PRMVAL, $NomeSMTP[0]->PRMVAL);
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'RE.: ' . $assunto;
            $mail->Body    = "ESTE EMAIL É UMA RESPOSTA AUTOMATICA, FAVOR NÃO RESPONDER! <br><br>
            OLÁ " . $nome . ", <br>
            RECEBEMOS A SUA MENSAGEM ENVIADA PELO NOSSO SITE, EM BREVE ESTAREMOS ENTRANDO EM CONTATO. <br>
            OBRIGADO POR ESCOLHER A KING CAR!
            <br>
            <br>
            <br>
            <br>
            MENSAGEM ENVIADA ÁS " . date('d/M/Y H:i:s') . ": <br>"
                . $mensagem;

            $mail->send();
        } catch (Exception $e) {
            // $util->GravaErro('FaleConosco.php',$e->getMessage(),$e->getTraceAsString());
        }
    }
}


$telefoneCon = null;
$facebookCon = null;
$whatsappCon = null;
$instagramCon = null;

$parTelc = $util->SelecionarParametroPorCod(7); //7 - Telefone
$parWhatc = $util->SelecionarParametroPorCod(8); //8 - whatsapp
$parFacec = $util->SelecionarParametroPorCod(9); //9 - facebook
$parInstac = $util->SelecionarParametroPorCod(10); //10 - instagram

$telefoneCon = $parTelc[0]->PRMVAL;
$whatsappCon = $parWhatc[0]->PRMVAL;
$facebookCon = $parFacec[0]->PRMVAL;
$instagramCon = $parInstac[0]->PRMVAL;


?>

<div class="row bg-dark" style=" margin-top:10px;padding:5px;">
    <div class="col-lg-6 text-center">
        <div class="cointainer-fluid text-warning">
            <div class="row" style="margin-bottom: 35px;">
                <div class="col-lg-12 display-5 text-center">
                    Entre em contato conosco pelos nossos canais de comunicação.
                </div>
            </div>
            <?php if ($facebookCon) { ?>
                <div class="row">
                    <div class="col-lg-12 display-6">
                        Acesse a nossa Fã Page no facebook <br>
                        <a target="_blank" href="<?php echo $facebookCon; ?>" class="text-warning" style="text-decoration: none;"><i class="icone-facebook-rect-1"></i> Facebook </a>
                    </div>
                </div>
            <?php } ?>

            <?php if ($instagramCon) { ?>
                <div class="row">
                    <div class="col-lg-12 display-6">
                    Confira o nosso perfil no <br>
                        <a target="_blank" href="<?php echo $instagramCon; ?>" class="text-warning" style="text-decoration: none;"><i class="icone-instagram-filled"></i> Instagram </a>
                    </div>
                </div>
            <?php } ?>

            <?php if ($whatsappCon) { ?>
                <div class="row">
                    <div class="col-lg-12 display-6">
                    Nos Envie uma mensagem pelo <br>
                        <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $whatsappCon; ?>&text=Olá!" class="text-warning" style="text-decoration: none;"><i class="icone-whatsapp"></i> Whatsapp </a>
                    </div>
                </div>
            <?php } ?>

            <?php if ($telefoneCon) { ?>
                <div class="row">
                    <div class="col-lg-12 display-6  text-warning">
                    Entre em contato por telefone através do numero <br>
                        <i class="icone-phone"></i> <?php echo $telefoneCon; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="col-lg-6 " style="">
        <div class="container-fluid">
            <form action="faleconosco.php" method="post">
                <div class="row" style="border: 2px solid #FFB62C; border-radius:5px;">
                    <div class="col-lg-12">
                        <label for="" class="text-center display-5 text-warning"> Se Desejar, Nos Envie uma Mensagem com a sua Duvida!</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label class="text-warning" for="_edNome">Nome</label>
                        <input type="text" name="nome" id="_edNome" class="form-control form-control-lg" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="text-warning" for="_edNome">Email</label>
                        <input type="email" name="email" id="_edEmail" class="form-control form-control-lg" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label class="text-warning " for="_edTel">Telefone</label>
                        <input type="tel" name="tel" id="_edTel" class="form-control form-control-lg" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="text-warning" for="_edAssunto">Assunto</label>
                        <input type="text" name="assunto" id="_edAssunto" class="form-control form-control-lg" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label class="text-warning " for="_edMsg">Mensagem</label>
                        <textarea name="msg" id="_edMsg" class="form-control form-control-lg" style="height: 200px;resize: none;" required></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12">
                        <button name="enviar" class="btn btn-warning btn-lg btn-block" type="submit">
                            <i class="icone-email"></i> Enviar Mensagem
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include 'footer.inc.php';
?>