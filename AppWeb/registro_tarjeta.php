<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Tarjeta</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<style>
    table {
        font-size: 18px;
        font-weight: bolder;
    }
    th,td,tr {
        border: 2px solid black;
        text-align: center;
    }
    th {
        font-size: 22px;
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
<?php
    include("con_db.php");
    $sql = "SELECT * FROM tarjetas_no_registradas;";
    $resultado = mysqli_query($conex, $sql);
    $sql2 = "SELECT * FROM uid_status;";
    $resultado2 = mysqli_query($conex, $sql2);
?>
<body>
    <div class="container">
        <h1>Registro de Tarjetas</h1>
        <table>
            <h2>Tarjetas entrantes</h2>
            <tr>
                <th>UID</th>
                <th>Estado</th>
            </tr>
            <?php
                while($mostrar = mysqli_fetch_array($resultado)) {
                    echo "<tr><td>$mostrar[codigo_uid]</td>";
                }
                while($mostrar2 = mysqli_fetch_array($resultado2)) {
                    if($mostrar2["status"] == "0") {
                        $mostrar2["status"] = "-";
                    } else {
                        $mostrar2["status"] = "Leyendo";
                    }
                    echo '<td>'.$mostrar2["status"].'</td></tr>';
                }
            ?>
        </table>
        <form action="" method="post" id="UID" enctype="multipart/form-data">
            <input type="submit" name="leer" value="leer nueva tarjeta">
            <input type="text" name="UID" placeholder="UID">
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="file" name="imagen">
            <input type="submit" name="registrar" value="registrar">
        </form>
        <a href="proyectoNFC.php" class="perfil-link">Volver</a>
        <?php include("registro_tarjetaDB.php") ?>
    </div>
</body>
</html>