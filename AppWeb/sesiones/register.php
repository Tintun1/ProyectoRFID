<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" type="text/css" href="../estilo.css">
    <style>
        .login-link{
        display: inline-block;
        padding: 7px 20px;
        background-color: #48e;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
        }
        .login-link:hover{
        background-color: #0056b3;
        }
        .admin-panel{
            text-align: right;
            padding: 10px 20px;
        }
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
        <h1>Registro</h1>
        <input type="text" name="name" placeholder="Nombre de Usuario">
        <input type="password" name="password" placeholder="Contraseña">
        <input type="email" name="email" placeholder="Correo electronico">
        <input type="submit" name="register">
    </form>
    <form>
    <h2>Eres papu?</h2>
        <a href="login.php" class="login-link">Login</a>
    </form>
    <?php
    include("registerDB.php");
    ?>
</body>
</html>
