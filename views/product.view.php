<!DOCTYPE html>
<php lang="en">
    <head>
        <title>Product</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Futbol Shop project">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../styles/bootstrap4/bootstrap.min.css">
        <link href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../styles/product.css">
        <link rel="stylesheet" type="text/css" href="../styles/product_responsive.css">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="styles/bootstrap4/popper.js"></script>
        <script src="styles/bootstrap4/bootstrap.min.js"></script>
        <script src="plugins/greensock/TweenMax.min.js"></script>
        <script src="plugins/greensock/TimelineMax.min.js"></script>
        <script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
        <script src="plugins/greensock/animation.gsap.min.js"></script>
        <script src="plugins/greensock/ScrollToPlugin.min.js"></script>
        <script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
        <script src="plugins/Isotope/isotope.pkgd.min.js"></script>
        <script src="plugins/easing/easing.js"></script>
        <script src="plugins/parallax-js-master/parallax.min.js"></script>
        <script src="js/product.js"></script>
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

	<!-- Menu -->

	<!-- Home -->

	<!-- Product Details -->

	<div class="product_details">
		<div class="container">
			<div class="row details_row">

				<!-- Product Image -->
				<div class="col-lg-6">
					<div class="details_image">
                        <?php switch ($product->getCategoria()){ //switch per a saber la categoria, i aixi posar la carpeta indicada de l'imatge que mostrara
                        case 1:
                        ?>
                            <div class="details_image_large"><img src="../images/botasFutbol/<?php echo $product->getImg();?>" alt=""></div>

                        <?php
                        break;
                        case 2:
                        ?>
                            <div class="details_image_large"><img src="../images/botasFutbolSala/<?php echo $product->getImg();?>" alt=""></div>
                        <?php
                        break;
                        case 3:
                        ?>
                            <div class="details_image_large"><img src="../images/camisetasEntrenamiento/<?php echo $product->getImg();?>" alt=""></div>
                        <?php
                        break;
                        } ?>
					</div>
				</div>

				<!-- Product Content -->
				<div class="col-lg-6">
					<div class="details_content">
						<div class="details_name"><?php echo $product->getNombre() ?></div>

						<div class="details_price"><?php echo $product->getPrecio() ?></div>

						<!-- In Stock -->
						<div class="in_stock_container">
							<div class="availability">Disponibilidad</div>
							<span><?php echo $product->getStock() ?></span>
						</div>
                        <div>
                            <br>
                            <span><?php
                                //Pasar a string per a poder-ho mostrar
                                $date = $product->getFecha();
                                $dateString = $date->format('Y-m-d');
                                echo $dateString ?></span>
                        </div><br>
                        <div>
                            <a href="index.php?page=index&usuario=<?= $user->getId()?>">
                                <img class="details_image_thumbnail" src="../images/<?php echo $user->getImg();?>" alt="">
                            </a>
                        </div>

						<div class="details_text">
							<p><?php echo $product->getDescripcion() ?></p>
						</div>

						<!-- Product Quantity -->
						<div class="product_quantity_container">
							<div class="product_quantity clearfix">
								<span>Cantidad</span>
								<input id="quantity_input" type="text" pattern="[0-9]*" value="1">
								<div class="quantity_buttons">
									<div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>
									<div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
								</div>
							</div>
							<div class="button cart_button"><a href="#">Añadir al carrito</a></div>
						</div>

						<!-- Share -->
						<div class="details_share">
							<span>Share:</span>
							<ul>
								<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="row description_row">
				<div class="col">
					<div class="description_title_container">
						<div class="description_title">Descripcion</div>
					</div>
					<div class="description_text">
						<p><?php echo $product->getDescripcion() ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="products">
        <div class="container">
            <div class="row">
                <div class="col text-center"><br>
                    <div class="products_title">Productos relacionados</div>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <div class="product_grid">
                        <?php foreach ($relatedProducts as $relatedProduct){ ?>
                            <!-- Product -->
                            <div class="product">
                                <?php switch ($relatedProduct->getCategoria()){ //switch per a saber la categoria, i aixi posar la carpeta indicada de l'imatge que mostrara
                                    case 1:
                                        ?>
                                        <div class="product_image"><img src="../images/botasFutbol/<?php echo $relatedProduct->getImg();?>" alt=""></div>
                                        <?php
                                        break;
                                    case 2:
                                        ?>
                                        <div class="product_image"><img src="../images/botasFutbolSala/<?php echo $relatedProduct->getImg();?>" alt=""></div>
                                        <?php
                                        break;
                                    case 3:
                                        ?>
                                        <div class="product_image"><img src="../images/camisetasEntrenamiento/<?php echo $relatedProduct->getImg();?>" alt=""></div>
                                        <?php
                                        break;
                                } ?>
                                <div class="product_content">
                                    <div class="product_title"><a href="<?php
                                        echo $route->generateURL('Product', 'getProductById', ['id' => $relatedProduct->getId()]) ?>"><?php echo $relatedProduct->getNombre()?></a></div>
                                    <div class="product_price"><?php echo $relatedProduct->getPrecio()?>€</div>
                                </div>
                            </div>
                        <?php } ?>

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
						<div class="newsletter_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam a ultricies metus. Sed nec molestie eros</p></div>
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
</php>
