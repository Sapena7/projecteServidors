<!DOCTYPE html>
<php lang="en">
    <head>
        <title>Categories</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Futbol Shop project">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
        <link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="styles/login.css">
    </head>
<body>
<?php



?>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Login</h5>
                    <form action="" method="post" class="form-signin">
                        <div class="form-label-group">
                            <input type="text" id="nombre" class="form-control" name="email" required autofocus>
                            <label for="inputEmail">Email</label>
                        </div>

                        <div class="form-label-group">
                            <input type="text" id="contrasena" class="form-control" name="contrasena" required>
                            <label for="inputPassword">Contraseña</label>
                        </div>
                        <!--<a href="index.php?page=profile">-->
                        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Entrar</button>


                        <hr class="my-4">
                        <p>¿Aun no estas registrado? Registrate!</p>
                        <a href="index.php?page=registro" class="btn btn-lg btn-google btn-block text-uppercase">Registrate
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

