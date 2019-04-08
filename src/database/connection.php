<?php
$config = include('config.php');
$connection = new mysqli($config['DB_HOST'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_DATABASE'], $config['DB_PORT'], $config['DB_SOCKET'])
or die ('Database connection failed'.mysqli_connect_error());
return $connection;
?>