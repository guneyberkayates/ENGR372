<!-- VERİTABANI BAĞLANTISIDIR -->

<?php

$sname= "localhost";
$unmae= "root";
$password = "12GBAgba.";
$db_name = "engr372";


$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}
