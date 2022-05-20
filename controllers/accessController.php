<?php 

// var_dump($_POST);

include("../models/DB.php");
include("../models/User.php");

try {
    $connection = DBConnection::getConnection();
}
catch(PDOException $e) {
    error_log("Error de conexión - " . $e, 0);

    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $password = password_hash($password, PASSWORD_DEFAULT);

    echo $password;

    try {
        $query = $connection->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() === 0) {
            // header('Location: http://localhost/twitter/');
            exit();
        }

        $user;

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($row["id"], $row["username"], '', $row["photo"], $row["type"]);
        }

        session_start();

        $_SESSION["id"] = $user->getId();
        $_SESSION["username"] = $user->getUsername();
        $_SESSION["photo"] = $user->getPhoto();
        $_SESSION["type"] = $user->getType();

        header('Location: http://localhost/twitter/views/');
        exit();
    }
    catch(PDOException $e) {
        echo $e;
    }
}

?>