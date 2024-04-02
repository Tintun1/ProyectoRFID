<?php
    include("con_db.php");
?>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Puerta con NFC</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<style>
    body {
        background-image: url(img/background_img.jpg);
        background-size: cover;
        }
</style>
<body>
    <div class="container">
        <h1>Control de Puerta con NFC</h1>
        <h2>Registro de Accesos</h2>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>HEX</th>
                    <th>Fecha/Hora</th>
                    <th>Dato</th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <?php
                    $sql = "SELECT nombre,hex,fecha_reg,dato FROM prueba";
                    $resultado = mysqli_query($conex,$sql);
                    if ($resultado->num_rows > 0) {
                        // Mostrar datos en la tabla
                        while($row = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["nombre"] . "</td>";
                            echo "<td>" . $row["hex"] . "</td>";
                            echo "<td>" . $row["fecha_reg"] . "</td>";
                            echo "<td>" . $row["dato"] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tr>
            </thead>
            <tbody id="registroAccesos">
                <!-- Aquí se mostrarán los registros de accesos -->
            </tbody>
        </table>
        <button onclick="cerrarPuerta()">Cerrado manual</button>
    </div>

    <!-- JavaScript para la funcionalidad de cerrar la puerta -->
    <script>
        function cerrarPuerta() {
            // Aquí puedes enviar una solicitud al ESP32 para cerrar la puerta
            // Puedes utilizar AJAX para esto
            alert('Puerta cerrada');
        }
    </script>

</body></html>