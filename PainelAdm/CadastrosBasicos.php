<?php
include_once 'header.inc.php';
?>
<style>
    .card {
        width: 100%;
        border: 2px solid #28A745;
        text-decoration: none;
        border-radius: 8px;
    }

    .card:hover {
        box-shadow: 2px 5px 5px rgba(0, 0, 0, 0.5);
        text-decoration: none;
    }
</style>

<div class="row bg-light" style="margin-top:5px;">
    <div class="col-lg-3" style="padding:10px;">
        <a href="CrudMarca.php" class="card">
            <img class="card-img-top" src="../assets/img/bg-marca.jpg" style="width: 100%; height: 200px;" alt="Cadastro de Marcas" title="Cadastro de Marcas">
            <div class="card-footer bg-success text-center">
                <p style="font-size: 25px; text-decoration: none;" class="card-text text-light">Marcas</p>
            </div>
        </a>
    </div>

    <div class="col-lg-3" style="padding:10px;">
        <a href="CrudModelo.php" class="card">
            <img class="card-img-top" src="../assets/img/bg-modelo.jpg" style="width: 100%; height: 200px;" alt="Cadastro de Modelos" title="Cadastro de Modelos">
            <div class="card-footer bg-success text-center">
                <p style="font-size: 25px; text-decoration: none;" class="card-text text-light">Modelos</p>
            </div>
        </a>
    </div>

    <div class="col-lg-3" style="padding:10px;">
        <a href="CrudCores.php" class="card">
            <img class="card-img-top" src="../assets/img/bg-pintura.png" style="width: 100%; height: 200px;" alt="Cadastro de Cores" title="Cadastro de Cores">
            <div class="card-footer bg-success text-center">
                <p style="font-size: 25px; text-decoration: none;" class="card-text text-light">Cores</p>
            </div>
        </a>
    </div>

    <div class="col-lg-3" style="padding:10px;">
        <a href="CrudCambio.php" class="card">
            <img class="card-img-top" src="../assets/img/bg-cambio.jpg" style="width: 100%; height: 200px;" alt="Cadastro de Cambios" title="Cadastro de Cambios">
            <div class="card-footer bg-success text-center">
                <p style="font-size: 25px; text-decoration: none;" class="card-text text-light">Cambios</p>
            </div>
        </a>
    </div>

    <div class="col-lg-3" style="padding:10px;">
        <a href="CrudCombustivel.php" class="card">
            <img class="card-img-top" src="../assets/img/bg-combustivel.jpg" style="width: 100%; height: 200px;" alt="Cadastro de Combustiveis" title="Cadastro de Combustiveis">
            <div class="card-footer bg-success text-center">
                <p style="font-size: 25px; text-decoration: none;" class="card-text text-light">Combustiveis</p>
            </div>
        </a>
    </div>
</div>



<?php
include_once 'footer.inc.php';
?>