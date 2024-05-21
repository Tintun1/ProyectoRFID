<?php
include("con_db.php");

// Número máximo de publicaciones por página
$publicacionesPorPagina = 10;

// Obtener el número de página actual
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular el desplazamiento para la consulta SQL
$offset = ($paginaActual - 1) * $publicacionesPorPagina;

// Consulta SQL para seleccionar datos de la tabla "publicaciones" ordenados por ID en orden descendente con limit y offset
$sql = "SELECT titulo, usuario, foto, descripcion, fecha, profile_pic FROM publicaciones ORDER BY id DESC LIMIT $offset, $publicacionesPorPagina";
$resultado = mysqli_query($conex, $sql);

// Verificar si la consulta tuvo éxito
if ($resultado) {
    // Verificar si se encontraron filas
    if (mysqli_num_rows($resultado) > 0) {
        // Mostrar datos en la tabla
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<div class='container'>";
            echo "<div class='container'>
            <img id='monoico' src='uploads/".$row["profile_pic"]."' alt='profile pic' class='post-pic'>
            <h3>". $row["usuario"] ."</h3></div>";
            echo "<h2>" . $row["titulo"] . "</h2>";
            echo "<h3>" . $row["descripcion"] . "</h3>";
            if ($row["foto"] == ""){
            $n = "nulo";
            } else {
                if (pathinfo($row["foto"], PATHINFO_EXTENSION) === 'mp4') {
                    echo "<video id='monoico' controls>"; // Agregar atributo controls para permitir la reproducción y el control del video
                    echo "<source src='uploads/".$row["foto"]."' type='video/mp4' class='img-post'>"; // Especificar la fuente del video
                    echo "</video>";
                } else {
                    // Si no es un video, mostrar como imagen
                    echo "<img id='monoico' src='uploads/".$row["foto"]."' alt='profile pic' class='img-post'>";
                }
            }
            echo "<h3>" . $row["fecha"] . "</h3>";
            echo "</div>"; // Cerrar container
        }
    } else {
        echo "No se encontraron publicaciones.";
    }

    // Calcular el número total de páginas
    $totalPublicaciones = mysqli_num_rows(mysqli_query($conex, "SELECT * FROM publicaciones"));
    $totalPaginas = ceil($totalPublicaciones / $publicacionesPorPagina);

    // Mostrar botones de paginación
    echo "<div class='container'>";
    for ($i = 1; $i <= $totalPaginas; $i++) {
        if ($i == $paginaActual) {
            echo "<a href='inicio.php?pagina=$i' class='active'> <b>$i</b> </a>";
        } else {
            echo "<a href='inicio.php?pagina=$i'> <b>$i</b> </a>";
        }
    }
    echo "</div>";
} else {
    echo "Error al ejecutar la consulta: " . mysqli_error($conex);
}

// Liberar el resultado
mysqli_free_result($resultado);

// Cerrar la conexión
mysqli_close($conex);
?>