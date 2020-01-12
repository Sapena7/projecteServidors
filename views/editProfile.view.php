<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="styles/profile2.css">

<!------ Include the above in your HEAD tag ---------->

<!--
User Profile Sidebar by @keenthemes
A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
Licensed under MIT
-->

<div class="container">
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="images/<?php echo $userNotModified->getImg();?>" class="img-responsive" alt="">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="file">
                        <input type="submit" name="upload" value="Upload">
                        <p><?php echo $statusMsg ?></p>
                    </form>
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo $userNotModified->getNombre();?>
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li class="active">
                            <a href='<?php echo $route->generateURL('User', 'profile') ?>'>
                                <i class="glyphicon glyphicon-home"></i>
                                Perfil </a>
                        </li>
                        <li>
                            <a href='<?php echo $route->generateURL('User', 'editProfile') ?>'>
                                <i class="glyphicon glyphicon-user"></i>
                                Modificar Perfil </a>
                        </li>
                        <li>
                            <a href='<?php echo $route->generateURL('Product', 'editProductsUser') ?>' target="_blank">
                                <i class="glyphicon glyphicon-edit"></i>
                                Productos </a>
                        </li>
                        <li>
                            <a href='<?php echo $route->generateURL('User', 'change_password') ?>' target="_blank">
                                <i class="glyphicon glyphicon glyphicon-wrench"></i>
                                Cambiar contraseña </a>
                        </li>
                        <li>
                            <a href='<?php echo $route->generateURL('Product', 'index') ?>' target="_blank">
                                <i class="glyphicon glyphicon-shopping-cart"></i>
                                Tienda </a>
                        </li>
                        <li>
                            <a href='<?php echo $route->generateURL('User', 'logout') ?>' target="_blank">
                                <i class="glyphicon glyphicon glyphicon-log-out"></i>
                                Cerrar session </a>
                        </li>
                    </ul>
                </div>
                <!-- END MENU -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <form action="" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <label>Nombre</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $userNotModified->getNombre() ?>" ><br>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Apellidos</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $userNotModified->getApellidos() ?>" ><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Provincia</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="provincia" name="provincia" value="<?php echo $userNotModified->getProvincia() ?>" ><br>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Email</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="nombre" name="email" value="<?php echo $userNotModified->getEmail() ?>" ><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Rol</label>
                    </div>
                    <div class="col-md-6">
                        <p><?php switch ($userNotModified->getRol()){
                                case 1:
                                    echo "Usuario Normal";
                                    break;
                                case 2:
                                    echo "Usuario Administrador";
                                    break;
                            }?></p><br>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Idioma</label>
                        </div>
                        <div class="col-md-6">
                            <select name="idioma">
                                <option value="castellano">Castellano</option>
                                <option value="valenciano">Valenciano</option>
                                <option value="Ingles">Ingles</option>
                            </select>
                        </div>
                    </div><br>

                    <input type="submit" name="submit" class="btn btn-primary" value="Modificar">
                    <a href='<?php echo $route->generateURL('User', 'profile') ?>' class="btn btn-primary">Volver</a>

                </form>

            </div>
        </div>
    </div>
</div>
<br>
<br>