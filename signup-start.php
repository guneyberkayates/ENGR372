<!-- KAYIT OLMA İŞLEMİNİN VERİTABANI İŞLEMLERİDİR-->

<?php 

session_start();
ob_start();

include "loginconfig.php";

//form verileri alınır

if (isset($_POST['name']) && isset($_POST['uname']) && isset($_POST['mail']) && isset($_POST['pword'])) {
//güvenli hale getirilir
  function validate($data){
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
  }

  $name = validate($_POST['name']);
  $uname = validate($_POST['uname']);
  $mail = validate($_POST['mail']);
  $pass = validate($_POST['pword']);
 
//verilerin doğru girilip girilmediği kontrol edilir
  if (empty($name)) {
    header("Location: signup.php?error=Ad alanı boş bırakılamaz.");
      exit();
    }
  else if(empty($uname)){
    header("Location: signup.php?error=Kullanıcı adı alanı boş bırakılamaz.");
  exit();
    }
  else if(empty($mail)){
    header("Location: signup.php?error=Email alanı boş bırakılamaz.");
  exit();
    }
  else if(empty($pass)){
        header("Location: signup.php?error=Parola alanı boş bırakılamaz.");
      exit();
    }
  else{
    //veriler doğruysa sorgu çaalıştırılır
    $sql = "SELECT * FROM users WHERE username='$uname'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        header("Location: signup.php?error=Kullanıcı adı zaten alınmış.");
        exit();
    }else{
      $sql2 = "INSERT INTO users (name, username, email, password) VALUES ('$name', '$uname', '$mail', '$pass')";
      $result2 = mysqli_query($conn, $sql2);
      if ($result2) {
        header("Location: login.php?success=Kayıt başarılı. Şimdi giriş yapabilirsiniz.");
        exit();
      }else{
        header("Location: signup.php?error=Bir şeyler yanlış gitti. Tekrar deneyin.");
        exit();
      }
    }
  }
  
}

else{
  header("Location: signup.php");
  exit();
}

?>
