<!-- PDO İLE YAPILMIŞ VERİTABANI BAĞLANTISIDIR-->
<?php
	// veritabanı bağlantısı için gerekli parametreler
	$host = "localhost";
	$vt_adi = "group2";
	$kullanici_adi = "abc";
	$sifre = "abc";
	try {
		 $con = new PDO("mysql:host={$host};dbname={$vt_adi}", $kullanici_adi, $sifre,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}
	// hatayı göster
	catch(PDOException $exception){
	 	 echo "Bağlantı hatası: " . $exception->getMessage();
	}
?>
