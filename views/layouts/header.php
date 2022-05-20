<?php 
    //Indicamos que haremos uso de la sesión
    session_start();

    if(!array_key_exists("username", $_SESSION)) {
        header('Location: http://localhost/twitter/');
        exit();
    }

?>

<div class="banner">
    <div class="" id="photo">
        <?php
            echo "<img src=\"data:image/jpeg;base64," . $_SESSION["photo"] . "\" alt=\"\" class=\"img-fluid\">";
        ?>
    </div>
    <div>
        <h1>TWITTER</h1>
    </div>
    <div>
        <form action="../controllers/accessController.php" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="submit" class="close-session" value="Cerrar sesión" >
        </form>
        
    </div>
</div>