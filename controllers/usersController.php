<?php 

include("../models/DB.php");

try {
    $connection = DBConnection::getConnection();
}
catch(PDOException $e) {
    error_log("Error de conexión - " . $e, 0);

    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Obtener información del POST
    $username = $_POST["username"];
    $password = $_POST["password"];
    $photo = $_POST["photo"];
    $type = $_POST["type"];

    try {
        $query = $connection->prepare('INSERT INTO users VALUES(NULL, :username, :password, :photo, :type)');
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':photo', $photo, PDO::PARAM_STR);
        $query->bindParam(':type', $type, PDO::PARAM_STR);
        $query->execute();

        if($query->rowCount() === 0) {
            echo "Error en la inserción";
        }
        else {
            if ($redirect) {
                header('Location: http://localhost/twitter/');
            }
            else {
                echo "Registro guardado";
            }
        }
    }
    catch(PDOException $e) {
        echo $e;
    }
}

?>