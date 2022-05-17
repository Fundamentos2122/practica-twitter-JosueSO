<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/d5ef93086f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Twitter</title>
</head>
<body>
    <div>
        <?php include("layouts/header.php"); ?>
        <div class="container">
            <div>
                <form action="../controllers/tweetsController.php" method="POST" id="form-tweet" class="flow">
                    <input type="hidden" name="_method" value="POST">
                    <label for="text">Tweet:</label>
                    <textarea name="text"></textarea>
                    <input type="submit" value="Agregar">
                </form>
            </div>
            <div>
                <h2>Mis Tweets</h2>
                <div id="tweet-list">
                    <!-- <div class="card">
                        <div class="card-img">
                            <img src="https:\\picsum.photos/600" alt="">
                        </div>
                        <div class="card-text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora corporis consequuntur maiores obcaecati incidunt illo. Eveniet unde deleniti cupiditate odit ducimus nisi atque et delectus saepe, itaque dolorem tempora. Tenetur.
                        </div>
                        <button class="close">X</button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <?php 
        include("modal_tweet.php");
        include("modal_delete.php"); 
    ?>

    <script src="../assets/js/app.js"></script>
</body>
</html>