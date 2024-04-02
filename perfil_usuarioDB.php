<?php
include("con_db.php");
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit;
}

$username = $_SESSION['username'];

// Consulta para obtener la fecha de registro del usuario
$sql = "SELECT fecha_registro FROM datos WHERE nombre=?";
$stmt = mysqli_prepare($conex, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if ($resultado->num_rows > 0) {
    $row = mysqli_fetch_assoc($resultado);
    // Guardar la fecha de registro en la sesión
    $_SESSION['fecha_registro'] = $row['fecha_registro'];
} else {
    // Manejar el caso en que no se encuentre la fecha de registro
    $_SESSION['fecha_registro'] = "La fecha de registro no está disponible.";
}

// Obtener la ruta de la imagen de perfil del usuario
$username = $_SESSION['username'];
$sql = "SELECT profile_pic FROM datos WHERE nombre=?";
$stmt = mysqli_prepare($conex, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
if ($resultado->num_rows > 0) {
    $row = mysqli_fetch_assoc($resultado);
    $ruta_imagen = $row['profile_pic'];
    if($ruta_imagen == ""){
        $ruta_imagen = "profile_pic_default.jpeg";
    }
} else {
    $ruta_imagen = "profile_pic_default.jpeg";
}
    //subida de imagen
?>
