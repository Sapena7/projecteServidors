<?php

namespace App\Model;
use App\Entity\User;
use PDO;



class UserModel
{
    private $pdo;
    protected $tableName = 'Usuarios';
    protected $className = 'App\Entity\User';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * Comprava a partir d'un usuari, si es administrador o no
     *
     * @param User $user
     * @return bool
     */
    public function isAdmin(User $user):bool{

        $id = $user->getId();
        $stmt = $this->pdo->prepare("SELECT Rol FROM Usuarios WHERE Id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_NUM);
       if ($row[0] == 2){
           $isAdmin = true;
       }else{
           $isAdmin = false;
       }

       return $isAdmin;
    }


    /**
     * Funcio per a fer login, li pasem l'usuari i fa les comprovacions
     *
     * @param User $user
     */
    public function login(User $user)
    {
        try {
            /*
             Id
             Nombre
             Contrasena
             Rol
             */

            if (isset($_POST['email']) && isset($_POST['contrasena'])) {
                //$usuario = $_POST['usuario'];
                //$contrasena = $_POST['contrasena'];

                $email = $user->getEmail();
                $contrasena = $user->getContrasena();

                $stmt = $this->pdo->prepare("SELECT * FROM Usuarios WHERE Email='$email' AND Contrasena='$contrasena'");

                $stmt->execute();


                //PREPARE I BIND PARAM!!!!!!!

                $row = $stmt->fetch(PDO::FETCH_NUM);
                if ($row == true) {

                    //validar usuario
                    $rol = $row['5'];
                    $nombre = $row['2'];
                    $img = $row['4'];
                    $id = $row['0'];
                    //print_r($rol);
                    $_SESSION['Id'] = $id;
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['img'] = $img;
                    $_SESSION['rol'] = $rol;

                    $user->setRol(intval($rol));

                    $this->redirectRol($user);

                } else {
                    echo "El nombre o la contraseña no son correctos";
                }
            }


        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function register(User $user){
        global $route;
        try {
            /*
             Id
             Nombre
             Contrasena
             Rol
             */

            $email = $user->getEmail();
            $contrasena = $user->getContrasena();
            $contrasena2 = trim(filter_input(INPUT_POST, 'contrasena2', FILTER_SANITIZE_STRING));
            $nombre = $user->getNombre();
            $apellidos = $user->getApellidos();
            $provincia = $user->getProvincia();


            if (isset($email) && isset($contrasena) && isset($contrasena2) && isset($nombre) && isset($apellidos) && isset($provincia)) {

                if (!$this->mailExists($email)) {
                    if ($contrasena == $contrasena2) {


                        $stmt = $this->pdo->prepare("INSERT INTO Usuarios (Email, Nombre, Apellidos, Provincia, Contrasena) values (:email, :nombre, :apellidos, :provincia, :contrasena)");

                        $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
                        $stmt->bindValue(':nombre', $user->getNombre(), PDO::PARAM_STR);
                        $stmt->bindValue(':apellidos', $user->getApellidos(), PDO::PARAM_STR);
                        $stmt->bindValue(':provincia', $user->getProvincia(), PDO::PARAM_STR);
                        $stmt->bindValue(':contrasena', $user->getContrasena(), PDO::PARAM_STR);

                        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

                        $stmt->execute();

                        session_start();

                        $_SESSION['rol'] = 1;

                        $stmt = $this->pdo->prepare("SELECT * FROM Usuarios WHERE Email='$email' AND Contrasena='$contrasena'");

                        $stmt->execute();

                        $row = $stmt->fetch(PDO::FETCH_NUM);
                        if ($row == true) {
                            $id = $row['0'];
                            $nom = $row['2'];
                            $_SESSION['Id'] = $id;
                            $_SESSION['nombre'] = $nom;
                        }



                        header("location: " . $route->generateURL('User', 'profile'));
                    }else{
                        echo "Las contraseñas no coinciden";
                    }
                }else{
                    echo "El email ya existe";
                }
            }






        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function mailExists($email){
        $stmt = $this->pdo->prepare("SELECT * FROM Usuarios WHERE Email='$email'");

        $stmt->execute();

        $result = $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($result > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Redirigix l'usuari a la pagina del seu perfil en el cas de l'usuari,
     * o al dashboard en el cas de l'administrador, aço es gasta, per exemple,
     * despres de fer login
     *
     * @param User $user
     */
    public function redirectRol(User $user)
    {
        global $route;

        //if (isset($_SESSION['rol'])){
        // switch ($_SESSION['rol']){

        switch ($user->getRol()) {

            case 1:
                header("location: " . $route->generateURL('User', 'profile'));
                break;

            case 2:
                header("location: " . $route->generateURL('User', 'dashboard'));
                break;

            default:

        }
    }


    /**
     * Plena l'usuari, en aquest cas, email i contrasena a traves del post del login
     *
     * @return User
     */
    public function fillData(): User
    {

        $user = new User();

        /*
         * Valide que s'agarra el que toca dels inputs
         */


        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
        $contrasena = trim(filter_input(INPUT_POST, 'contrasena', FILTER_SANITIZE_STRING));

        /*
        Email
        Nombre
        Contrasena
        Img
        Rol
        */


        $user->setEmail($email);
        $user->setContrasena($contrasena);

        return $user;
    }

    public function fillDataRegister(): User
    {

        $user = new User();

        /*
         * Valide que s'agarra el que toca dels inputs
         */


        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
        $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
        $contrasena = trim(filter_input(INPUT_POST, 'contrasena', FILTER_SANITIZE_STRING));
        $contrasena2 = trim(filter_input(INPUT_POST, 'contrasena2', FILTER_SANITIZE_STRING));
        $apellidos = trim(filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING));
        $provincia = trim(filter_input(INPUT_POST, 'provincia', FILTER_SANITIZE_STRING));

        $user->setEmail($email);
        $user->setContrasena($contrasena);
        $user->setApellidos($apellidos);
        $user->setNombre($nombre);
        $user->setProvincia($provincia);

        return $user;
    }

    /**
     * Plena l'usuari, en aquest cas per a modificar l'usuari
     *
     * @return User
     */
    public function fillDataModify(): User
    {

        $user = new User();

        /*
         * Valide que s'agarra el que toca dels inputs
         */


        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
        $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
        $apellidos = trim(filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING));
        $provincia = trim(filter_input(INPUT_POST, 'provincia', FILTER_SANITIZE_STRING));

        /*
        Email
        Nombre
        Contrasena
        Img
        Rol
        */


        $user->setEmail($email);
        $user->setNombre($nombre);
        $user->setApellidos($apellidos);
        $user->setProvincia($provincia);

        return $user;
    }


    /**
     * Funcio per a pujar l'imatge a partir de l'Id
     * de l'usuari
     *
     * @param $id
     * @return string
     */
    public function uploadImatge($id): string
    {
        $statusMsg = '';

        if (isset($_POST['upload'])) {

            // File upload path
            $targetDir = "/opt/lampp/htdocs/projecteServidors/images/";
            $fileName = basename($_FILES["file"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $file_size = $_FILES['file']['size'];

            if (isset($_POST["upload"]) && !empty($_FILES["file"]["name"])) {
                // Allow certain file formats
                $allowTypes = array('jpg', 'png');
                if (in_array($fileType, $allowTypes)) {
                    //if ($file_size < 0.01) {
                        // Upload file to server
                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                            // Insert image file name into database
                            $insert = $this->pdo->prepare("UPDATE Usuarios set Img = :filename WHERE Id = :id");
                            $insert->bindParam(":filename", $fileName);
                            $insert->bindParam(":id", $id);
                            $insert->execute();
                            if ($insert) {
                                $statusMsg = "La imagen " . $fileName . " se ha subido con exito.";
                            } else {
                                $statusMsg = "La subida ha fallado..";
                            }
                        } else {
                            $statusMsg = "Hay un error en la subida de la imagen.";
                        }
                        /*
                    } else {
                        $statusMsg = 'La imagen no puede pesar mas de 10KB.';
                    }
                        */
                } else {
                    $statusMsg = 'Solo se admite JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
                }
            } else {
                $statusMsg = 'Por favor selecciona una imagen.';
            }

        }
        return $statusMsg;
    }




    /**
     * Rep un objecte Post i comprova que les propietats siguen vàlides.
     * Comprova que siga, string, int, etc.
     *
     * @param User $user
     * @return array
     */
    public function validate(User $user):array {
        $errors = [];

        if (empty($user->getNombre())) {
            $errors[] = "Nombre no pot ser buit";
        }

        if (empty($user->getEmail())) {
            $errors[] = "Email no pot ser buit";
        }

        if (empty($user->getApellidos())) {
            $errors[] = "Apellidos no pot ser buit";
        }

        if (empty($user->getProvincia())) {
            $errors[] = "Provincia no pot ser buit";
        }

        return $errors;
    }


    /**
     * A partir de l'id de l'usuari plena l'usuari amb la seua
     * informacio
     *
     * @param int $id
     * @return User
     */
    public function getUserInformation(int $id):User{
        $stmt = $this->pdo->prepare('SELECT * FROM Usuarios WHERE Id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->className);
        $stmt->execute();
        $userInformation = $stmt->fetch();

        return $userInformation;
    }

    /**
     * Funcio per a canviar la contrasenya de l'usuari.
     *
     * @param User $user
     * @return bool
     */
    public function getUserPasswordAndChange(User $user): bool{
        $oldPassword = trim(filter_input(INPUT_POST, 'old_password', FILTER_SANITIZE_STRING));
        $newPassword = trim(filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING));
        $newPasswordConfirm = trim(filter_input(INPUT_POST, 'new_password_confirm', FILTER_SANITIZE_STRING));
        $id = $user->getId();

        $stmt = $this->pdo->prepare("SELECT Contrasena from Usuarios where Id=:id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        $passwordUser = $stmt->fetch();
        $passwordUser = $passwordUser["Contrasena"];

        if (($passwordUser == $oldPassword) && ($newPassword == $newPasswordConfirm)) {
                $stmt = null;
                $stmt = $this->pdo->prepare('UPDATE Usuarios SET Contrasena = :contrasena WHERE id = :id');
                $stmt->bindParam(":contrasena", $newPassword, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
        }
            return $stmt->rowCount();
        }

    /**
     * Funcio per a modificar les dades de l'usuari
     *
     * @param User $user
     * @return bool
     */
    public function updateUser(User $user):bool {

        $id = $user->getId();

        $nombre = $user->getNombre();
        $apellidos = $user->getApellidos();
        $provincia = $user->getProvincia();
        $email = $user->getEmail();

        $stmt = $this->pdo->prepare("UPDATE Usuarios set Nombre = :nombre, Apellidos = :apellidos, Provincia = :provincia, Email = :email WHERE Id = :id");

        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre',$nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos',$apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':provincia',$provincia, PDO::PARAM_STR);
        $stmt->bindParam(':email',$email, PDO::PARAM_STR);


        $stmt->execute();

        //Si es major que 0 vol dir que si que s'ha fet l'update
        return $stmt->rowCount()>0;
    }
}
