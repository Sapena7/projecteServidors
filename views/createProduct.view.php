<!DOCTYPE html>
<html lang="en">
<head>
    <title>Crear producto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<main class="container" style="margin-top:30px">

    <div class="col-sm-8">
        <h2>Crear producto</h2>
        <hr>
        <br>
    </div>
    </div>

    <form action="<?php echo $route->generateURL('Product', 'createProduct') ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" >
        </div>
        <div class="form-group">
            <label for="descripcion">Descripcion</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="text" class="form-control" id="precio" name="precio" >
        </div>
       Marca <br>
        <select name="marca">
            <option value="adidas">Adidas</option>
            <option value="nike">Nike</option>
            <option value="puma">Puma</option>
        </select><br><br>
        <div class="form-group">
            <input type="file" id="file" name="file">
        </div>
        Categoria <br>
        <select name="categoria">
            <option value="botasFutbol">Botas de futbol</option>
            <option value="botasFutbolSala">Botas de futbol sala</option>
            <option value="camisetasEntrenamiento">Camisetas de entrenamiento</option>
        </select>
        <div class="form-group">
            <br><label for="stock">Stock</label>
            <input type="text" class="form-control" id="stock" name="stock" >
        </div>
        <div class="form-group">
            <label>Fecha</label>
            <input type="date" class="form-control" name="fecha" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <?php
            if ($_SESSION['rol'] == 1){ ?>
                <a href='<?php echo $route->generateURL('Product', 'editProductsUser') ?>'>
                    <button type="submit" name="submit" class="btn btn-primary">Volver</button>
                </a>
            <?php } ?>
        <?php
        if ($_SESSION['rol'] == 2){ ?>
            <a href='<?php echo $route->generateURL('Product', 'getAdminProducts') ?>'>
                <button type="submit" name="submit" class="btn btn-primary">Volver</button>
            </a>
        <?php } ?>
        <?php print_r($_POST)?>
    </form>
</main>
</body>
</html>