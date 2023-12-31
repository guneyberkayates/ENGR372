<?php
// Include the configuration file
include("pdoconfig.php");

// Start the session
session_start();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Get user information from the session
$user_id = $_SESSION['id'];
$user_name = $_SESSION['username'];

// Count the number of links for the user
$countQuery = "SELECT COUNT(*) FROM links WHERE user_id = :user_id";
$countStmt = $con->prepare($countQuery);
$countStmt->bindParam(':user_id', $user_id);
$countStmt->execute();
$linkCount = $countStmt->fetchColumn();

// HTML rendering starts here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATKTREE - Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <link rel="icon" href="img/favicon.png" type="image/x-icon">
  </head>
<body>
  <!-- PROFİLDE ADININ BAŞ HARFİ GÖZÜKMESİ İÇİN YAPILAN DEĞİŞKEN ATAMALARI-->
  <?php
  $userfw = $user_name;
  $buyuk = strtoupper($userfw);
  $sonuc = substr($buyuk, 0, 1);

  ?>
<header>
    <div class="logo">
      <a href="home.php"><img src="img/linktree.svg" alt="Logo" style="width: 50%;"></a>  
    </div>
      <nav>
        <ul>
          <li><a href="#">Links</a></li>
          <li><a href="#">Appearance</a></li>
          <li><a href="#">Analytics</a></li>
          <li><a href="#">Settings</a></li>
        </ul>
      </nav>
      <br>
      <nav>
        <div class="button-container">
          <a href="#" class="button" style="background-color: #ecebeb; color: #000;">Try for Free</a>
          <?php echo "<a href='c.php?id={$id}' class='btn btn-warning'>Share</a>"; ?>
          <a href="#" class="yuvarlak-buton"><?php echo $sonuc ?></a>  
        </div>
      </nav>
</header>
<br>
<div class="row">
  <div class="column" style="background-color: skyblue;">
    <div class="button-container">
      <br>
      <br>
      <?php
