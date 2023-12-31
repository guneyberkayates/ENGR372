<!-- TÜM KULLANICILARIN İD BİLGİSİNE GÖRE LİNK KISALTMA İŞLEMİ YAPTIĞI SAYFA-->


<?php
include("pdoconfig.php");
session_start();

// Kullanıcının oturum açtığından emin olun
if (!isset($_SESSION['id'])) {
  // Kullanıcı oturum açmadıysa, yönlendirme yapın veya hata mesajı gösterin
  header('Location: login.php');
  exit;
}

// Oturum açmış olan kullanıcının kimliğini alın
$user_id = $_SESSION['id'];
$user_name = $_SESSION['username'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>

<?php
// Generate the user's first initial for display
$userInitial = strtoupper(substr($user_name, 0, 1));
?>

<div style="text-align: center;" class="screen">
    <p class="yuvarlak-buton2"><?php echo $userInitial ?></p>
    <b><p> @<?php echo $user_name ?> </p></b>
    <a href="#" class="addbutton" style="border-radius: 20px;" onclick="changeBackgroundColor()">CHANGE THEME ></a>

    <?php
    // Fetch user's links from the database
    $linkQuery = "SELECT id, title, url FROM links WHERE user_id = :user_id";
    $linkStmt = $con->prepare($linkQuery);
    $linkStmt->bindParam(':user_id', $user_id);
    $linkStmt->execute();

    $linkCount = $linkStmt->rowCount();

    if ($linkCount > 0) {
        echo "<table class='table table-striped'>";
        echo "<tr>";
        echo "<th>TITLE</th>";
        echo "<th>URL</th>";
        echo "<th>ACTION</th>";
        echo "</tr>";

        while ($link = $linkStmt->fetch(PDO::FETCH_ASSOC)) {
            extract($link);
            echo "<tr>";
            echo "<td>{$title}</td>";
            echo "<td>{$url}</td>";
            echo "<td>";
            echo "<a href='$url' target='_blank'><span class='btn btn-dark'>Tıkla</span></a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<div class='alert alert-danger'>Listelenecek link bulunamadı.</div>";
    }
    ?>
</div>

      </div>

        
      </div>
     
</div>




</body>

<style>

    
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
<!-- TEMA DEĞİŞTİRME SCRIPTI -->
<script>
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