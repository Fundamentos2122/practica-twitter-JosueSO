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
    try {
        $query = $connection->prepare('SELECT * FROM tweets');
        $query->execute();

        $tweets = array();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $tweet = new Tweet($row['id'], $row['text'], $row['timestamp'], $row['active']);

            $tweets[] = $tweet;
        }

        var_dump($tweets);
    }
    catch(PDOException $e) {
        echo $e;
    }
}
else if ($_SERVER["REQUEST_METHOD"] === "POST") {
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