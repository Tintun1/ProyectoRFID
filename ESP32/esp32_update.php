<?php
include("../con_db.php");

if (isset($_POST['check_LED_status'])) {
	$led_id = $_POST['check_LED_status'];
	$sql = "SELECT * FROM led_status WHERE id = '$led_id';";
	$result   = mysqli_query($conex, $sql);
	$row  = mysqli_fetch_assoc($result);
	if($row['status'] == 0){
		echo "OFF";
	}
	else{
		echo "ON";
	}
}

if (isset($_POST["check_LCD_status"])) {
	$lcd_id = $_POST["check_LCD_status"];
	$sql = "SELECT * FROM lcd_status WHERE id = '$lcd_id'";
	$result = mysqli_query($conex, $sql);
	$row = mysqli_fetch_assoc($result);
	echo $row['lcd_text'];
}

if (isset($_POST['toggle_LED'])) {
	$led_id = $_POST['toggle_LED'];	
	$sql = "SELECT * FROM LED_status WHERE id = '$led_id';";
	$result   = mysqli_query($conex, $sql);
	$row  = mysqli_fetch_assoc($result);
	if($row['status'] == 0){
		$update = mysqli_query($conex, "UPDATE LED_status SET status = 1 WHERE id = 1;");
		echo "LED_is_on";
	}
	else{
		$update = mysqli_query($conex, "UPDATE LED_status SET status = 0 WHERE id = 1;");
		echo "LED_is_off";
	}
}
?>