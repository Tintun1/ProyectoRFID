<?php
    include("perfil_usuarioDB.php");
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Perfil</title>
</head>
<body>
    <div class="close-sesion">
        <a href="cerrar_sesion.php" class="close-link" class="close-sesion">Cerrar sesion</a>
    </div>
    <div class="container">
        <?php
            echo "<h1>" . "¡Bienvenido, " . $_SESSION['username'] . "! Esta es tu página de perfil." . "</h1>";
            echo "<img id='monoico' src='uploads/".$ruta_imagen."' alt='profile pic' class='profile-pic'>";
            echo "<h2 class='profile-text'>" . $_SESSION["username"] . "</h1>";
            echo "<h2 class='profile-text'>" . "Miembro desde " . $_SESSION['fecha_registro'] . "</h2>";
        ?>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="imagen">
            <button type="submit" name="subir">Cambiar foto de perfil</button>
        </form>
    <?php
        include("subir_imagen.php");
    ?>
    </div>
</body>
</html>