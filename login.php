<?php
    header("Content-type:text/html; charset=utf8");

    include_once 'Config/ConexaoBD.php';
    require_once 'Models/Usuarios.php';
    session_start();

    if(isset($_SESSION['Usuario'])){
        header('location: PainelAdm/admin.php');
    }

    

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KingCar - Painel Administrativo</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontello/css/fontello.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/kingcar.css">
    <link rel="stylesheet" href="assets/jquery-confirm/jquery-confirm.min.css">
    <link rel="stylesheet" href="assets/chartjs/Chart.min.css">
    <link rel="stylesheet" href="assets/jQueryte.1.4.0/jquery-te-1.4.0.css">
    <link rel="stylesheet" href="assets/DataTables/datatables.min.css">
    <script src="assets/jquery-3.3.1.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
    <script src="assets/jquery-confirm/jquery-confirm.min.js"></script>
    <script src="assets/Loader/jquery.loading.min.js"></script>
    <script src="assets/Mascaras.js"></script>
    <script src="assets/chartjs/Chart.min.js"></script>
    <script src="assets/jQueryte.1.4.0/jquery-te-1.4.0.min.js"></script>
    <script src="assets/DataTables/datatables.min.js"></script>
    <script src="assets/kingcar.js"></script>
</head>

<body style="background: url('assets/img/bg-login.jpg')">
    <div class="container-fluid">
        <div class="row" style="margin-top: 100px;">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <div class="card text-center">
                    <div class="card-body bg-secondary">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <img src="assets/img/logo.png" alt="Logo KingCar" width="100%">
                                </div>
                            </div>
                            <form action="login.php" method="post">
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icone-user"></i></div>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" id="_edUsuario" name="_edUsuario" placeholder="Usuario">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-lg-12">
                                    <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="icone-lock"></i></div>
                                            </div>
                                            <input type="password" class="form-control form-control-lg" id="_edSenha" name="_edSenha" placeholder="Senha">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-lg-12">
                                        <button type="submit" name="login" class="btn btn-success btn-lg btn-block"><i class="icone-login-1"></i> Acessar</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4"></div>
        </div>
    </div>
</body>

</html>

<?php
if(isset($_POST["login"])){
    $u = new Usuarios();
    try{
        $u->AutenticarUsuario(strtoupper($_POST["_edUsuario"]),$_POST["_edSenha"]);
    }
    catch(Exception $e){
        echo "<script>ErrorBox('".$e->getMessage()."');</script>";
    }
    
}
?>