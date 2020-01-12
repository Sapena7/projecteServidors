<?php


namespace App\Controller;

use App\Model\ProductModel;
use App\Model\UserModel;
use App\Entity\Product;

class ProductController extends AbstractController{

    public function index()
    {

        session_start();
        if(isset($_SESSION['nombre'])){
            $nombre = $_SESSION['nombre'];
        }else{
            $nombre = "";
        }
        if(isset($_SESSION['rol'])){
            $rol = $_SESSION['rol'];
        }else{
            $rol = "";
        }
        if(isset($_SESSION['Id'])){
            $id = $_SESSION['Id'];
        }else{
            $id = "";
        }

        try {
            $model = new ProductModel($this->db);
            $modelUser = new UserModel($this->db);

            if (!empty($id)){
                $user = $modelUser->getUserInformation($id); //Per a que mostre l'opcio de editar
            }else{
                $user = null;
            }


            $categoria = filter_input(INPUT_GET, "categoria", FILTER_SANITIZE_NUMBER_INT);
            $fechaMin = filter_input(INPUT_GET, "fechaMin", FILTER_SANITIZE_STRING);
            $fechaMax = filter_input(INPUT_GET, "fechaMax", FILTER_SANITIZE_STRING);
            $textFilter = filter_input(INPUT_GET, "textFilter", FILTER_SANITIZE_STRING);
            $usuario = filter_input(INPUT_GET, "usuario", FILTER_VALIDATE_INT);

            $id = null; //Per a que no entre en els productes de l'usuari


            $limit = 12;
            $pagePagination = isset($_GET['pages']) ? $_GET['pages'] : 1; //Agarra el numero de la pagina, en cas de que no hi haja, pagina sera 1
            $start = ($pagePagination - 1) * $limit;

            /*
             * Mostra els productes de l'usuari actual en cas de
             * que haja fet login.
             *
             * Si no ha fet login, mostra tots els productes
             * de la tenda.
             */

            $productsFiltered = $model->getProductsFiltered($start, $limit, $categoria, $fechaMin, $fechaMax, $textFilter);
            $total = $model->countProductsFiltered($categoria, $fechaMin, $fechaMax, $textFilter);

            $pages = ceil($total / $limit);
            $previous = $pagePagination - 1;
            $next = $pagePagination + 1;

            $filersShow = [$usuario, $categoria, $fechaMax, $fechaMin, $textFilter];

            if (!empty($usuario)){
                $usuario = "&usuario=".$usuario;
            } else {
                $usuario = "";
            }
            if (!empty($categoria)){
                $categoria = "&categoria=".$categoria;
            } else {
                $categoria = "";
            }

            if (!empty($fechaMin)){
                $fechaMin = "&fechaMin=".$fechaMin;
            } else {
                $fechaMin = "";
            }

            if (!empty($fechaMax)){
                $fechaMax = "&fechaMax=".$fechaMax;
            } else {
                $fechaMax = "";
            }

            if (!empty($textFilter)){
                $textFilter = "&textFilter=".$textFilter;
            } else {
                $textFilter = "";
            }

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage() . $e->getLine();
        }
        require('views/index.view.php');
        return "";
    }

