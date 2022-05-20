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
        <img src="https://picsum.photos/500" alt="" class="img-fluid">
    </div>
    <div>
        <h1>TWITTER</h1>
    </div>
    <div>
        <a href="../index.html" class="close-session">Cerrar sesión</a>
    </div>
</div>