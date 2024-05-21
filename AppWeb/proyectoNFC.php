<?php
    include("con_db.php");

    // Variables para la paginación
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual
    $records_per_page = 10; // Registros por página

    // Consulta SQL para obtener los registros de la tabla historial
    $start_from = ($page - 1) * $records_per_page; // Índice de inicio para la consulta LIMIT
    $sql = "SELECT nombre,UID,fecha_registro,dato,verificado FROM historial ORDER BY fecha_registro DESC LIMIT $start_from, $records_per_page";
    $resultado = mysqli_query($conex, $sql);
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
    .tabla {
        border-radius: 20px;
        margin: 10px;
        padding: 5px 10px 20px 10px;
    }
    .historial {
        max-width: 80%;
        margin-top: 20px;
        margin-bottom: 15px;
        margin-left: auto;
        margin-right: auto;
        padding: 20px;
        background-color: rgba(141, 140, 140, 0.5);
        border-radius: 15px;
    }
    .verificado{
        background-color: #00bb2f;
    }
    .no-verificado{
        background-color: #e10000;
    }
    table {
        font-weight: bolder;
    }
    th,td,tr {
        border: 2px solid black;
        text-align: center;
    }
    th {
        font-size: 22px;
    }
    .pagination {
        margin-top: 20px;
        text-align: center;
    }
    .pagination a {
        color: black;
        padding: 8px 16px;
        text-decoration: none;
        border: 1px solid #ddd;
        margin: 0 4px;
    }
    .pagination a.active {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }
    .registro-tarjetas-link{
    text-align: center;
    padding: 10px 20px;
    display: inline-block;
    padding: 7px 20px;
    background-color: #48e;
    color: #000000;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}
.uid-pic{
    border-radius: 50%;
    max-width: 15%;
    height: auto;
    width: 350px;
}
@media screen and (max-width: 768px) {
        .historial {
            max-width: 90%;
        }
        h1 {
            font-size: 22px;
        }
        h2 {
            font-size: 18px;
        }
        table {
            font-size: 10px;
        }
        th {
        font-size: 12px;
        }
        .uid-pic {
            max-width: 100%;
            height: auto;
        }
    }
    @media screen and (max-width: 576px) {
        .historial {
            padding: 10px;
        }
    }
</style>
<body>
    <div class="historial">
        <h1>Control de Puerta con NFC</h1>
        <h2>Registro de Accesos</h2>
        <div class="tabla">
            <table>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>HEX</th>
                        <th>Fecha/Hora</th>
                        <th>Dato</th>
                        <th>Verificado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (mysqli_num_rows($resultado) > 0) {
                            // Mostrar datos en la tabla
                            while($row = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td>" . $row["nombre"] . "</td>";
                                echo "<td>" . $row["UID"] . "</td>";
                                echo "<td>" . $row["fecha_registro"] . "</td>";
                                if ($row["dato"] == "-") {
                                    echo "<td>" . $row["dato"] . "</td>";
                                } else {
                                    echo "<td><img id='monoico' src='uploads/".$row["dato"]."' alt='profile pic' class='uid-pic'></td>";
                                }
                                if ($row["verificado"] == "verificado") {
                                    echo "<td class='verificado'>" . $row["verificado"] . "</td>";
                                } else {
                                    echo "<td class='no-verificado'>" . $row["verificado"] . "</td>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No se encontraron registros.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
            <!-- Botones de paginación -->
            <div class="pagination">
                <?php
                    $sql = "SELECT COUNT(*) AS total_records FROM historial";
                    $resultado = mysqli_query($conex, $sql);
                    $row = mysqli_fetch_assoc($resultado);
                    $total_records = $row['total_records'];
                    $total_pages = ceil($total_records / $records_per_page);
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<a href='?page=$i'";
                        if ($i == $page) echo " class='active'";
                        echo ">" . $i . "</a> ";
                    }
                ?>
            </div>
        </div>
        <a href="registro_tarjeta.php" class="registro-tarjetas-link">Registrar nueva tarjeta</a>
    </div>
</body></html>
