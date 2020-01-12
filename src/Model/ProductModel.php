<?php

namespace App\Model;
use App\Entity\Product;
use PDO;
use DateTime;

class ProductModel
{
    private $pdo;
    protected $tableName = 'Productos';
    protected $className = 'App\Entity\Product';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * Aquesta funcio comprova que l'usuari siga el propietari del producte
     *
     * @param $product
     * @param $user
     * @return bool
     */

    public function verifyProductOwner($product, $user):bool{
        $userId = $user->getId();
        $productId = $product->getId();

        $stmt = $this->pdo->prepare('SELECT * FROM Productos WHERE Id = :id and Usuario = :usuario');
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':usuario', $userId, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
        $stmt->execute();
        return $stmt->rowCount()>0;

    }

    /**
     * Torna els productes dels que siga propietari l'usuari, amb els filtres que es seleccionen
     *
     * @param $start
     * @param $limit
     * @param $user
     * @param $categoria
     * @param $fechaMin
     * @param $fechaMax
     * @param $textFilter
     * @return array
     */

    public  function getProductsByUserFiltered($start, $limit, $user, $categoria, $fechaMin, $fechaMax, $textFilter): array {

        $idUser = $user->getId();
        $categoria = intval($categoria);

        $productos = "";

        $sql = "SELECT * FROM Productos WHERE Usuario = :usuario order by Fecha LIMIT :start, :limit";

        if (empty($fechaMin) && empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Sols categoria
            $sql = "SELECT * FROM Productos where (Usuario = :usuario) and (Categoria=:categoria) order by Fecha LIMIT :start, :limit";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //TOT
            $sql = "SELECT * FROM Productos where (Usuario = :usuario) and (Categoria=:categoria) and (Fecha BETWEEN :fechaMin AND :fechaMax) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha LIMIT :start, :limit";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && empty($categoria)){ //Sols dates
            $sql ="SELECT * FROM Productos where (Usuario = :usuario) and (Fecha BETWEEN :fechaMin AND :fechaMax) order by Fecha LIMIT :start, :limit";

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Sols text
            $sql = "SELECT * FROM Productos where (Usuario = :usuario) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha LIMIT :start, :limit";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Sols dates i text
            $sql = "SELECT * FROM Productos where (Usuario = :usuario) and (Fecha BETWEEN :fechaMin AND :fechaMax) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha LIMIT :start, :limit";

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //Sols categories i text
            $sql = "SELECT * FROM Productos where (Usuario = :usuario) and (Categoria = :categoria) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha LIMIT :start, :limit";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Sols categories i dates
            $sql = "SELECT * FROM Productos where (Usuario = :usuario) and (Categoria = :categoria) and (Fecha BETWEEN :fechaMin AND :fechaMax) order by Fecha LIMIT :start, :limit";

        }

        $result = $this->pdo->prepare($sql);

        if (empty($fechaMin) && empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Soles categoria
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //TOT
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);
            $textFilter = "%".$textFilter."%";
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && empty($categoria)){ //Soles dates
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Soles text
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $textFilter = "%".$textFilter."%";
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);
        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Text i dates
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $textFilter = "%".$textFilter."%";
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //Sols categories i text

            $textFilter = "%".$textFilter."%";

