<?php
include("../con_db.php");

if (isset($_POST["register"])) {
    if (strlen($_POST["name"]) >= 1 && strlen($_POST["email"]) >= 1 && strlen($_POST["password"]) >= 1) {
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $fechareg = date("d/m/y"); // Utilizando el formato de fecha MySQL
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hashing de contraseña

        // Consulta preparada para evitar la inyección SQL
        $sql = "INSERT INTO datos (nombre, email, password, fecha_registro) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conex, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashed_password, $fechareg);
        $resultado = mysqli_stmt_execute($stmt);

        if ($resultado) {
            ?>
            <h3 class="ok">Te has registrado correctamente!</h3>
            <?php
        } else {
            ?>
            <h3 class="bad">Ups, ha ocurrido un error!</h3>
            <?php
        }
    } else {
        ?>
        <h3 class="bad">Por favor complete todos los campos!</h3>
        <?php
    }
}
?>