    public function getProductsFiltered(){

        session_start();
        if(isset($_SESSION['nombre'])){
            $nombre = $_SESSION['nombre'];
        }else{
            $nombre = "";
        }
        if(isset($_SESSION['rol'])){
            $rol = $_SESSION['rol'];
        }else{
            $rol = "";
        }
        if(isset($_SESSION['Id'])){
            $id = $_SESSION['Id'];
        }else{
            $id = "";
        }

        try {
            $model = new ProductModel($this->db);
            $modelUser = new UserModel($this->db);

            if (!empty($id)){
                $user = $modelUser->getUserInformation($id);
            }else{
                $user = null;
            }


            $categoria = filter_input(INPUT_GET, "categoria", FILTER_SANITIZE_NUMBER_INT);
            $fechaMin = filter_input(INPUT_GET, "fechaMin", FILTER_SANITIZE_STRING);
            $fechaMax = filter_input(INPUT_GET, "fechaMax", FILTER_SANITIZE_STRING);
            $textFilter = filter_input(INPUT_GET, "textFilter", FILTER_SANITIZE_STRING);
            $usuario = filter_input(INPUT_GET, "usuario", FILTER_VALIDATE_INT);
            $id = null;

            $limit = 12;
            $pagePagination = isset($_GET['pages']) ? $_GET['pages'] : 1; //Agarra el numero de la pagina, en cas de que no hi haja, pagina sera 1
            $start = ($pagePagination - 1) * $limit;

            /*
              * Mostra els productes de l'usuari actual en cas de
              * que haja fet login.
              *
              * Si no ha fet login, mostra tots els productes
              * de la tenda.
              */


                $productsFiltered = $model->getProductsFiltered($start, $limit, $categoria, $fechaMin, $fechaMax, $textFilter);
                $total = $model->countProductsFiltered($categoria, $fechaMin, $fechaMax, $textFilter);

            $pages = ceil($total / $limit);

            $previous = $pagePagination - 1;
            $next = $pagePagination + 1;

            if (!empty($usuario)){
                $usuario = "&usuario=".$usuario;
            } else {
                $usuario = "";
            }
            if (!empty($categoria)){
                $categoria = "&categoria=".$categoria;
            } else {
                $categoria = "";
            }

            if (!empty($fechaMin)){
                $fechaMin = "&fechaMin=".$fechaMin;
            } else {
                $fechaMin = "";
            }

            if (!empty($fechaMax)){
                $fechaMax = "&fechaMax=".$fechaMax;
            } else {
                $fechaMax = "";
            }

            if (!empty($textFilter)){
                $textFilter = "&textFilter=".$textFilter;
            } else {
                $textFilter = "";
            }

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage() . $e->getLine();
        }
        require('views/index.view.php');
        return "";
    }

    public function getProductsFilteredByUser($id){

        session_start();
        if(isset($_SESSION['nombre'])){
            $nombre = $_SESSION['nombre'];
        }else{
            $nombre = "";
        }
        if(isset($_SESSION['rol'])){
            $rol = $_SESSION['rol'];
        }else{
            $rol = "";
        }
        if(isset($_SESSION['Id'])){
            $id = $_SESSION['Id'];
        }else{
            $id = "";
        }

        try {
            $model = new ProductModel($this->db);
            $modelUser = new UserModel($this->db);

            if (!empty($id)){
                $user = $modelUser->getUserInformation($id);
            }else{
                $user = null;
            }


            $categoria = filter_input(INPUT_GET, "categoria", FILTER_SANITIZE_NUMBER_INT);
            $fechaMin = filter_input(INPUT_GET, "fechaMin", FILTER_SANITIZE_STRING);
            $fechaMax = filter_input(INPUT_GET, "fechaMax", FILTER_SANITIZE_STRING);
            $textFilter = filter_input(INPUT_GET, "textFilter", FILTER_SANITIZE_STRING);
            //$usuario = filter_input(INPUT_GET, "usuario", FILTER_VALIDATE_INT);


            $limit = 12;
            $pagePagination = isset($_GET['pages']) ? $_GET['pages'] : 1; //Agarra el numero de la pagina, en cas de que no hi haja, pagina sera 1
            $start = ($pagePagination - 1) * $limit;

            /*
             * Mostra els productes de l'usuari actual en cas de
             * que haja fet login.
             */

            /*
            * Si no ha fet login, mostra tots els productes
             * de la tenda.
            */
            if (!empty($user)){
                $user = $modelUser->getUserInformation($id);
                $productsFiltered = $model->getProductsByUserFiltered($start, $limit, $user, $categoria, $fechaMin, $fechaMax, $textFilter);
                $total = $model->countProductsByUserFiltered($user, $categoria, $fechaMin, $fechaMax, $textFilter);
            }else{
                $productsFiltered = $model->getProductsFiltered($start, $limit, $categoria, $fechaMin, $fechaMax, $textFilter);
                $total = $model->countProductsFiltered($categoria, $fechaMin, $fechaMax, $textFilter);
            }

            $pages = ceil($total / $limit);

            $previous = $pagePagination - 1;
            $next = $pagePagination + 1;

            if (!empty($usuario)){
                $usuario = "&usuario=".$usuario;
            } else {
                $usuario = "";
            }
            if (!empty($categoria)){
                $categoria = "&categoria=".$categoria;
            } else {
                $categoria = "";
            }

            if (!empty($fechaMin)){
                $fechaMin = "&fechaMin=".$fechaMin;
            } else {
                $fechaMin = "";
            }

            if (!empty($fechaMax)){
                $fechaMax = "&fechaMax=".$fechaMax;
            } else {
                $fechaMax = "";
            }

            if (!empty($textFilter)){
                $textFilter = "&textFilter=".$textFilter;
            } else {
                $textFilter = "";
            }

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage() . $e->getLine();
        }
        require('views/index.view.php');
        return "";
    }

