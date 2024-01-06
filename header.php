<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="Dasboard_style.css" />
  <script src="Dasboard_script.js"></script>
</head>

<body>
  <header>
    <div class="profile">
      <img src="Dashboard_user.png" alt="Profile Photo" />
    </div>
    <nav>
      <a href="index.php">Main Page</a>
      <a href="customize.php">Customize Page</a>
      <a href="data.php">Data Page</a>
      <a href="pricing.php">Pricing Page</a>
      <a href="info.php">Info Page</a>
      <button id="exit-button" onclick="exitButtonClick()">Exit</button>
    </nav>
  </header>
  <main>
