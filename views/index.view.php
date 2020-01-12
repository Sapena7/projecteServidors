<!DOCTYPE html>
<php lang="en">
    <head>
        <title>Futbol Shop</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Futbol Shop project">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/projecteServidors/styles/bootstrap4/bootstrap.min.css">
        <link href="/projecteServidors/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="/projecteServidors/styles/main_styles.css">
        <link rel="stylesheet" type="text/css" href="/projecteServidors/styles/categories.css">
        <link rel="stylesheet" type="text/css" href="/projecteServidors/styles/responsive.css">
        <script src="/projecteServidors/js/jquery-3.2.1.min.js"></script>
        <script src="/projecteServidors/styles/bootstrap4/popper.js"></script>
        <script src="/projecteServidors/styles/bootstrap4/bootstrap.min.js"></script>
        <script src="/projecteServidors/plugins/Isotope/isotope.pkgd.min.js"></script>
        <script src="/projecteServidors/js/categories.js"></script>
        <style type="text/css">
            form {
                text-align: right;
            }
            input {
                width: 100px;
            }
        </style>
    </head>
    <body>
    <div class="super_container">
        <?php require 'partials/header.partial.php'; ?>
        <!-- Search Panel -->
        <div class="search_panel trans_300">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="search_panel_content d-flex flex-row align-items-center justify-content-end">
                            <form action="#">
                                <input type="text" class="search_input" placeholder="Search" required="required">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social -->
        <div class="header_social">
            <ul>
                <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        </header>

        <!-- Filter -->

        <!-- CARRUSEL? -->
        <!-- Products -->
        <div class="products">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <form action="<?php
                            if (empty($id)){
                                echo $route->generateURL('Product', 'getProductsFiltered') ?>" name="search_form" method="GET">
                            <?php
                            }else{
                                $route->generateURL('Product', 'getProductsFilteredByUser', ['id' => $id]) ?>" name="search_form" method="GET">
                            <?php
                            }
                            ?>

                            <?php
                                if (!empty($usuario)){ ?>
                                    <input type="hidden" name="usuario" value="<?= $_GET['usuario'];?>">
                               <?php }
                            ?>
                            <input type="hidden" name="page" value="<?= $_GET['page'] ?? "index";?>">
                            <input type="hidden" name="pages" value="<?php echo $pagePagination;?>">
                            <td>Categoria:</td>
                            <select name="categoria">
                                <option value="">Categoria</option>
                                <option value="1">Botas de futbol</option>
                                <option value="2">Botas de futbol sala</option>
                                <option value="3">Camisetas de entrenamiento</option>
                            </select>

                            <td>Fecha Inicio:</td>
                            <input type="date" name="fechaMin" style="width: 160px">


                            <td>Fecha Final:</td>
                            <input type="date" name="fechaMax" style="width: 160px">

                            <input class="text" type="text" name="textFilter">

                            <input type="submit" name="search" value="Filtrar">
                        </form><br>
                        <h3>Resultados: <?php echo $total?></h3>
                        <div class="product_grid">

                            <?php

                            foreach ($productsFiltered as $product) {

                            ?>
                            <!-- Product -->
                            <div class="product">
                                <?php
                                if (!empty($user)) {
                                    if ($product->getUsuario() == $user->getId()) {
                                        ?>
                                        <a href="<?php
                                        echo $route->generateURL('Product', 'modifyProduct', ['id' => $product->getId()])?>"
                                           class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">
                                                Editar</i></a>
                                        <?php
                                    }
                                }
                                ?>

                                <div class="product_image">
                                    <?php
                                    if ($product->getImg() == "producto-sin-foto.png"){ ?>
                                    <img src="images/<?php echo $product->getImg();?>" alt="">
                                    <?php }
                                    ?>
                                    <?php switch ($product->getCategoria()){ //switch per a saber la categoria, i aixi posar la carpeta indicada de l'imatge que mostrara
                                    case 1:
                                    ?>
                                        <img src="/projecteServidors/images/botasFutbol/<?php echo $product->getImg();?>" width="250px" height="250px" alt=""></div>
                                    <?php
                                    break;
                                    case 2:
                                    ?>
                                        <img src="/projecteServidors/images/botasFutbolSala/<?php echo $product->getImg();?>"  width="250px" height="250px" alt=""></div>
                                    <?php
                                    break;
                                    case 3:
                                    ?>
                                        <img src="/projecteServidors/images/camisetasEntrenamiento/<?php echo $product->getImg();?>"  width="250px" height="250px" alt=""></div>
                                    <?php
                                    break;
                                    ?>

                                    <?php

                        } ?>

                        <div class="product_content">
                            <div class="product_title"><a href='<?php
                                echo $route->generateURL('Product', 'getProductById', ['id' => $product->getId()]) ?>'><?php echo $product->getNombre(); ?></a></div>
                            <div class="product_price"><?php echo $product->getPrecio(); ?>€</div>
                        </div>
                    </div>
                    <?php }
                    ?>
                </div>
                <br>
                <br>
                <br>


                <div class="product_pagination">
                    <ul>
                        <?php
                        if (!empty($id)){
                            if ($previous!=0){ ?>
                                <li class="active"><a href="<?php
                                    echo $route->generateURL('Product', 'getProductsFilteredByUser', ['id' => $id]) . "?pages=" . $previous .$usuario .$categoria . $fechaMin . $fechaMax . $textFilter ?>">Previous</a></li>
                            <?php }
                            ?>

                            <?php
                            for ($i = 1; $i<=$pages; $i++){?>
                                <li class="active"><a href="<?php
                                    echo $route->generateURL('Product', 'getProductsFilteredByUser', ['id' => $id]) . "?pages=" . $i.$usuario .$categoria . $fechaMin . $fechaMax . $textFilter?>"><?=$i?></a></li>
                                <?php
                            }
                            ?>
                            <?php
                            if ($next<=$pages){ ?>
                                <li class="active"><a href="<?php
                                    echo $route->generateURL('Product', 'getProductsFilteredByUser', ['id' => $id]) . "?pages=" . $next .$usuario .$categoria . $fechaMin . $fechaMax . $textFilter?>">Next</a></li>
                            <?php }
                        }else{

                            if ($previous!=0){ ?>
                                <li class="active"><a href="<?php
                                    echo $route->generateURL('Product', 'getProductsFiltered') . "?pages=" . $previous .$usuario .$categoria . $fechaMin . $fechaMax . $textFilter ?>">Previous</a></li>
                            <?php }
                            ?>

                            <?php
                            for ($i = 1; $i<=$pages; $i++){?>
                                <li class="active"><a href="<?php
                                    echo $route->generateURL('Product', 'getProductsFiltered') . "?pages=" . $i.$usuario .$categoria . $fechaMin . $fechaMax . $textFilter?>"><?=$i?></a></li>
                                <?php
                            }
                            ?>
                            <?php
                            if ($next<=$pages){ ?>
                                <li class="active"><a href="<?php
                                    echo $route->generateURL('Product', 'getProductsFiltered') . "?pages=" . $next .$usuario .$categoria . $fechaMin . $fechaMax . $textFilter?>">Next</a></li>
                            <?php }
                        }?>

                    </ul>
                </div>

            </div>
        </div>
    </div>
    </div>


    <!-- Icon Boxes -->

    <div class="icon_boxes">
        <div class="container">
            <div class="row icon_box_row">

                <!-- Icon Box -->
                <div class="col-lg-4 icon_box_col">
                    <div class="icon_box">
                        <div class="icon_box_image"><img src="/projecteServidors/images/icon_1.svg" alt=""></div>
                        <div class="icon_box_title">Envio gratis a todo el mundo</div>
                        <div class="icon_box_text">
                            <p>Enviamos nuestros productos a todo el mundo.</p>
                        </div>
                    </div>
                </div>

                <!-- Icon Box -->
                <div class="col-lg-4 icon_box_col">
                    <div class="icon_box">
                        <div class="icon_box_image"><img src="/projecteServidors/images/icon_2.svg" alt=""></div>
                        <div class="icon_box_title">Devolución gratuita</div>
                        <div class="icon_box_text">
                            <p>Devolución gratuita durante la primera semana.</p>
                        </div>
                    </div>
                </div>

                <!-- Icon Box -->
                <div class="col-lg-4 icon_box_col">
                    <div class="icon_box">
                        <div class="icon_box_image"><img src="/projecteServidors/images/icon_3.svg" alt=""></div>
                        <div class="icon_box_title">Soporte 24h</div>
                        <div class="icon_box_text">
                            <p>Nuestro equipo de soporte está todo el dia para ayudar.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Newsletter -->

    <div class="newsletter">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="newsletter_border"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="newsletter_content text-center">
                        <div class="newsletter_title">Suscribete a nuestra pagina</div>
                        <div class="newsletter_text"><p>Asi podras recibir las ultimas noticias!</p></div>
                        <div class="newsletter_form_container">
                            <form action="#" id="newsletter_form" class="newsletter_form">
                                <input type="email" class="newsletter_input" required="required">
                                <button class="newsletter_button trans_200"><span>Suscribete</span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require 'partials/footer.partial.php'; ?>
    </div>
    </body>
</php>
