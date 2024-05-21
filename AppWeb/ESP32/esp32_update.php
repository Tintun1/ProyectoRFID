<?php
include("../con_db.php");

if (isset($_POST['check_uid_code'])) {
	$uid = $_POST['check_uid_code'];
	$sql = "SELECT * FROM tarjetas_registradas WHERE UID = '$uid';";
	$result   = mysqli_query($conex, $sql);
	$row  = mysqli_fetch_assoc($result);
	if ($row && $row['UID'] == $uid) {
        echo $row['UID'];
		//$fechareg = date("d-m-y H:i");
		$nombre = $row['nombre'];
		$UID = $row['UID'];
		$dato = $row['dato'];
		$verificado = "verificado";
		$sql_insertar = "INSERT INTO historial (nombre, UID, dato, verificado) VALUES (?, ?, ?, ?)";
		$stmt_insertar = mysqli_prepare($conex, $sql_insertar);
		mysqli_stmt_bind_param($stmt_insertar, "ssss", $nombre, $UID, $dato, $verificado);
		$resultado_insertar = mysqli_stmt_execute($stmt_insertar);
    } else {
        echo 0;
		//$fechareg = date("d-m-y H:i");
		$nombre = "-";
		$dato = "-";
		$verificado = "no_verificado";
		$sql_insertar = "INSERT INTO historial (nombre, UID, dato, verificado) VALUES (?, ?, ?, ?)";
		$stmt_insertar = mysqli_prepare($conex, $sql_insertar);
		mysqli_stmt_bind_param($stmt_insertar, "ssss", $nombre, $uid, $dato, $verificado);
		$resultado_insertar = mysqli_stmt_execute($stmt_insertar);
    }
}

if(isset($_POST["check_uid_status"])) {
    $id = $_POST["check_uid_status"];
    $sql = "SELECT * FROM uid_status WHERE id = '$id';";
    $result = mysqli_query($conex, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['status'] == 1) {
            echo "1"; // UID está activo
        } else {
            echo "0"; // UID no está activo
        }
    } else {
        echo "0"; // Error al buscar el estado del UID
    }
}

// Actualizar el UID en la base de datos
if(isset($_POST["submit_uid"])) {
    $uid = $_POST["submit_uid"];
    $sql = "UPDATE tarjetas_no_registradas SET codigo_uid = '$uid' WHERE id = 1;";
    $result = mysqli_query($conex, $sql);

    $sql2 = "UPDATE uid_status SET status = 0 WHERE id = 1;";
    $result2 = mysqli_query($conex, $sql2);
}
