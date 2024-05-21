<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>
    <link rel="stylesheet" type="text/css" href="../estilo.css">
</head>
<style>
    body {
        background-image: url(../img/background_img.jpg);
        background-size: cover;
        }
</style>
<body>
<form method="post">
        <h1>Admin login</h1>
        <input type="text" name="name" placeholder="Nombre de Usuario">
        <input type="text" name="pass" placeholder="Contraseña">
        <input type="submit" name="login">
    </form>
    <form>
        <h3>Te arrepientes?</h3>
        <a href="../index.html" class="register-link">inicio</a>
    </form>
    <?php
    include("admin_loginDB.php");
    ?>
<body>
</html>