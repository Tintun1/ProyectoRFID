<?php

include("con_db.php");
if(isset($_POST['registrar'])){
    if(strlen($_POST['UID']) >= 1 && strlen($_POST['nombre']) >= 1){
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen_tmp = $_FILES['imagen']['tmp_name'];
            $imagen_tamaño = $_FILES['imagen']['size'];
            $imagen_nombre = $_FILES['imagen']['name'];
            $imagen_ruta = "C:/xampp/htdocs/ProyectoRFID/uploads/".$imagen_nombre;

            $imagen_tipo = exif_imagetype($imagen_tmp);
            $allowed_types = [ IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF,IMAGETYPE_BMP, IMAGETYPE_WEBP];
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']; // Extensiones de imágenes permitidas
            $allowed_video_types = ['video/mp4', 'video/webm', 'video/ogg',];
            $allowed_video_extensions = ['mp4', 'webm', 'ogg', 'mp3']; // Extensiones de video permitidas
            // Obtener la extensión del archivo
            $extension_archivo = strtolower(pathinfo($imagen_nombre, PATHINFO_EXTENSION));
            // Obtener el tipo MIME del archivo
            $mime_type = mime_content_type($imagen_tmp);
            if ((in_array($imagen_tipo, $allowed_types) && in_array($extension_archivo, $allowed_extensions)) ||
                (in_array($mime_type, $allowed_video_types) && in_array($extension_archivo, $allowed_video_extensions))) {

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
            } else {
                echo "<h3 class='bad'>Error en el formato de la imagen!</h3>";
            }
        } else {
            $imagen_nombre = "";
        }
        $nombre = $_POST['nombre'];
        $UID = $_POST['UID'];
        $dato = $imagen_nombre;
        $sql_insertar = "INSERT INTO tarjetas_registradas (nombre, UID, dato) VALUES (?, ?, ?)";
		$stmt_insertar = mysqli_prepare($conex, $sql_insertar);
		mysqli_stmt_bind_param($stmt_insertar, "sss", $nombre, $UID, $dato);
		$resultado_insertar = mysqli_stmt_execute($stmt_insertar);
        if ($resultado_insertar) {
            echo "<h3 class='ok'>Publicación exitosa!</h3>";
        } else {
            echo "<h3 class='bad'>Error al insertar en la base de datos!</h3>";
        }
    } else {
        echo "<h3 class='bad'>Por favor rellena todos los campos.</h3>";}
}

if (isset($_POST['leer'])) {
	$sql = "SELECT * FROM uid_status;";
	$result   = mysqli_query($conex, $sql);
    $sql2 = "UPDATE tarjetas_no_registradas SET codigo_uid = '-' WHERE id = 1;";
	$result2 = mysqli_query($conex, $sql2);
	$row  = mysqli_fetch_assoc($result);
	if($row['status'] == 0){
		$update = mysqli_query($conex, "UPDATE uid_status SET status = 1 WHERE id = 1;");
        header("Location: registro_tarjeta.php");
	}
    
}

?>