// Process form submission to add a new link
if ($_POST) {
  include 'pdoconfig.php';

  // Check if the user has reached the link limit
  
      try {
          $sorgu2 = "INSERT INTO links (title, url, user_id) VALUES (:title, :url, :user_id)";
          $stmt2 = $con->prepare($sorgu2);

          $title = htmlspecialchars(strip_tags($_POST['title']));
          $url = htmlspecialchars(strip_tags($_POST['url']));

          $stmt2->bindParam(':title', $title);
          $stmt2->bindParam(':url', $url);
          $stmt2->bindParam(':user_id', $user_id);

          if ($stmt2->execute()) {
              echo "<div class='alert alert-success'>Link kaydedildi.</div>";
          } else {
              echo "<div class='alert alert-danger'>Link kaydedilemedi.</div>";
          }
      } catch (PDOException $exception) {
          die('ERROR: ' . $exception->getMessage());
      }
  
}
?>
   


		  
	 <!-- Kategori bilgilerini girmek için kullanılacak html formu -->
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" style="background-color: ;">
		 <table class='table table-hover table-responsive table-bordered'>
			 <tr>
				 <td>Title</td>
				 <td><input type='text' name='title' class='form-control' /></td>
			 </tr>
			 <tr>
				 <td>Url</td>
				 <td><input type='text' name='url' class='form-control' /></td>
			 </tr>
			 <tr>
				 <td></td>
				 <td>
				 <input type='submit' value='Add Link +' class='btn btn-primary' />
				 </td>
			 </tr>
		 </table>
	</form>
    </div>
    <div class="button-container">
      <a href="#" class="addbutton" style="border-radius: 20px;" onclick="showLinkForm2()">EDIT LINKS ></a>
      <br>
      <br>
      <form id="linkForm2" style="display: none;">
      <?php
        $sorgu1 = "SELECT id, title, url FROM links WHERE user_id = :user_id";
        $stmt1 = $con->prepare($sorgu1);
        $stmt1->bindParam(':user_id', $user_id);
        $stmt1->execute();
        

        if($linkCount>0){

        echo "<table class='table table-hover table-responsive table-bordered'>";
        //tablo başlangıcı
        //tablo başlıkları
        echo "<tr>";
          echo "<th>TITLE</th>";
          echo "<th>URL</th>";
          echo "<th>İşlem</th>";
        echo "</tr>";

          while ($kayit = $stmt1->fetch(PDO::FETCH_ASSOC)){
          // tablo alanlarını değişkene dönüştürür
          // $kayit['ORNEK'] => $ORNEK
            extract($kayit);

            // her kayıt için yeni bir tablo satırı oluştur
            echo "<tr>";
              echo "<td>{$title}</td>";
              echo "<td>{$url}</td>";
              echo "<td>";
                 // kayıt silme butonu
                  echo "<a href='#' onclick='silme_onay({$id});' class='btn btn-danger'><span class='glyphicon glyphicon glyphicon-remove-circle'></span> Sil</a>";
              echo "</td>";
            echo "</tr>";
          }


        echo "</table>"; // tablo sonu

        }

        else{
        echo "<div class='alert alert-danger'>Listelenecek link bulunamadı.</div>";
        }

        ?>
      </form>
      <!-- TEMAYI DEĞİŞTİRDİĞİMİZ BUTON VE JAVASCRİPT'E YÖNLENDİREN ONCLİCK ÖZELLİĞİ -->
      <a href="#" class="addbutton" style="border-radius: 20px;" onclick="changeBackgroundColor()">CHANGE THEME ></a>
      
    </div>
  </div>
  <div class="column" style="background-color: #87b578;">
  <!-- TELEFON GÖRÜNTÜSÜNÜ ELDE ETTİĞİMİZ CSS -->
    <div class="phone">
      <div class="screen">
      <div style="text-align: center;">
      <!-- PROFİL VE USERNAME'İN İLK HARFİ -->
        <p class="yuvarlak-buton2"><?php echo $sonuc ?></p>
        <b><p> @<?php echo $userfw?> </p></b>
        <?php
        //SORGU BAŞLANGICI LİNK LİSTELEME
        $sorgu1 = "SELECT id, title, url FROM links WHERE user_id = :user_id";
        $stmt1 = $con->prepare($sorgu1);
        $stmt1->bindParam(':user_id', $id);
        if ($stmt1->execute() && $linkCount > 0) {


        echo "<table class='table table-hover table-responsive table-bordered'>";
        //tablo başlangıcı
        //tablo başlıkları
        echo "<tr>";
          echo "<th>TITLE</th>";
          echo "<th>URL</th>";
          echo "<th></th>";
        echo "</tr>";

          while ($kayit = $stmt1->fetch(PDO::FETCH_ASSOC)){
          // tablo alanlarını değişkene dönüştürür
          // $kayit['ORNEK'] => $ORNEK
            extract($kayit);

            // her kayıt için yeni bir tablo satırı oluştur
            echo "<tr>";
              echo "<td>{$title}</td>";
              echo "<td>{$url}</td>";
              echo "<td>";
                // kayıt detay sayfa bağlantısı
                echo "<a href='#' onclick='window.location.href=\"$url\"' class='btn btn-danger'><span class='glyphicon glyphicon glyphicon-eye-open'></span>Tıkla</a>";
              echo "</td>";
            echo "</tr>";
          }


        echo "</table>"; // tablo sonu

        }

        else{
        echo "<div class='alert alert-danger'>Listelenecek link bulunamadı.</div>";
        }

        ?>

      </div>

        
      </div>
     
    </div>
    
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>


