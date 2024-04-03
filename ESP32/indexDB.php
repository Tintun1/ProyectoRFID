<?php
include("../con_db.php");

$sql = "SELECT * FROM led_status;";
$result   = mysqli_query($conex, $sql);
$row  = mysqli_fetch_assoc($result);

if (isset($_POST["actualizar"])) {
	$linea_1 = $_POST["linea_1"];
	$linea_2 = $_POST["linea_2"];
	$sql = "UPDATE lcd_status SET lcd_text='$linea_1' WHERE id = 1;";
	$sql2 = "UPDATE lcd_status SET lcd_text='$linea_2' WHERE id = 2;";
	if (mysqli_query($conex, $sql) and mysqli_query($conex, $sql2)) {
		echo "<h3 class='ok'>Actualización exitosa</h1>";
	} else {
		echo "<h3 class='bad'>Error al actualizar: </h1>";
	}

}

// Consulta a la base de datos
if (isset($_POST['toggle_LED'])) {
	$sql = "SELECT * FROM led_status;";
	$result   = mysqli_query($conex, $sql);
	$row  = mysqli_fetch_assoc($result);
	if($row['status'] == 0){
		$update = mysqli_query($conex, "UPDATE led_status SET status = 1 WHERE id = 1;");
        header("Location: index2.php");
	}
}
if (isset($_POST["disable_LED"])) {
    $sql = "SELECT * FROM led_status;";
    $result   = mysqli_query($conex, $sql);
    $row  = mysqli_fetch_assoc($result);
	if($row['status'] == 1){
		$update = mysqli_query($conex, "UPDATE led_status SET status = 0 WHERE id = 1;");
        header("Location: index2.php");
	}
}

//resultado impreso a app web
if ($row["status"] == 0){
    $estado ="OFF";
} elseif ($row["status"] == 1) {
    $estado = "ON";
} else {
    $estado = "ERROR";
}

?>