<!-- VERİTABANI BAĞLANTISIDIR -->

<?php

$sname= "localhost";
$unmae= "abc";
$password = "abc";
$db_name = "group2";


$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}