            $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Sols categories i dates
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);
        }

        $result->bindParam(":start", $start, PDO::PARAM_INT);
        $result->bindParam(":limit", $limit, PDO::PARAM_INT);
        $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);

        $result->execute();

        $productos = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);

        return $productos;

    }

    /**
     * Conta els productes de la funcio anterior, filtrats i que siguen de l'usuari
     *
     * @param $user
     * @param $categoria
     * @param $fechaMin
     * @param $fechaMax
     * @param $textFilter
     * @return int
     */
    public function countProductsByUserFiltered($user, $categoria, $fechaMin, $fechaMax, $textFilter):int{

        $idUser = $user->getId();

        $categoria = intval($categoria);

        $sql = "SELECT count(Id) as Id FROM Productos WHERE Usuario = :usuario";
        if (empty($fechaMin) && empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Soles categoria
            $sql = "SELECT count(Id) as Id FROM Productos where (Usuario = :usuario) and (Categoria=:categoria) order by Fecha";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //TOT
            $sql = "SELECT count(Id) as Id FROM Productos where (Usuario = :usuario) and (Categoria=:categoria) and (Fecha BETWEEN :fechaMin AND :fechaMax) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && empty($categoria)){ //Soles dates
            $sql ="SELECT count(Id) as Id FROM Productos where (Usuario = :usuario) and (Fecha BETWEEN :fechaMin AND :fechaMax) order by Fecha";

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Soles text
            $sql = "SELECT count(Id) as Id FROM Productos where (Usuario = :usuario) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Text i dates
            $sql = "SELECT count(Id) as Id FROM Productos where (Usuario = :usuario) and (Fecha BETWEEN :fechaMin AND :fechaMax) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha";

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //Sols categories i text
            $sql = "SELECT count(Id) as Id FROM Productos where (Usuario = :usuario) and (Categoria = :categoria) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Sols categories i dates
            $sql = "SELECT count(Id) as Id FROM Productos where (Usuario = :usuario) and (Categoria = :categoria) and (Fecha BETWEEN :fechaMin AND :fechaMax) order by Fecha";

        }

        $result = $this->pdo->prepare($sql);


        if (empty($fechaMin) && empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Soles categoria
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //TOT
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);
            $textFilter = "%".$textFilter."%";
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && empty($categoria)){ //Soles dates
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Soles text
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $textFilter = "%".$textFilter."%";
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Text i dates
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $textFilter = "%".$textFilter."%";
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //Sols categories i text
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $textFilter = "%".$textFilter."%";
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':categoria', $categoria, PDO::PARAM_STR);

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Sols categories i dates
            $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);
            $result->bindParam(':categoria', $categoria, PDO::PARAM_STR);
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);
        }
        $result->bindParam(':usuario', $idUser, PDO::PARAM_INT);

        $result->execute();
        $productsCount = $result->fetchAll(PDO::FETCH_ASSOC);

        $total = $productsCount[0]['Id'];

        return $total;

    }

    /**
     * Torna els productes filtrats
     *
     * @param $start
     * @param $limit
     * @param $categoria
     * @param $fechaMin
     * @param $fechaMax
     * @param $textFilter
     * @return array
     */
    public  function getProductsFiltered($start, $limit, $categoria, $fechaMin, $fechaMax, $textFilter): array {

            $categoria = intval($categoria);

            $sql = "SELECT * FROM Productos order by Fecha LIMIT :start,:limit";


        if (empty($fechaMin) && empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Soles categoria
                $sql = "SELECT * FROM Productos where Categoria=:categoria order by Fecha LIMIT :start,:limit";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //TOT
                $sql = "SELECT * FROM Productos where (Categoria=:categoria) and (Fecha BETWEEN :fechaMin AND :fechaMax) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha LIMIT :start,:limit";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && empty($categoria)){ //Soles dates
                $sql ="SELECT * FROM Productos where Fecha BETWEEN :fechaMin AND :fechaMax order by Fecha LIMIT :start,:limit";

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Soles text
                $sql = "SELECT * FROM Productos where Nombre LIKE :textFilter or Descripcion LIKE :textFilter2 order by Fecha LIMIT :start,:limit";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Text i dates
                $sql = "SELECT * FROM Productos where (Fecha BETWEEN :fechaMin AND :fechaMax) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha LIMIT :start,:limit";

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //Sols categories i text
                $sql = "SELECT * FROM Productos where (Categoria = :categoria) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha LIMIT :start,:limit";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Sols categories i dates
                $sql = "SELECT * FROM Productos where (Categoria = :categoria) and (Fecha BETWEEN :fechaMin AND :fechaMax) order by Fecha LIMIT :start,:limit";

            }

            $result = $this->pdo->prepare($sql);

            if (empty($fechaMin) && empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Soles categoria
                $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);

            }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //TOT
                $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);
                $result->bindParam(':fechaMin', $fechaMin);
                $result->bindParam(':fechaMax', $fechaMax);
                $textFilter = "%".$textFilter."%";
                $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
                $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);

            }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && empty($categoria)){ //Soles dates
                $result->bindParam(':fechaMin', $fechaMin);
                $result->bindParam(':fechaMax', $fechaMax);

            }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Soles text
                $textFilter = "%".$textFilter."%";
                $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
                $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);
            }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Text i dates
                $textFilter = "%".$textFilter."%";
                $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
                $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);
                $result->bindParam(':fechaMin', $fechaMin);
                $result->bindParam(':fechaMax', $fechaMax);

            }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //Sols categories i text
                $textFilter = "%".$textFilter."%";

                $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);
                $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
                $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);

            }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Sols categories i dates
                $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);
                $result->bindParam(':fechaMin', $fechaMin);
                $result->bindParam(':fechaMax', $fechaMax);
            }

            $result->bindParam(":start", $start, PDO::PARAM_INT);
            $result->bindParam(":limit", $limit, PDO::PARAM_INT);
            $result->execute();

            $productos = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);

        return $productos;

    }


    /**
     * Conta els productes de la funcio anterior
     *
     * @param $categoria
     * @param $fechaMin
     * @param $fechaMax
     * @param $textFilter
     * @return int
     */
    public function countProductsFiltered($categoria, $fechaMin, $fechaMax, $textFilter):int{
        $categoria = intval($categoria);

        $sql = "SELECT count(Id) as Id FROM Productos";
        if (empty($fechaMin) && empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Soles categoria
            $sql = "SELECT count(Id) as Id FROM Productos where Categoria=:categoria order by Fecha";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //TOT
            $sql = "SELECT count(Id) as Id FROM Productos where (Categoria=:categoria) and (Fecha BETWEEN :fechaMin AND :fechaMax) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && empty($categoria)){ //Soles dates
            $sql ="SELECT count(Id) as Id FROM Productos where Fecha BETWEEN :fechaMin AND :fechaMax order by Fecha";

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Soles text
            $sql = "SELECT count(Id) as Id FROM Productos where Nombre LIKE :textFilter or Descripcion LIKE :textFilter2 order by Fecha";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Text i dates
            $sql = "SELECT count(Id) as Id FROM Productos where (Fecha BETWEEN :fechaMin AND :fechaMax) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha";

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //Sols categories i text
            $sql = "SELECT count(Id) as Id FROM Productos where (Categoria = :categoria) and (Nombre LIKE :textFilter or Descripcion LIKE :textFilter2) order by Fecha";

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Sols categories i dates
            $sql = "SELECT count(Id) as Id FROM Productos where (Categoria = :categoria) and (Fecha BETWEEN :fechaMin AND :fechaMax) order by Fecha";

        }

        $result = $this->pdo->prepare($sql);


        if (empty($fechaMin) && empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Soles categoria
            $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //TOT
            $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);
            $textFilter = "%".$textFilter."%";
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && empty($categoria)){ //Soles dates
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Soles text
            $textFilter = "%".$textFilter."%";
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);

        }elseif(!empty($fechaMin) && !empty($fechaMax) && !empty($textFilter) && empty($categoria)){ //Text i dates
            $textFilter = "%".$textFilter."%";
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);

        }elseif(empty($fechaMin) && empty($fechaMax) && !empty($textFilter) && !empty($categoria)){ //Sols categories i text
            $textFilter = "%".$textFilter."%";
            $result->bindParam(':textFilter', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':textFilter2', $textFilter, PDO::PARAM_STR);
            $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);

        }elseif(!empty($fechaMin) && !empty($fechaMax) && empty($textFilter) && !empty($categoria)){ //Sols categories i dates
            $result->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $result->bindParam(':fechaMin', $fechaMin);
            $result->bindParam(':fechaMax', $fechaMax);
        }

        $result->execute();
        $productsCount = $result->fetchAll(PDO::FETCH_ASSOC);

        $total = $productsCount[0]['Id'];

        return $total;

    }


    /**
     * Torna un producte a partir de l'id del mateix
     *
     * @param int $id
     * @return Product
     */
    public function getById($id):Product {
        $id = intval($id);
        /*
        * A partir d'un Id busque en la base de dades el post que coincidixca
        * i el retorne
        */
        $stmt = $this->pdo->prepare('SELECT * FROM Productos WHERE Id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Torna un array amb tots els ids dels productes
     * per a poder traure'n un aleatori.
     *
     * @return array
     */
    public function getIdsProducts(): array{
        $stmt = $this->pdo->prepare('SELECT Id FROM Productos');
        $stmt->execute();

        while ($row = $stmt-> fetch ()) {
            $id[] = $row ['Id'];
        }
        return $id;
    }

    /**
     * Torna un producte aleatori, ho faig servir per a que
     * quan l'usuari li done a un producte, es recomanen 4 baix.
     *
     * @return Product
     * @throws Exception
     */
    public  function getRandomProduct(): Product {

        $array = $this->getIdsProducts();
        $v = array_rand($array);
        $id = $array[$v];

        $stmt = $this->pdo->prepare('SELECT * FROM Productos WHERE Id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
        $stmt->execute();

        $product = $stmt->fetch();

        return $product;

    }

    /**
     * Funcio per a insertar productes, a partir d'un usuari
     * aixi s'asignara el producte a l'usuari que l'ha creat
     *
     * @param Product $product
     * @param $usuario
     * @return bool
     */
    public function insert(Product $product, $usuario):bool {



        $statusMsg = '';

        $stmt = "";

        $date = $product->getFecha();
        $dateString = $date->format('Y-m-d H:i:s');
        $targetDir = "";

        switch ($product->getCategoria()){
            case 1:
                $targetDir = "/opt/lampp/htdocs/projecteServidors/images/botasFutbol/";
                break;
            case 2:
                $targetDir = "/opt/lampp/htdocs/projecteServidors/images/botasFutbolSala/";
                break;
            case 3:
                $targetDir = "/opt/lampp/htdocs/projecteServidors/images/camisetasEntrenamiento/";
                break;
        }

        // File upload path
        //$targetDir = "/opt/lampp/htdocs/projecteServidors/images/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);


        if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
            // Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                    $stmt = $this->pdo->prepare("INSERT INTO Productos (Nombre, Descripcion, Precio, Marca, Img, Categoria, Stock, Fecha, Usuario) values (:nombre, :descripcion, :precio, :marca, :img, :categoria, :stock, :fecha, :usuario)");

                    $stmt->bindValue(':nombre', $product->getNombre(), PDO::PARAM_STR);
                    $stmt->bindValue(':descripcion', $product->getDescripcion(), PDO::PARAM_STR);
                    $stmt->bindValue(':precio', $product->getPrecio());
                    $stmt->bindValue(':marca', $product->getMarca(), PDO::PARAM_INT);
                    $stmt->bindValue(':img', $fileName, PDO::PARAM_STR);
                    $stmt->bindValue(':categoria', $product->getCategoria(), PDO::PARAM_INT);
                    $stmt->bindValue(':stock', $product->getStock(), PDO::PARAM_STR);
                    $stmt->bindValue(':fecha', $dateString);
                    $stmt->bindValue(':usuario', $usuario->getId(), PDO::PARAM_INT);

                    $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product');

                    $stmt->execute();
                    if ($stmt) {
                        $statusMsg = "La imagen " . $fileName . " se ha subido con exito.";
                    } else {
                        $statusMsg = "La subida ha fallado..";
                    }
                } else {
                    $statusMsg = "Hay un error en la subida de la imagen.";
                }
            } else {
                $statusMsg = 'Solo se admite JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
            }
        } else {
            $statusMsg = 'Por favor selecciona una imagen.';
        }


        //Si es major que 0 vol dir que si que s'ha fet l'insert
        return $stmt->fetch()>0;
    }


    /**
     * Funcio per a modificar productes
     *
     * @param Product $product
     * @return bool
     */
    public function update(Product $product):bool {

        $id = $product->getId();

        $nombre = $product->getNombre();
        $descripcion = $product->getDescripcion();
        $precio = $product->getPrecio();
        $marca = $product->getMarca();
        $img = $product->getImg();
        $categoria = $product->getCategoria();
        $stock = $product->getStock();

        $date = $product->getFecha();
        /*
         * Canvie la data a format string per a poder modificarla en la base de dades
         * ja que si no ho faig dona error
         */

        $dateString = $date->format('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("UPDATE Productos set Nombre = :nombre, Descripcion = :descripcion, Precio = :precio, Marca = :marca, Img = :img, Categoria = :categoria, Stock = :stock, Fecha = :fecha WHERE Id = :id");

        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre',$nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion',$descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':precio',$precio);
        $stmt->bindParam(':marca',$marca, PDO::PARAM_INT);
        $stmt->bindParam(':img',$img, PDO::PARAM_STR);
        $stmt->bindParam(':categoria',$categoria, PDO::PARAM_INT);
        $stmt->bindParam(':stock',$stock, PDO::PARAM_STR);
        $stmt->bindParam(':fecha',$dateString, PDO::PARAM_STR);

        $stmt->execute();

        //Si es major que 0 vol dir que si que s'ha fet l'update
        return $stmt->rowCount()>0;
    }


    /**
     * Funcio per a borrar un producte
     *
     * @param Product $product
     * @return bool|string
     */
    public function delete(Product $product) {
        //Agarre l'id del post que vull per el link
        $id = $product->getId();

        try{

            $stmt = $this->pdo->prepare('DELETE FROM Productos WHERE Id=:id');

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            //$stmt->execute();
            $stmt->execute();

            return $stmt->rowCount()>0;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }




    /**
     * Rep un objecte Post i comprova que les propietats siguen vàlides.
     * Comprova que siga, string, int, etc.
     *
     * @param Product $product
     * @return array
     */
    public function validate(Product $product):array {
        $errors = [];

        if (empty($product->getNombre())) {
            $errors[] = "Nombre no pot ser buit";
        }

        if (empty($product->getDescripcion())) {
            $errors[] = "Descripción no pot ser buit";
        }

        if (empty($product->getPrecio())) {
            $errors[] = "Precio no pot ser buit";
        }

        if (empty($product->getStock())) {
            $errors[] = "Stock no pot ser buit";
        }

        /*
        if (empty($product->getImg())) {
            $errors[] = "No s'ha seleccionat cap imatge";
        }
        */

        if (empty($product->getFecha())) {
            $errors[] = "Fecha no pot ser buit";
        }

        return $errors;
    }


    /**
     * Funcio per a plenar un producte a traves dels POST
     *
     * @return Product
     * @throws Exception
     */
    public function fillData():Product{

        $product = new Product();

        /*
         * Valide que s'agarra el que toca dels inputs
         * Agarra el que li pasem per $_POST[''] i ho filtra
         */

        $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
        $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING));
        $precio = trim(filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT));
        $marca = trim(filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_STRING));
        $img = trim(filter_input(INPUT_POST, 'file'));
        $categoria = trim(filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING));
        $stock = trim(filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_STRING));
        $fecha = trim(filter_input(INPUT_POST, 'fecha'));

        $marcaResult = 0;
        $categoriaResult = 0;

        switch ($marca){
            case "adidas":
                $marcaResult = 1;
                break;

            case "nike":
                $marcaResult = 2;
                break;

            case "puma";
                $marcaResult = 3;
                break;
        }

        switch ($categoria){
            case "botasFutbol":
                $categoriaResult = 1;
                break;

            case "botasFutbolSala":
                $categoriaResult = 2;
                break;

            case "camisetasEntrenamiento";
                $categoriaResult = 3;
                break;
        }

        //Id	Nombre	Descripcion	Precio	Marca	Img	Categoria	Stock



        $product->setNombre($nombre);
        $product->setDescripcion($descripcion);
        $product->setPrecio(doubleval($precio));
        $product->setMarca($marcaResult);
        $product->setImg($img);
        $product->setCategoria($categoriaResult);
        $product->setStock($stock);
        $product->setFecha(new DateTime($fecha));


        return $product;
    }
}