<!-- VERİTABANINA KULLANICI GİRİŞİ YAPMAYI SAĞLAYAN İŞLEMLER -->

<?php 

session_start();
ob_start();

include "loginconfig.php";

//BOŞ KAYIT OLUP OLMADIĞINI KONTROL EDEN KISIM

if (isset($_POST['uname']) && isset($_POST['pword'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['pword']);

	if (empty($uname)) {
		header("Location: login.php?error=You must write username.");
	    exit();
	}
	else if(empty($pass)){
        header("Location: login.php?error=You must write password.");
	    exit();
	}
	else{
		//BOŞ KAYIT YOKSA SORGUNUN BAŞLANGICI
		$sql = "SELECT * FROM users WHERE username='$uname' AND password='$pass'";

		$result = mysqli_query($conn, $sql);
		//GİRİLEN BİLGİLERİN DOPRULUĞUNUN KONTROLÜ
		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['username'] === $uname && $row['password'] === $pass) {
            	$_SESSION['username'] = $row['username'];
            	$_SESSION['name'] = $row['adsoyad'];
            	$_SESSION['id'] = $row['id'];
				header("Location: home.php");
 				exit();
     
            }else{
				header("Location: login.php?error=Invalid username or password!");
		        exit();
			}
		}else{
			header("Location: login.php?error=Invalid username or password!");
	        exit();
		}
	}
	
}

else{
	header("Location: login.php");
	exit();
}


?>