    public function getBotasFutbol(){
        /*
             * En aquesta pàgina es mostren els productes
             * de la categoria de botes de futbol
             */

        try {
            session_start();

            $model = new ProductModel($this->db);

            $categoria = "";
            $fechaMin = "";
            $fechaMax = "";
            $textFilter = "";

            $productCategory = 1;
            $fechaMin = filter_input(INPUT_GET, "fechaMin", FILTER_SANITIZE_STRING);
            $fechaMax = filter_input(INPUT_GET, "fechaMax", FILTER_SANITIZE_STRING);
            $textFilter = filter_input(INPUT_GET, "textFilter", FILTER_SANITIZE_STRING);

            $limit = 6;
            $pagePagination = isset($_GET['pages']) ? $_GET['pages'] : 1; //Agarra el numero de la pagina, en cas de que no hi haja, pagina sera 1
            $start = ($pagePagination - 1) * $limit;

            /*
             * Filtrem per la categoria i per els filtres que
             * l'usuari indique
             */

            $products = $model->getProductsFiltered($start, $limit, $productCategory, $fechaMin, $fechaMax, $textFilter);
            $total = $model->countProductsFiltered($productCategory, $fechaMin, $fechaMax, $textFilter);

            $pages = ceil($total / $limit);

            $previous = $pagePagination - 1;
            $next = $pagePagination + 1;


            if (!empty($fechaMin)){
                $fechaMin = "&fechaMin=".$fechaMin;
            } else {
                $fechaMin = "";
            }

            if (!empty($fechaMax)){
                $fechaMax = "&fechaMax=".$fechaMax;
            } else {
                $fechaMax = "";
            }

            if (!empty($textFilter)){
                $textFilter = "&textFilter=".$textFilter;
            } else {
                $textFilter = "";
            }

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage();
        }
        require('views/botasFutbol.view.php');
        return "";
    }

    public function getBotasFutbolFiltered(){
            /*
             * En aquesta pàgina es mostren els productes
             * de la categoria de botes de futbol
             */

        try {
            session_start();

            $model = new ProductModel($this->db);

            $categoria = "";
            $fechaMin = "";
            $fechaMax = "";
            $textFilter = "";

            $productCategory = 1;
            $fechaMin = filter_input(INPUT_GET, "fechaMin", FILTER_SANITIZE_STRING);
            $fechaMax = filter_input(INPUT_GET, "fechaMax", FILTER_SANITIZE_STRING);
            $textFilter = filter_input(INPUT_GET, "textFilter", FILTER_SANITIZE_STRING);

            $limit = 6;
            $pagePagination = isset($_GET['pages']) ? $_GET['pages'] : 1; //Agarra el numero de la pagina, en cas de que no hi haja, pagina sera 1
            $start = ($pagePagination - 1) * $limit;

            /*
             * Filtrem per la categoria i per els filtres que
             * l'usuari indique
             */

            $products = $model->getProductsFiltered($start, $limit, $productCategory, $fechaMin, $fechaMax, $textFilter);
            $total = $model->countProductsFiltered($productCategory, $fechaMin, $fechaMax, $textFilter);

            $pages = ceil($total / $limit);

            $previous = $pagePagination - 1;
            $next = $pagePagination + 1;


            if (!empty($fechaMin)){
                $fechaMin = "&fechaMin=".$fechaMin;
            } else {
                $fechaMin = "";
            }

            if (!empty($fechaMax)){
                $fechaMax = "&fechaMax=".$fechaMax;
            } else {
                $fechaMax = "";
            }

            if (!empty($textFilter)){
                $textFilter = "&textFilter=".$textFilter;
            } else {
                $textFilter = "";
            }

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage();
        }
        require('views/botasFutbol.view.php');
        return "";
    }

