<?php
    if(isset($_POST['news'])){
        $utilNews = new Util();
        $email = $_POST['emailnews'];
        try{
            $utilNews->InserirEmailNewsletter($email);
            echo "<script>SuccessBox('Email Cadastrado com Sucesso.');</script>";
        }
        catch (Exception $e){
    
        }
    }
?>
<div class="row bg-warning" style="margin-top: 15px; padding: 5px;">
    <div class="col-lg-8">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <label class="text-dark">King Car Seminovos || Copyright © 2020</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <a href="login.php">Painel Administrativo</a>
                </div>
            </div>
            <div class="row" style="margin-top: 15px;">
                <div class="col-lg-12">
                Desenvolvido Por <a style="text-decoration: none; color:#000;" target="_blank" href="https://www.facebook.com/fariasoft">Faria Soft</a>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-4">
        <h6>Deseja receber as novidades da King Car? assine o nosso Newslatter!</h6>
        <form action="" method="POST" class="form-inline">
            <div class="input-group mb-2 mr-sm-2">
                <input type="email" name="emailnews" id="_edemail" class="form-control form-control-lg" placeholder="Seu Email Aqui!">
            </div>
            <button name="news" class="btn btn-success btn-lg">Enviar</button>
        </form>
    </div>
</div>
</div>

</body>

</html>