<style>
        * {
          box-sizing: border-box;
        }

        /* Create two equal columns that floats next to each other */
        .column {
          float: left;
          width: 50%;
          padding: 10px;
          height: 650px; /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */
        .row:after {
          content: "";
          display: table;
          clear: both;
        }
        /* Header tasarımı */
        header {
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-around;
            background-color: #fff;
            border-bottom: 1px solid #ccc;
            border-radius: 55px;
            position: sticky;
            top: 15px;
            z-index: 9999; /* Header'ın diğer öğelerin üzerinde bulunması için z-index kullanıyoruz */
        }
   

        /* Başlık ve Logo Tasarımı */
        .logo {
            display: inline-block;
            height: 50px;
            margin-left: 20px;
        }

        .logo img {
            height: 100%;
        }

        nav ul {
          list-style: none;
          margin: 0;
          display: flex;
        }

        nav li {
          margin: 0 5px;
        }

        nav a {
          text-decoration: none;
          color: #333;
        }

        .button-container {
          margin-left: auto;
        }

        .button {
          display: inline-block;
          padding: 10px 20px;
          background-color: #333;
          color: #fff;
          border-radius: 4px;
          text-decoration: none;
          margin-left: 10px;
        }

        .button:hover {
          background-color: #666;
        }
        .yuvarlak-buton {
          display: inline-block;
          border-radius: 50%;
          padding: 10px 20px;
          background-color: #87b578;
          color: #fff;
          border: none;
          cursor: pointer;
        }

        .yuvarlak-buton2 {
          display: inline-block;
          width: 80px;
          height: 80px;
          border-radius: 50%;
          padding: 10px;
          background-color: #ff9d00;
          color: #fff;
          border: none;
          cursor: pointer;
          margin-top: 30px;
          margin-bottom: 30px;
          font-size: 40px;
        }


        .addbutton {
          display: inline-block;
          padding: 10px 20px;
          background-color: orange;
          color: #fff;
          border-radius: 4px;
          text-decoration: none;
          margin-left: 10px;
          width: 30%;
        }

        .addbutton:hover {
          background-color: orangered;
        }


        .phone {
          width: 500px;
          height: 600px;
          background-color: #333;
          border-radius: 40px;
          position: relative;
          padding-top: 20px;
        }

        .screen {
          width: 90%;
          height: 90%;
          background-color: #FFF;
          border-radius: 20px;
          margin: 15px auto 0;
          position: relative;
          z-index: 1;
        }


       
       
</style>

<script>
  function showLinkForm() {
    var form = document.getElementById('linkForm');
    form.style.display = 'block';
  
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      var title = form.querySelector('input[name="title"]').value;
      var url = form.querySelector('input[name="url"]').value;
  
      // Burada AJAX kullanarak sunucuya link verilerini gönderebilirsiniz
      // ...
  
      // Formu sıfırla ve gizle
      form.reset();
      form.style.display = 'none';
    });
  }




  function showLinkForm2() {
    var form = document.getElementById('linkForm2');
    form.style.display = 'block';
  
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      var title = form.querySelector('input[name="title"]').value;
      var url = form.querySelector('input[name="url"]').value;
  
      // Burada AJAX kullanarak sunucuya link verilerini gönderebilirsiniz
      // ...
  
      // Formu sıfırla ve gizle
      form.reset();
      form.style.display = 'none';
    });
  }

  function changeBackgroundColor() {
  var screenElement = document.querySelector('.screen');
  var color = getRandomColor();
  screenElement.style.backgroundColor = color;
  localStorage.setItem('background_color', color);
}

function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

// Sayfa yüklendiğinde arka plan rengini kontrol et
window.addEventListener('load', function() {
  var storedColor = localStorage.getItem('background_color');
  if (storedColor) {
    var screenElement = document.querySelector('.screen');
    screenElement.style.backgroundColor = storedColor;
  }
});
  </script>

<script type='text/javascript'>
	 // kayıt silme işlemini onayla
	 function silme_onay( id ){

		 var cevap = confirm('Kaydı silmek istiyor musunuz?');
		 if (cevap){
		 // kullanıcı evet derse,
		 // id bilgisini sil.php sayfasına yönlendirir
		 	window.location = 'delete-link.php?id=' + id;
		 }
	 }
</script>