    public function getBotasFutbolSala(){

        try {
            session_start();
            $model = new ProductModel($this->db);

            $categoria = "";
            $fechaMin = "";
            $fechaMax = "";
            $textFilter = "";

            $productCategory = 2;
            $fechaMin = filter_input(INPUT_GET, "fechaMin", FILTER_SANITIZE_STRING);
            $fechaMax = filter_input(INPUT_GET, "fechaMax", FILTER_SANITIZE_STRING);
            $textFilter = filter_input(INPUT_GET, "textFilter", FILTER_SANITIZE_STRING);

            $limit = 4;
            $pagePagination = isset($_GET['pages']) ? $_GET['pages'] : 1; //Agarra el numero de la pagina, en cas de que no hi haja, pagina sera 1
            $start = ($pagePagination - 1) * $limit;

            //$products = $model->getFootballBoots($start, $limit);
            $products = $model->getProductsFiltered($start, $limit, $productCategory, $fechaMin, $fechaMax, $textFilter);
            $total = $model->countProductsFiltered($productCategory, $fechaMin, $fechaMax, $textFilter);

            $pages = ceil($total / $limit);

            $previous = $pagePagination - 1;
            $next = $pagePagination + 1;


            if (!empty($fechaMin)){
                $fechaMin = "&fechaMin=".$fechaMin;
            } else {
                $fechaMin = "";
            }

            if (!empty($fechaMax)){
                $fechaMax = "&fechaMax=".$fechaMax;
            } else {
                $fechaMax = "";
            }

            if (!empty($textFilter)){
                $textFilter = "&textFilter=".$textFilter;
            } else {
                $textFilter = "";
            }

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage();
        }

        require('views/botasFutbolSala.view.php');
        return "";
    }

    public function getBotasFutbolSalaFiltered(){

        try {
            session_start();
            $model = new ProductModel($this->db);

            $categoria = "";
            $fechaMin = "";
            $fechaMax = "";
            $textFilter = "";

            $productCategory = 2;
            $fechaMin = filter_input(INPUT_GET, "fechaMin", FILTER_SANITIZE_STRING);
            $fechaMax = filter_input(INPUT_GET, "fechaMax", FILTER_SANITIZE_STRING);
            $textFilter = filter_input(INPUT_GET, "textFilter", FILTER_SANITIZE_STRING);

            $limit = 4;
            $pagePagination = isset($_GET['pages']) ? $_GET['pages'] : 1; //Agarra el numero de la pagina, en cas de que no hi haja, pagina sera 1
            $start = ($pagePagination - 1) * $limit;

            //$products = $model->getFootballBoots($start, $limit);
            $products = $model->getProductsFiltered($start, $limit, $productCategory, $fechaMin, $fechaMax, $textFilter);
            $total = $model->countProductsFiltered($productCategory, $fechaMin, $fechaMax, $textFilter);

            $pages = ceil($total / $limit);

            $previous = $pagePagination - 1;
            $next = $pagePagination + 1;


            if (!empty($fechaMin)){
                $fechaMin = "&fechaMin=".$fechaMin;
            } else {
                $fechaMin = "";
            }

            if (!empty($fechaMax)){
                $fechaMax = "&fechaMax=".$fechaMax;
            } else {
                $fechaMax = "";
            }

            if (!empty($textFilter)){
                $textFilter = "&textFilter=".$textFilter;
            } else {
                $textFilter = "";
            }

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage();
        }

        require('views/botasFutbolSala.view.php');
        return "";
    }

