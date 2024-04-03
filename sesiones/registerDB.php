<?php
include("../con_db.php");

if (isset($_POST["register"])) {
    if (strlen($_POST["name"]) >= 1 && strlen($_POST["email"]) >= 1 && strlen($_POST["password"]) >= 1) {
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $fechareg = date("d/m/y"); // Utilizando el formato de fecha MySQL
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hashing de contraseña

        // Consulta para verificar si el nombre de usuario ya está en uso
        $sql_verificar_usuario = "SELECT * FROM datos WHERE nombre = ?";
        $stmt_verificar_usuario = mysqli_prepare($conex, $sql_verificar_usuario);
        mysqli_stmt_bind_param($stmt_verificar_usuario, "s", $name);
        mysqli_stmt_execute($stmt_verificar_usuario);
        $resultado_verificar_usuario = mysqli_stmt_get_result($stmt_verificar_usuario);

        // Consulta para verificar si el correo electrónico ya está en uso
        $sql_verificar_correo = "SELECT * FROM datos WHERE email = ?";
        $stmt_verificar_correo = mysqli_prepare($conex, $sql_verificar_correo);
        mysqli_stmt_bind_param($stmt_verificar_correo, "s", $email);
        mysqli_stmt_execute($stmt_verificar_correo);
        $resultado_verificar_correo = mysqli_stmt_get_result($stmt_verificar_correo);

        if (mysqli_num_rows($resultado_verificar_usuario) > 0) {
            // El nombre de usuario ya está en uso
            ?>
            <h3 class="bad">El nombre de usuario ya está en uso. Por favor, elija otro.</h3>
            <?php
        } elseif (mysqli_num_rows($resultado_verificar_correo) > 0) {
            // El correo electrónico ya está en uso
            ?>
            <h3 class="bad">El correo electrónico ya está en uso. Por favor, utilice otro.</h3>
            <?php
        } else {
            // Insertar los datos en la base de datos
            $sql_insertar = "INSERT INTO datos (nombre, email, password, fecha_registro) VALUES (?, ?, ?, ?)";
            $stmt_insertar = mysqli_prepare($conex, $sql_insertar);
            mysqli_stmt_bind_param($stmt_insertar, "ssss", $name, $email, $hashed_password, $fechareg);
            $resultado_insertar = mysqli_stmt_execute($stmt_insertar);

            if ($resultado_insertar) {
                ?>
                <h3 class="ok">Te has registrado correctamente!</h3>
                <?php
                header("Location: ../login.php");
            } else {
                ?>
                <h3 class="bad">Ups, ha ocurrido un error!</h3>
                <?php
            }
        }
    } else {
        ?>
        <h3 class="bad">Por favor complete todos los campos!</h3>
        <?php
    }
}
