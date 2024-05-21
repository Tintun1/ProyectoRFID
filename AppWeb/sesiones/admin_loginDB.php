<?php
    include("../con_db.php");
    if (isset($_POST["login"])) {
        if (strlen($_POST["name"]) >= 1 && strlen($_POST["pass"]) >= 1 ) {
            $name = trim($_POST["name"]);
            $pass = trim($_POST["pass"]);
            // $consulta = "SELECT `nombre`, `pass` FROM `datos` WHERE 1";
            $sql = "SELECT * FROM admin WHERE nombre='$name' AND pass='$pass'";
            $resultado = mysqli_query($conex,$sql);
            if ($resultado->num_rows > 0) {
                // Usuario autenticado
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['nombre'] = $name;
                header("Location: ../proyectoNFC.php"); // Redirigir al panel de control
            } else {
                // Usuario no autenticado
                ?>
                <h3 class="bad">Ups a ocurrido un error!</h3>
                <?php
            }
            } else {
            ?>
                <h3 class="bad">Porfavor complete los campos!</h3>
                <?php
            }
        }
?>