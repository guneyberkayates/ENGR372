
<!-- GEREK GÖÜRLMEYEN LİNKLERİN SİLİNMESİ İŞLEMİ-->

<?php
include("pdoconfig.php");
session_start();

// Kullanıcının oturum açtığından emin olun
if (!isset($_SESSION['id'])) {
  // Kullanıcı oturum açmadıysa, yönlendirme yapın veya hata mesajı gösterin
  header('Location: login.php');
  exit;
}

try {
	 // kaydın id bilgisini al
	 $id=isset($_GET['id']) ? $_GET['id'] : die('HATA: Id bilgisi bulunamadı.');
	 // silme sorgusu
	 $sorgu = "DELETE FROM links WHERE id = ?";
	 $stmt = $con->prepare($sorgu);
	 $stmt->bindParam(1, $id);

	 // sorguyu çalıştır
	 if($stmt->execute()){
		 // kayıt listeleme sayfasına yönlendir
		 // ve kullanıcıya kaydın silindiğini
		 header('Location: home.php?islem=silindi');
	 } // veya silinemediğini bildir
	 else{
		 header('Location: home.php?islem=silinemedi');
	 }
	}
// hata varsa göster
catch(PDOException $exception){
 die('HATA: ' . $exception->getMessage());
}
?>