    public function getCamisetasEntrenamiento(){

        try {
            session_start();
            $model = new ProductModel($this->db);

            $categoria = "";
            $fechaMin = "";
            $fechaMax = "";
            $textFilter = "";

            $productCategory = 3;
            $fechaMin = filter_input(INPUT_GET, "fechaMin", FILTER_SANITIZE_STRING);
            $fechaMax = filter_input(INPUT_GET, "fechaMax", FILTER_SANITIZE_STRING);
            $textFilter = filter_input(INPUT_GET, "textFilter", FILTER_SANITIZE_STRING);

            $limit = 6;
            $pagePagination = isset($_GET['pages']) ? $_GET['pages'] : 1; //Agarra el numero de la pagina, en cas de que no hi haja, pagina sera 1
            $start = ($pagePagination - 1) * $limit;

            //$products = $model->getFootballBoots($start, $limit);
            $products = $model->getProductsFiltered($start, $limit, $productCategory, $fechaMin, $fechaMax, $textFilter);
            $total = $model->countProductsFiltered($productCategory, $fechaMin, $fechaMax, $textFilter);

            $pages = ceil($total / $limit);

            $previous = $pagePagination - 1;
            $next = $pagePagination + 1;


            if (!empty($fechaMin)){
                $fechaMin = "&fechaMin=".$fechaMin;
            } else {
                $fechaMin = "";
            }

            if (!empty($fechaMax)){
                $fechaMax = "&fechaMax=".$fechaMax;
            } else {
                $fechaMax = "";
            }

            if (!empty($textFilter)){
                $textFilter = "&textFilter=".$textFilter;
            } else {
                $textFilter = "";
            }

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage();
        }


        require('views/camisetasEntrenamiento.view.php');
        return "";
    }

    public function getCamisetasEntrenamientoFiltered(){

        try {
            session_start();
            $model = new ProductModel($this->db);

            $categoria = "";
            $fechaMin = "";
            $fechaMax = "";
            $textFilter = "";

            $productCategory = 3;
            $fechaMin = filter_input(INPUT_GET, "fechaMin", FILTER_SANITIZE_STRING);
            $fechaMax = filter_input(INPUT_GET, "fechaMax", FILTER_SANITIZE_STRING);
            $textFilter = filter_input(INPUT_GET, "textFilter", FILTER_SANITIZE_STRING);

            $limit = 6;
            $pagePagination = isset($_GET['pages']) ? $_GET['pages'] : 1; //Agarra el numero de la pagina, en cas de que no hi haja, pagina sera 1
            $start = ($pagePagination - 1) * $limit;

            //$products = $model->getFootballBoots($start, $limit);
            $products = $model->getProductsFiltered($start, $limit, $productCategory, $fechaMin, $fechaMax, $textFilter);
            $total = $model->countProductsFiltered($productCategory, $fechaMin, $fechaMax, $textFilter);

            $pages = ceil($total / $limit);

            $previous = $pagePagination - 1;
            $next = $pagePagination + 1;


            if (!empty($fechaMin)){
                $fechaMin = "&fechaMin=".$fechaMin;
            } else {
                $fechaMin = "";
            }

            if (!empty($fechaMax)){
                $fechaMax = "&fechaMax=".$fechaMax;
            } else {
                $fechaMax = "";
            }

            if (!empty($textFilter)){
                $textFilter = "&textFilter=".$textFilter;
            } else {
                $textFilter = "";
            }

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage();
        }


        require('views/camisetasEntrenamiento.view.php');
        return "";
    }

    public function getCategories(){
        session_start();
        $nombre = $_SESSION['nombre'];

        require('views/categories.view.php');
        return "";
    }

    public function getProductById($id){
        session_start();
        try {

            $model = new ProductModel($this->db);
            $modelUser = new UserModel($this->db);

            $product = $model->getById($id);

            $user = $modelUser->getUserInformation($product->getUsuario());


            /*
             * Creem 4 productes aleatoris per a que els
             * recomane al clicar en un producte.
             */
            $relatedProduct1 = $model->getRandomProduct();
            $relatedProduct2 = $model->getRandomProduct();
            $relatedProduct3 = $model->getRandomProduct();
            $relatedProduct4 = $model->getRandomProduct();

            /*
             * Els afegixc a un array, i els recorrec en la vista
             */
            $relatedProducts = [$relatedProduct1, $relatedProduct2, $relatedProduct3, $relatedProduct4];

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage();
        }

        //require('views/product.view.php');
        $properties = ["nom" => $product->getNombre(),
            "product"=> $product, "session" => $_SESSION, "relatedProducts" => $relatedProducts, "user" => $user];
        return $this->render('show.twig', $properties);
    }

