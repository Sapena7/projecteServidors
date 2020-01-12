<!DOCTYPE html>
<?php global $route ?>
<php lang="en">
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="styles/change_password.css">
    </head>
    <body>

<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <form action="" method="post">

            <label>Contraseña actual</label>
            <div class="form-group pass_show">
                <input type="password" class="form-control" name="old_password">
            </div>
            <label>Contraseña nueva</label>
            <div class="form-group pass_show">
                <input type="password" class="form-control" name="new_password">
            </div>
            <label>Confirmar contraseña</label>
            <div class="form-group pass_show">
                <input type="password" class="form-control" name="new_password_confirm">
            </div>
            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Confirmar</button><br>
                <a href='<?php echo $route->generateURL('User', 'profile') ?>' class="btn btn-primary">Volver</a>
        </div>
        </form>


    </div>
</div>
    </body>