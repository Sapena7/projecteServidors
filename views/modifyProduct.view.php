<!DOCTYPE html>
<html lang="en">
<head>
    <title>Modificar producto</title>
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
        <h2>Modificar producto</h2>
        <hr>
        <br>
    </div>
    </div>
    <?php
        $date = $productNotModified->getFecha();
        $dateString = $date->format('Y-m-d');
    ?>

    <form action="<?php
    echo $route->generateURL('Product', 'modifyProduct', ['id' => $productNotModified->getId()])?>" method="post">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $productNotModified->getNombre() ?>">
        </div>
        <div class="form-group">
            <label for="descripcion">Descripcion</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="3"><?php echo $productNotModified->getDescripcion() ?></textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $productNotModified->getPrecio() ?>" >
        </div>
        Marca <br>
        <select name="marca">
            <?php if ($productNotModified->getMarca() == 1) { ?>
                <option value="nike" selected>Nike</option>
                <?php
            }else{ ?>
                <option value="nike">Nike</option>
                <?php
            }?>

            <?php if ($productNotModified->getMarca() == 2) { ?>
                <option value="adidas" selected>Adidas</option>
            <?php
            }else{ ?>
                <option value="adidas">Adidas</option>
            <?php
            }?>

            <?php if ($productNotModified->getMarca() == 3) { ?>
                <option value="puma" selected>Puma</option>
                <?php
            }else{ ?>
                <option value="puma">Puma</option>
                <?php
            }?>

        </select><br><br>

        <?php
        switch ($productNotModified->getCategoria()){
                case 1:
                    ?>
                    <img src="../images/botasFutbol/<?php echo $productNotModified->getImg();?>" width="150px" height="150px" alt=""><br>
        <?php
                break;
            case 2:
                ?>
                <img src="../images/botasFutbolSala/<?php echo $productNotModified->getImg();?>" width="150px" height="150px" alt=""><br>
        <?php
                break;
            case 3:
                ?>
                <img src="../images/camisetasEntrenamiento/<?php echo $productNotModified->getImg();?>" width="150px" height="150px" alt=""><br>
        <?php
                break;
        }
        ?>

        <input type="file" name="file">


        <br>Categoria <br>
        <select name="categoria">
            <?php if ($productNotModified->getCategoria() == 1) { ?>
                <option value="botasFutbol" selected>Botas de futbol</option>
                <?php
            }else{ ?>
                <option value="botasFutbol">Botas de futbol</option>
                <?php
            }?>

            <?php if ($productNotModified->getCategoria() == 2) { ?>
                <option value="botasFutbolSala" selected>Botas de futbol sala</option>
                <?php
            }else{ ?>
                <option value="botasFutbolSala">Botas de futbol sala</option>
                <?php
            }?>

            <?php if ($productNotModified->getCategoria() == 3) { ?>
                <option value="camisetasEntrenamiento" selected>Camisetas de entrenamiento</option>
                <?php
            }else{ ?>
                <option value="camisetasEntrenamiento">Camisetas de entrenamiento</option>
                <?php
            }?>


        </select>
        <div class="form-group">
            <br><label for="stock">Stock</label>
            <input type="text" class="form-control" id="stock" name="stock" value="<?php echo $productNotModified->getStock() ?>" >
        </div>

        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" name="fecha" value="<?php echo $dateString; ?>">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</main>
</body>
</html>