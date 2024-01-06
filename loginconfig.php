<!-- VERİTABANI BAĞLANTISIDIR -->

<?php

$sname= "localhost";
$unmae= "abc";
$password = "abc";
$db_name = "engr372";


$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}
