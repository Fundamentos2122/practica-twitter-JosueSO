<?php 

include("../models/DB.php");
include("../models/Tweet.php");

try {
    $connection = DBConnection::getConnection();

    var_dump($connection);
}
catch(PDOException $e) {
    error_log("Error de conexión - " . $e, 0);

    exit();
}

?>