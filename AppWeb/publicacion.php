<?php
include("con_db.php");
session_start();
// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: inicio.php"); // Redirigir al inicio de sesión si no está autenticado
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicacion</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
    <div class="container">
        <h1>Que vas a publicar?</h1>
    </div>
    <form method="post" enctype="multipart/form-data">
            <input type="text" name="titulo" placeholder="Titulo">
            <input type="text" name="descripcion" placeholder="descripcion">
            <input type="file" name="imagen">
            <button type="submit" name="publicar">Publicar</button>
    </form>
    <?php include("publicacionDB.php") ?>
</body>
</html>