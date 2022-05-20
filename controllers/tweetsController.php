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
        session_start();

        $user_id = $_SESSION["id"];

        try {
            $query = $connection->prepare('SELECT * FROM tweets WHERE active = 1 AND user_id = :user_id');
            $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
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
    if (array_key_exists("text", $_POST)) {
        //Utilizar el arreglo $_POST
        if ($_POST["_method"] === "POST") {
            //Registro nuevo
            postTweet($_POST["text"], true);
        }
        else if ($_POST["_method"] === "PUT") {
            putTweet($_POST["id"], $_POST["text"], true);
        }
    }
    else if (array_key_exists("id", $_POST)) {
        if ($_POST["_method"] === "DELETE") {
            deleteTweet($_POST["id"], true);
        }
    }
    else {
        //Utilizar file_get_contents
        $data = json_decode(file_get_contents("php://input"));

        if ($data->_method === "POST") {
            postTweet($data->text, false);
        }
        else if($data->_method === "PUT") {
            putTweet($data->id, $data->text, false);
        }
    }

    exit();
}

function postTweet($text, $redirect) {
    global $connection;

    $timestamp = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);

    session_start();

    $user_id = $_SESSION["id"];

    try {
        $query = $connection->prepare('INSERT INTO tweets VALUES(NULL, :text, :timestamp, 1, :user_id)');
        $query->bindParam(':text', $text, PDO::PARAM_STR);
        $query->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();

        if($query->rowCount() === 0) {
            echo "Error en la inserción";
        }
        else {
            if ($redirect) {
                header('Location: http://localhost/twitter/views/');
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

function putTweet($id, $text, $redirect) {
    global $connection;

    try {
        $query = $connection->prepare('UPDATE tweets SET text = :text WHERE id = :id');
        $query->bindParam(':text', $text, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        if($query->rowCount() === 0) {
            echo "Error en la actualización";
        }
        else {
            if ($redirect) {
                header('Location: http://localhost/twitter/views/');
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

function deleteTweet($id, $redirect) {
    global $connection;

    try {
        $query = $connection->prepare('UPDATE tweets SET active = 0 WHERE id = :id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        if($query->rowCount() === 0) {
            echo "Error en la eliminación";
        }
        else {
            if ($redirect) {
                header('Location: http://localhost/twitter/views/');
            }
            else {
                echo "Registro eliminado";
            }
        }
    }
    catch(PDOException $e) {
        echo $e;
    }
}

?>