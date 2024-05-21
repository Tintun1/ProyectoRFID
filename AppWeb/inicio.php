<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <?php 
        session_start();
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) { 
            header("Location: inicio.php"); // Redirigir al inicio de sesión si no está autenticado
            exit; } ?>
</head>
<body>
    <div class="close-sesion">
        <a href="publicacion.php" class="perfil-link">Hacer publicacion</a>
        <a href="perfil_usuario.php" class="perfil-link">Perfil</a>
    </div>
    <form>
        <h1>Bienvenido a monitos access</h1>
        <h2>Que paso hoy?</h2>
    </form>
    <div class="container">
        <?php
            include("inicioDB.php");
        ?>
    </div>
</html>