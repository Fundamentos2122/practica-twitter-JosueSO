<?php 

include("../models/DB.php");
include("../models/Tweet.php");

try {
    $connection = DBConnection::getConnection();
}
catch(PDOException $e) {
    error_log("Error de conexión - " . $e, 0);

    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (array_key_exists("id", $_GET)) {
        //Obtener un solo registro
        try {
            $id = $_GET["id"];

            $query = $connection->prepare('SELECT * FROM tweets WHERE id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
    
            $tweet;
    
            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $tweet = new Tweet($row['id'], $row['text'], $row['timestamp'], $row['active']);
            }
    
            echo json_encode($tweet->getArray());
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
    else {
        //Obtener TODOS los registros
        try {
            $query = $connection->prepare('SELECT * FROM tweets');
            $query->execute();
    
            $tweets = array();
    
            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $tweet = new Tweet($row['id'], $row['text'], $row['timestamp'], $row['active']);
    
                $tweets[] = $tweet->getArray();
            }
    
            echo json_encode($tweets);
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
}
else if ($_SERVER["REQUEST_METHOD"] === "POST") {
    var_dump($_POST);
    
    $data = file_get_contents("php://input");
    var_dump($data);

    exit();

    $text = $_POST["text"];
    $timestamp = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);

    try {
        $query = $connection->prepare('INSERT INTO tweets VALUES(NULL, :text, :timestamp, 1)');
        $query->bindParam(':text', $text, PDO::PARAM_STR);
        $query->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);
        $query->execute();

        if($query->rowCount() === 0) {
            echo "Error en la inserción";
        }
        else {
            header('Location: http://localhost/twitter/views/');
        }
    }
    catch(PDOException $e) {
        echo $e;
    }
}

?>