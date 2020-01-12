<!DOCTYPE html>
<html lang="en">
<head>
    <title>Categories</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Futbol Shop project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/projecteServidors/styles/bootstrap4/bootstrap.min.css">
    <link href="/projecteServidors/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/projecteServidors/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="/projecteServidors/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="/projecteServidors/plugins/OwlCarousel2-2.2.1/animate.css">
    <link rel="stylesheet" type="text/css" href="/projecteServidors/styles/categories.css">
    <link rel="stylesheet" type="text/css" href="/projecteServidors/styles/categories_responsive.css">
    <script src="/projecteServidors/js/jquery-3.2.1.min.js"></script>
    <script src="/projecteServidors/styles/bootstrap4/popper.js"></script>
    <script src="/projecteServidors/styles/bootstrap4/bootstrap.min.js"></script>
    <script src="/projecteServidors/plugins/Isotope/isotope.pkgd.min.js"></script>
    <script src="/projecteServidors/js/categories.js"></script>
</head>
<body>

<div class="super_container">

    <!-- Header -->

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


    <!-- Products -->
    <div class="products">
        <div class="container">
            <div class="row">
                <div class="col">
                    <!-- Product Sorting -->
                    <form action="<?php
                    echo $route->generateURL('Product', 'getBotasFutbolFiltered') ?>" name="search_form" method="GET">
                        <input type="hidden" name="page" value="<?= $_GET['page'] ?? "botasFutbol";?>">
                        <input type="hidden" name="pages" value="<?php echo $pagePagination;?>">

                        <td>Fecha Inicio:</td>
                        <input type="date" name="fechaMin" style="width: 160px">


                        <td>Fecha Final:</td>
                        <input type="date" name="fechaMax" style="width: 160px">

                        <input class="text" type="text" name="textFilter">

                        <input type="submit" name="search" value="Filtrar">
                    </form>
                    <div class="product_grid">
                        <?php
                        foreach ($products as $product) {

                            ?>
                            <!-- Product -->
                            <div class="product">
                                <div class="product_image">
                                    <img src="/projecteServidors/images/botasFutbol/<?php echo $product->getImg(); ?>" alt=""></div>
                                <div class="product_content">
                                    <div class="product_title"><a href='<?php
                                        echo $route->generateURL('Product', 'getProductById', ['id' => $product->getId()]) ?>'><?php echo $product->getNombre(); ?></a></div>
                                    <div class="product_price"><?php echo $product->getPrecio(); ?>€</div>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                    <div class="product_pagination">
                        <ul>
                            <?php
                            if ($previous!=0){ ?>
                                <li class="active"><a href="<?php
                                    echo $route->generateURL('Product', 'getBotasFutbolFiltered') . "?pages=" . $previous . $fechaMin . $fechaMax . $textFilter ?>">Previous</a></li>
                            <?php }
                            ?>

                            <?php
                            for ($i = 1; $i<=$pages; $i++){?>
                                <li class="active"><a href="<?php
                                    echo $route->generateURL('Product', 'getBotasFutbolFiltered') . "?pages=" . $i . $fechaMin . $fechaMax . $textFilter?>"><?=$i?></a></li>
                                <?php
                            }
                            ?>
                            <?php
                            if ($next<=$pages){ ?>
                                <li class="active"><a href="<?php
                                    echo $route->generateURL('Product', 'getBotasFutbolFiltered') . "?pages=" . $next . $fechaMin . $fechaMax . $textFilter?>">Next</a></li>
                            <?php }?>

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
                            <p>Nuestro equipo de soporte está todo el dia para ayudarte.</p>
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
                        <div class="newsletter_title">Subscribe to our newsletter</div>
                        <div class="newsletter_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam
                                a ultricies metus. Sed nec molestie eros</p></div>
                        <div class="newsletter_form_container">
                            <form action="#" id="newsletter_form" class="newsletter_form">
                                <input type="email" class="newsletter_input" required="required">
                                <button class="newsletter_button trans_200"><span>Subscribe</span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require 'partials/footer.partial.php'; ?>
</div>
</body>
</html>