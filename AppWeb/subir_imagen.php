<?php
include("con_db.php");
// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: inicio.html"); // Redirigir al inicio de sesión si no está autenticado
    exit;
}
if (isset($_POST["subir"])) {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_tamaño = $_FILES['imagen']['size'];
        $imagen_nombre = $_FILES['imagen']['name'];
        $nombre_usuario = $_SESSION['username'];
        $imagen_ruta = "C:/xampp/htdocs/ProyectoRFID/uploads/".$imagen_nombre;

        $imagen_tipo = exif_imagetype($imagen_tmp);
        $allowed_types = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];

        if (in_array($imagen_tipo, $allowed_types)){
            if (file_exists($imagen_ruta)) {
                // Generar un nuevo nombre de archivo único
                $nombre_sin_extension = pathinfo($imagen_nombre, PATHINFO_FILENAME);
                $extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);
                $contador = 1;
                while (file_exists("uploads/" . $nombre_sin_extension . "_" . $contador . "." . $extension)) {
                    $contador++;
                }
                // Renombrar el archivo con un sufijo numérico único
                $imagen_nombre = $nombre_sin_extension . "_" . $contador . "." . $extension;
                $imagen_ruta = "uploads/" . $imagen_nombre;
            }
                // Mover la imagen al directorio de destino
                move_uploaded_file($imagen_tmp,"C:/xampp/htdocs/ProyectoRFID/uploads/$imagen_nombre");

                // Guardar la ruta de la imagen en la base de datos
                $sql = "UPDATE datos SET profile_pic=? WHERE nombre=?";
                $stmt = mysqli_prepare($conex, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $imagen_nombre, $nombre_usuario);
                mysqli_stmt_execute($stmt);
                echo "<h3 class='ok'>Subido con exito!</h3>";
                exit;
        } else {
            echo "<h3 class='bad'>No se admiten ese tipo de archivos!</h3>";
        }

    } else {
        echo "<h3 class='bad'>Error al subir la imagen.</h3>";
    }
}
?>