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
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
        
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $type = "normal";
    $photo = "";
    
    if (sizeof($_FILES) > 0) {
        $tmp_name = $_FILES["photo"]["tmp_name"];

        $photo = file_get_contents($tmp_name);
    }

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
            header('Location: http://localhost/twitter/');
        }
    }
    catch(PDOException $e) {
        echo $e;
    }
}

?>