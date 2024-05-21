<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../estilo.css">
    <style>
        body {
        background-image: url(../img/background_img.jpg);
        background-size: cover;
        }
    </style>
</head>
<div class="admin-panel">
    <a href="admin_login.php" class="login-link" class="admin-panel">Panel Admin</a>
</div>
<body>
<form method="post">
        <h1>Login</h1>
        <input type="text" name="name" placeholder="Nombre de Usuario">
        <input type="password" name="password" placeholder="Contraseña">
        <input type="email" name="email" placeholder="Correo electronico">
        <input type="submit" name="login">
    </form>
    <form>
        <h3>No eres papu?</h3>
        <a href="register.php" class="register-link">Registrarse</a>
    </form>
    <?php
    include("./loginDB.php");
    ?>
</body>
</html>