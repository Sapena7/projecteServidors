<?php

use App\Entity\Categoria;
use App\Entity\Product;
use App\Entity\User;
use App\Model\ProductModel;
use App\Model\UserModel;
use App\DBConnection;
use App\Core\Router;
use App\Core\Request;
use App\Utils\DependencyInjector;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/config/bootstrap.php';

ini_set('session.cookie_httponly', 1); //Per a que les cookies de session sols estiguen disponibles desde http
ini_set('session.gc_maxlifetime', 86400);

$page = $_GET['page'] ?? "index";

$di = new DependencyInjector();

$db = new DBConnection();
$di->set('PDO', $db->getConnection());

$request = new Request();

/* Carreguem l'entorn de Twig */
$loader=new FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader,[
    'debug' => true
]);
/*
   * Afegim una instància de Router a la plantilla.
   * La utilitzarem en les plantilles per a generar URL.
*/


$twig->addExtension(new \Twig\Extension\DebugExtension());
$twig->addGlobal('router', new Router(new DependencyInjector()));

/* l'incloem al contenidor de serveis */
$di->set('Twig', $twig);

$route = new Router($di);
echo $route->route($request);



switch ($page) {
    case "login":
        {
            break;
        };

    case "profile":
        {
            break;
        };
    case "editProfile":
        {
            break;

        };

    case "editProductsUser":
        {
            break;

        };

    case "change_password":
        {
            break;
        };

    case "product":
        {
            break;
        };

    case "dashboard":
        {
            break;
        };


    case "adminProducts":
        {

            break;
        };

    case "createProduct":
        {
            break;
        };

    case "modifyProduct":
        {
            break;
        };

    case "deleteProduct":
        {
            break;
        };

    case "index":
        {
            break;
        };
    case "categories":
        {
            break;
        };
    case "botasFutbol":
        {
            break;
        };
    case "botasFutbolSala":
        {
            break;
        };
    case "camisetasEntrenamiento":
        {
            break;
        };

    case "registro":
        {
            break;
        };

    default:
        require('views/errorPage.php');
        break;

}
