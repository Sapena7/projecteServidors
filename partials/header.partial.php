<!-- Header -->
<?php global $route ?>
<header class="header">
    <div class="header_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_content d-flex flex-row align-items-center justify-content-start">
                        <div class="logo"><a href="#">Futbol Shop.</a></div>
                        <nav class="main_nav">
                            <ul>
                                <li><a href="<?= $route->generateURL('Product', 'index') ?> ">Inicio</a></li>
                                <li class="hassubs">
                                    <a href="<?= $route->generateURL('Product', 'getBotasFutbol') ?>">Categorias</a>
                                    <ul>
                                        <li><a href="<?= $route->generateURL('Product', 'getBotasFutbol') ?> ">Botas de futbol</a></li>
                                        <li><a href="<?= $route->generateURL('Product', 'getBotasFutbolSala') ?> ">Botas de futbol sala</a></li>
                                        <li><a href="<?= $route->generateURL('Product', 'getCamisetasEntrenamiento') ?> ">Camisetas de entrenamiento</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>

                        <div class="header_extra ml-auto">

                        </div>


                        <?php  if (empty($_SESSION['nombre'])) { ?>
                            <a href="<?= $route->generateURL('User', 'login') ?>"><input class="loginButton" type="image" src="/projecteServidors/images/myuser.png">Login/Register

                       <?php }else{ ?>
                            <a href="<?= $route->generateURL('User', 'profile') ?>"><input class="loginButton" type="image" src="/projecteServidors/images/myuser.png"> <?php
                                if (!empty($_SESSION['nombre'])){
                                    echo $_SESSION['nombre'];
                                }else{
                                    echo "";
                                }
                                ?></a>
                        <?php }?>


                        <?php  if (!empty($_SESSION['nombre'])) { ?>
                            <?php
                            if (!empty($_SESSION['rol'])){
                                if ($_SESSION['rol'] == 2) { ?>
                                    <a href="<?= $route->generateURL('User', 'dashboard') ?>"><input class="loginButton" type="image" src="/projecteServidors/images/myuser.png"> Dashboard</a>
                                <?php }
                            }
                            ?>


                            <a href="<?= $route->generateURL('User', 'logout') ?>"><input class="loginButton" type="image" src="/projecteServidors/images/login.svg">Logout</a>
                        <?php
                        }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>