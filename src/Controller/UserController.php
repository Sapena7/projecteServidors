<?php
namespace App\Controller;

use App\Model\UserModel;
use App\Model\ProductModel;
use App\Entity\Product;
use App\Entity\User;

class UserController extends AbstractController
{

    public function login(){
        global $route;
        $model = new UserModel($this->db);
        $user = $model->fillData();

        /*
         * Comença la sessio una vegada recibixca el POST
         */
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            session_start();
            $_SESSION['time_start'] = time();
            header("location: " . $route->generateURL('User', 'profile'));
            $model->login($user); //Comprova l'usuari i la contrasenya i fa login

            if (isset($_GET['cerrar_sesion'])) {
                session_unset();
                session_destroy();
                set_cookie(session_name(), '0', time()-2222);
            }
        }
        require('views/login.view.php');
        return "";
    }

    public function register(){
        global $route;
        $model = new UserModel($this->db);
        $user = $model->fillDataRegister();

        /*
         * Comença la sessio una vegada recibixca el POST
         */
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            session_start();
            $_SESSION['time_start'] = time();
            header("location: " . $route->generateURL('User', 'profile'));

            $model->register($user); //Comprova l'usuari i la contrasenya i fa login

        }
        require('views/registro.view.php');
        return "";
    }

    public function dashboard(){
        global $route;
        session_start();
        $nombre = $_SESSION['nombre'];

        /*
         * Si l'usuari no te rol va al login,
         * i si en te pero no es 2 tambe.
         */
            if ($_SESSION['rol'] != "admin") {
                header("location: " . $route->generateURL('User', 'login'));
            }
        require('views/dashboard.view.php');
        return "";
    }

    public function profile(){
        global $route;
        session_start();

        /*
         * Si l'usuari es anonim el redirigix al login
         */
        if (!isset($_SESSION['rol'])) {
            header("location: " . $route->generateURL('User', 'login'));
        }

        $id = $_SESSION['Id'];
        $model = new UserModel($this->db);

        $userInformation = $model->getUserInformation($id);

        require('views/profile.view.php');
        return "";
    }

    public function editProfile(){
        global $route;
        session_start();

        /*
         * Si l'usuari es anonim el redirigix al login
         */
        if (!isset($_SESSION['rol'])) {
            header("location: " . $route->generateURL('User', 'login'));
        }

        $id = $_SESSION['Id'];

        $model = new UserModel($this->db);

        $userNotModified = $model->getUserInformation($id); //Agafa l'informacio de l'usuari a partir del id
        $userModified = $model->fillDataModify(); //Plena l'usuari
        $userModified->setId($id); //li posa el id
        $errors = $model->validate($userModified); //verifica els errors

        if (empty($errors)) {
            $model->updateUser($userModified);
            header("location: " . $route->generateURL('User', 'editProfile'));

        }

        $statusMsg = $model->uploadImatge($id); //Per a putjar l'imatge


        require("views/editProfile.view.php");
        return "";
    }

    public function change_password(){
        session_start();

        $id = $_SESSION['Id'];

        $model = new UserModel($this->db);
        $user = $model->getUserInformation($id);

        $response = "";

        $response = $model->getUserPasswordAndChange($user);

        if ($response == 1) {
            echo "Contraseña actualizada";
        } else {
            echo "Las contraseñas no coinciden / la contraseña antigua no es correcta";
        }


        require("views/change_password.view.php");
    }

    public function logout(){
        global $route;
        session_start();
        session_unset();
        session_destroy();

        header("location: " . $route->generateURL('User', 'login'));
    }
}