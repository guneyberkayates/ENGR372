<!-- VERİTABANI BAĞLANTISIDIR -->

<?php

$sname= "localhost";
<<<<<<< HEAD
$unmae= "abc";
$password = "abc";
=======
$unmae= "root";
$password = "";
>>>>>>> eafa2b600d53c64cfd94f1ec6797451b740336bf
$db_name = "engr372";


$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}
