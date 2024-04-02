<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESP32 TEST</title>
    <link rel="stylesheet" type="text/css" href="../estilo.css">
</head>
<body>
    <?php
    include("indexDB.php");
    ?>
    <div class="container">
        <div class="header">
            <h1>Prueba ESP32</h1>
        </div>
        <?php echo '<h2 style="text-align: center;">El estado del led es: '.$estado.'</h2>';?>
        <form action="" method="post" id="LED" enctype="multipart/form-data">
			<input id="submit_button" type="submit" name="toggle_LED" value="Toggle LED"/>
            <input type="submit" name="disable_LED" value="Disable LED">
		</form>
    </div>
</body>
</html>