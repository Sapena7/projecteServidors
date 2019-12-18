<!DOCTYPE html>
<html lang="en">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="../styles/dashboard.css">
<link rel="stylesheet" type="text/css" href="../styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="../styles/table.css">
<link rel="stylesheet" type="text/js" href="../js/table.css">

<!------ Include the above in your HEAD tag ---------->

<div id="throbber" style="display:none; min-height:120px;"></div>
<div id="noty-holder"></div>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="logo2"><a href="#">Futbol Shop.</a></div>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li><a href="#" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="Stats"><i class="fa fa-bar-chart-o"></i>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $nombre ?> <b class="fa fa-angle-down"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="fa fa-fw fa-user"></i> Edit Profile</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-cog"></i> Change Password</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="fa fa-fw fa-power-off"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li>
                    <a href=""<?php
                    echo $route->generateURL('Product', 'getAdminProducts') ?>""><i class="fa fa-fw fa-user-plus"></i> Productos</a>
                </li>
                <li>
                    <a href="<?php
                    echo $route->generateURL('Product', 'index') ?>">Tienda</a>
                </li>
                <li>
                    <a href="<?php
                    echo $route->generateURL('User', 'logout') ?>">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row" id="main" >
                <div class="col-sm-12 col-md-12 well" id="content">
                    <div class="container">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-8"><h2>Productos</h2></div>
                                    <div class="col-sm-4">
                                        <a href="<?php
                                        echo $route->generateURL('Product', 'createProduct') ?>">
                                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Añadir Producto</button>
                                        </a>
                                    </div>
                                </div>
                                <br>
                                <!-- Product Sorting -->
                                <form action="<?php
                                echo $route->generateURL('Product', 'getAdminProducts') ?>" name="search_form" method="GET">
                                    <input type="hidden" name="page" value="<?= $_GET['page'] ?? "index";?>">
                                    <input type="hidden" name="pages" value="<?php echo $pagePagination;?>">

                                    <td>Fecha Inicio:</td>
                                    <input type="date" name="fechaMin" style="width: 160px">


                                    <td>Fecha Final:</td>
                                    <input type="date" name="fechaMax" style="width: 160px">

                                    <input class="text" type="text" name="textFilter">

                                    <input type="submit" name="search" value="Filtrar">
                                </form>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Precio</th>
                                    <th>Marca</th>
                                    <th>Img</th>
                                    <th>Categoria</th>
                                    <th>Stock</th>
                                    <th>Fecha</th>
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($productsAdmin as $product){

                                    //Pasar a string per a poder-ho mostrar
                                    $date = $product->getFecha();
                                    $dateString = $date->format('Y-m-d');
                                    ?>
                                <tr>
                                    <td><?php echo $product->getId();?></td>
                                    <td><?php echo $product->getNombre();?></td>
                                    <td class="cortar"><?php echo $product->getDescripcion();?></td>
                                    <td><?php echo $product->getPrecio() . "€" ;?></td>
                                    <td><?php echo $product->getMarca();?></td>
                                    <td class="cortar"><?php echo $product->getImg();?></td>
                                    <td><?php echo $product->getCategoria();?></td>
                                    <td><?php echo $product->getStock();?></td>
                                    <td><?php echo $dateString;?></td>
                                    <td>
                                        <!--<a class="add" title="Añadir" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>-->
                                        <a href="<?php
                                        echo $route->generateURL('Product', 'modifyProduct', ['id' => $product->getId()])?>" class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                        <a href="<?php
                                        echo $route->generateURL('Product', 'deleteProduct', ['id' => $product->getId()])?>" class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                    </td>
                                </tr>
                                <?php }?>
                                </tbody>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                    if ($previous!=0){ ?>
                                        <li class="active"><a href="<?php
                                            echo $route->generateURL('Product', 'getAdminProducts') . "?pages=" . $previous . $categoria . $fechaMin . $fechaMax . $textFilter;?>">Previous</a></li>
                                    <?php }
                                    ?>

                                    <?php
                                    for ($i = 1; $i<=$pages; $i++){?>
                                        <li class="active"><a href="<?php
                                            echo $route->generateURL('Product', 'getAdminProducts') . "?pages=" . $i . $categoria . $fechaMin . $fechaMax . $textFilter;?>"><?=$i?></a></li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($next<=$pages){ ?>
                                        <li class="active"><a href="<?php
                                            echo $route->generateURL('Product', 'getAdminProducts') . "?pages=" . $next . $categoria . $fechaMin . $fechaMax . $textFilter;?>">Next</a></li>
                                    <?php }?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div><!-- /#wrapper -->>