    public function modifyProduct($id){
        global $route;
        session_start();

        $idUser = $_SESSION['Id'];

        if (!isset($_SESSION['rol'])) {
            header("location: " . $route->generateURL('User', 'login'));
        }

        try {

            $model = new ProductModel($this->db);
            $modelUser = new UserModel($this->db);

            $usuario = $modelUser->getUserInformation($idUser);

            $productNotModified = $model->getById($id);
            $productModified = $model->fillData();

            $productModified->setId($id);
            $errors = $model->validate($productModified);

            /*
             * Verifica si l'usuari es propietari del producte
             */
            $isOwner = $model->verifyProductOwner($productNotModified, $usuario);

            /*
             * Verifica si l'usuari es administrador
             */
            $isAdmin = $modelUser->isAdmin($usuario);

            /*
             * Si el propietari no es el correcte
             * o no es admin, no deixa modificar i
             * redirigix al login
             */
            if ($isOwner || $isAdmin){
                //En cas de que tinga errors els formulari per a modificar, no el modifica
                if (empty($errors)) {
                    $model->update($productModified);
                }
            }else{
                header("location: " . $route->generateURL('User', 'login'));
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        require("views/modifyProduct.view.php");
    }

    public function createProduct(){
        global $route;
        session_start();

        $idUser = $_SESSION['Id'];

        if (!isset($_SESSION['rol'])) {
            header("location: " . $route->generateURL('User', 'login'));
        }

        try {
            $model = new ProductModel($this->db);
            $modelUser = new UserModel($this->db);

            $usuario = $modelUser->getUserInformation($idUser);

            /*
             * Cuan li donem a submit ens plena el producte
             * amb les dades del formulari, ho valida
             * i si no te errors l'inserta amb l'usuari que l'ha creat.
             */


            if (isset($_POST['submit'])) {
                $product = $model->fillData();
                $errors = $model->validate($product);
                if (empty($errors)) {
                    $result = $model->insert($product, $usuario);
                }else{
                    foreach ($errors as $error){
                        echo $error . "<br>";
                    }
                }
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        require("views/createProduct.view.php");
    }

    public function deleteProduct($id){
        global $route;
        session_start();

        $idUser = $_SESSION['Id'];

        if (!isset($_SESSION['rol'])) {
            header("location: " . $route->generateURL('User', 'login'));
        }

        try {
            $model = new ProductModel($this->db);
            $modelUser = new UserModel($this->db);

            $product = $model->getById($id);
            $result = "";

            $usuario = $modelUser->getUserInformation($idUser);

            $errors = $model->validate($product);
            $isOwner = $model->verifyProductOwner($product, $usuario);
            $isAdmin = $modelUser->isAdmin($usuario);

            if ($isOwner || $isAdmin){
                if (empty($errors)) {
                    $result = $model->delete($product);
                }
            }else{
                header("location: " . $route->generateURL('User', 'login'));
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        require("views/deleteProduct.view.php");
    }

    public function editProductsUser(){
        global $route;
        session_start();

        $id = $_SESSION['Id'];

        /*
         * Si l'usuari es anonim el redirigix al login
         */
        if (!isset($_SESSION['rol'])) {
            header("location: " . $route->generateURL('User', 'login'));
        }

        $modelUser = new UserModel($this->db);

        /*
         * Agarrem els parametres del filtre per el metode GET
         */
        $categoria = "";
        $fechaMin = "";
        $fechaMax = "";
        $textFilter = "";
        $categoria = filter_input(INPUT_GET, "categoria", FILTER_SANITIZE_NUMBER_INT);
        $fechaMin = filter_input(INPUT_GET, "fechaMin", FILTER_SANITIZE_STRING);
        $fechaMax = filter_input(INPUT_GET, "fechaMax", FILTER_SANITIZE_STRING);
        $textFilter = filter_input(INPUT_GET, "textFilter", FILTER_SANITIZE_STRING);


        $userInformation = $modelUser->getUserInformation($id); //Agarra les dades de l'usuari

        try {
            $modelProduct = new ProductModel($this->db);

            $limit = 4;
            $pagePagination = isset($_GET['pages']) ? $_GET['pages'] : 1; //Agarra el numero de la pagina, en cas de que no hi haja, pagina sera 1
            $start = ($pagePagination - 1) * $limit;

            /*
             * Torna els productes dels que l'usuari siga propietari
             */
            $productsUser = $modelProduct->getProductsByUserFiltered($start, $limit, $userInformation, $categoria, $fechaMin, $fechaMax, $textFilter);

            /*
             * Conta el numero de productes que te, per a fer la paginacio
             */
            $total = $modelProduct->countProductsByUserFiltered($userInformation, $categoria, $fechaMin, $fechaMax, $textFilter);

            /*
             * Trau el total de pagines que ha de fer a partir
             * del total de productes i el llimit que li hem passat
             */
            $pages = ceil($total / $limit);


            $previous = $pagePagination - 1;
            $next = $pagePagination + 1;

            if (!empty($categoria)){
                $categoria = "&categoria=".$categoria;
            } else {
                $categoria = "";
            }

            if (!empty($fechaMin)){
                $fechaMin = "&fechaMin=".$fechaMin;
            } else {
                $fechaMin = "";
            }

            if (!empty($fechaMax)){
                $fechaMax = "&fechaMax=".$fechaMax;
            } else {
                $fechaMax = "";
            }

            if (!empty($textFilter)){
                $textFilter = "&textFilter=".$textFilter;
            } else {
                $textFilter = "";
            }

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage();
        }

        require("views/editProductsUser.view.php");
    }

    public function getAdminProducts(){
        global $route;
        session_start();

        $nombre = $_SESSION['nombre'];

        if (!isset($_SESSION['rol'])) {
            header("location: " . $route->generateURL('User', 'login'));
        } else {
            if ($_SESSION['rol'] != 2) {
                header("location: " . $route->generateURL('User', 'login'));
            }
        }

        try {
            /*
             * Funciona de la mateixa manera que per a l'usuari, en aquest
             * cas mostra tots els productes de la tenda, no sols per usuari
             */
            $model = new ProductModel($this->db);


            $categoria = "";
            $fechaMin = "";
            $fechaMax = "";
            $textFilter = "";
            $categoria = filter_input(INPUT_GET, "categoria", FILTER_SANITIZE_NUMBER_INT);
            $fechaMin = filter_input(INPUT_GET, "fechaMin", FILTER_SANITIZE_STRING);
            $fechaMax = filter_input(INPUT_GET, "fechaMax", FILTER_SANITIZE_STRING);
            $textFilter = filter_input(INPUT_GET, "textFilter", FILTER_SANITIZE_STRING);


            $limit = 12;
            $pagePagination = isset($_GET['pages']) ? $_GET['pages'] : 1; //Agarra el numero de la pagina, en cas de que no hi haja, pagina sera 1
            $start = ($pagePagination - 1) * $limit;

            $productsAdmin = $model->getProductsFiltered($start, $limit, $categoria, $fechaMin, $fechaMax, $textFilter);

            $total = $model->countProductsFiltered($categoria, $fechaMin, $fechaMax, $textFilter);


            $pages = ceil($total / $limit);

            $previous = $pagePagination - 1;
            $next = $pagePagination + 1;


            if (!empty($categoria)){
                $categoria = "&categoria=".$categoria;
            } else {
                $categoria = "";
            }

            if (!empty($fechaMin)){
                $fechaMin = "&fechaMin=".$fechaMin;
            } else {
                $fechaMin = "";
            }

            if (!empty($fechaMax)){
                $fechaMax = "&fechaMax=".$fechaMax;
            } else {
                $fechaMax = "";
            }

            if (!empty($textFilter)){
                $textFilter = "&textFilter=".$textFilter;
            } else {
                $textFilter = "";
            }

        } Catch (PDOException $e) {
            // Mostrem un missatge genèric d'error.
            echo "Error: executant consulta SQL." . $e->getMessage() . $e->getLine();
        }

        require("views/adminProducts.view.php");
    }

}