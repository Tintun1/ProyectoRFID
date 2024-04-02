<?php
session_start();
include("../con_db.php");

if (isset($_POST["login"])) {
    if (strlen($_POST["name"]) >= 1 && strlen($_POST["email"]) >= 1 ) {
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);

        // Consulta preparada para evitar la inyección SQL
        $sql = "SELECT * FROM datos WHERE nombre=? AND email=?";
        $stmt = mysqli_prepare($conex, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $name, $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($resultado->num_rows > 0) {
            $row = mysqli_fetch_assoc($resultado);
            // Verificar la contraseña utilizando password_verify
            if (password_verify($_POST['password'], $row['password'])) {
                // Usuario autenticado
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['fecha_registro'] = $row["fecha_registro"];
                // Regenerar el ID de sesión para mayor seguridad
                session_regenerate_id(true);
                header("Location: ../inicio.html"); // Redirigir al panel de control
                exit;
            } else {
                // Contraseña incorrecta
                echo "<h3 class='bad'>Contraseña incorrecta!</h3>";
            }
        } else {
            // Usuario no encontrado
            echo "<h3 class='bad'>Usuario no encontrado!</h3>";
        }
    } else {
        // Campos incompletos
        echo "<h3 class='bad'>Por favor complete todos los campos!</h3>";
    }
}
?>