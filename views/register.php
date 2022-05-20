<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Twitter</title>
</head>
<body class="container flex-center">
    <div class="card-login">
        <h1>Registro de usuario</h1>

        <form action="../controllers/usersController.php" method="POST" autocomplete="off" class="flow" enctype="multipart/form-data">
            <div class="group-horizontal">
                <label for="username">Nombre de usuario</label>
                <input type="text" name="username">
            </div>
            <div class="group-horizontal">
                <label for="password">Contraseña</label>
                <input type="password" name="password">
            </div>
            <div class="group-horizontal">
                <label for="photo">Foto</label>
                <input type="file" name="photo">
            </div>
            <div class="text-end">
                <input type="submit" value="ENVIAR">
            </div>
        </form>
    </div>
</body>
</html>