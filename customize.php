<?php
// Include the configuration file
include 'pdoconfig.php';

// Start the session
session_start();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Rest of your existing code...


// Get user information from the session
$user_id = $_SESSION['id'];
$user_name = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Check if a file was uploaded
        if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
            $imageData = file_get_contents($_FILES['profilePic']['tmp_name']);
            $base64Image = base64_encode($imageData);
        } else {
            $base64Image = null; // No image uploaded
        }

        // Check if GitHub and Reddit fields exist in $_POST
        $GitHub = isset($_POST['GitHub']) ? $_POST['GitHub'] : '';
        $Reddit = isset($_POST['Reddit']) ? $_POST['Reddit'] : '';

        // Check if the record with the given user ID already exists
        $checkQuery = "SELECT * FROM user_data WHERE id = :user_id";
        $checkStmt = $con->prepare($checkQuery);
        $checkStmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $checkStmt->execute();
        $rowCount = $checkStmt->rowCount();

        if ($rowCount > 0) {
            // Update the existing record
            $updateQuery = "UPDATE user_data SET Twitter = :Twitter, Facebook = :Facebook, Instagram = :Instagram, 
                Linkedin = :Linkedin, GitHub = :GitHub, Reddit = :Reddit, profile_pic = :profilePic, 
                selectedColor = :selectedColor WHERE id = :user_id";
            $stmt2 = $con->prepare($updateQuery);
        } else {
            // Insert a new record
            $insertQuery = "INSERT INTO user_data (id, Twitter, Facebook, Instagram, Linkedin, GitHub, Reddit, 
                profile_pic, selectedColor) VALUES (:user_id, :Twitter, :Facebook, :Instagram, :Linkedin, 
                :GitHub, :Reddit, :profilePic, :selectedColor)";
            $stmt2 = $con->prepare($insertQuery);
        }

        $Twitter = $_POST['Twitter'];
        $Facebook = $_POST['Facebook'];
        $Instagram = $_POST['Instagram'];
        $Linkedin = $_POST['Linkedin'];
        $selectedColor = isset($_POST['selectedColor']) ? $_POST['selectedColor'] : '';
        $stmt2->bindParam(':selectedColor', $selectedColor, PDO::PARAM_STR);

        $stmt2->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt2->bindParam(':Twitter', $Twitter, PDO::PARAM_STR);
        $stmt2->bindParam(':Facebook', $Facebook, PDO::PARAM_STR);
        $stmt2->bindParam(':Instagram', $Instagram, PDO::PARAM_STR);
        $stmt2->bindParam(':Linkedin', $Linkedin, PDO::PARAM_STR);
        $stmt2->bindParam(':GitHub', $GitHub, PDO::PARAM_STR);
        $stmt2->bindParam(':Reddit', $Reddit, PDO::PARAM_STR);
        $stmt2->bindParam(':profilePic', $base64Image, PDO::PARAM_LOB);

        if ($stmt2->execute()) {
            echo "<div class='alert alert-success'>Data saved successfully.</div>";
            // Redirect to data.php
            header("Location: data.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Failed to save data.</div>";
        }
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Customization</title>
  <style>
    /* Custom styles for the page */
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0; /* Light green default background */
      margin: 0;
      padding: 0;
    }

    .container {
      position: relative;
      max-width: 600px;
      margin: 20px auto;
      background-color: #fff; /* White background for the container */
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Adding a slight shadow */
    }

    .input-div {
      margin-bottom: 15px;
    }

    .input-div input[type="text"],
    .input-div input[type="file"] {
      width: calc(100% - 10px);
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .input-div input[type="file"] {
      padding: 5px;
    }

    .circle {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-color: lightblue;
      display: inline-block;
      margin: 10px;
    }

    /* Different colored divs for user properties */
    .Twitter-div {
      background-color: #ffd54f; /* Light yellow */
      padding: 10px;
      border-radius: 5px;
    }

    .Facebook-div {
      background-color: #ffccbc; /* Light orange */
      padding: 10px;
      border-radius: 5px;
    }

    .Instagram-div {
      background-color: #81c784; /* Light green */
      padding: 10px;
      border-radius: 5px;
    }

    .Linkedin-div {
      background-color: #90caf9; /* Light blue */
      padding: 10px;
      border-radius: 5px;
    }

    button {
      padding: 10px 20px;
      background-color: #4caf50; /* Green button */
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #388e3c; /* Darker green on hover */
    }

    /* Styles for settings button */
    #settingsButton {
      position: absolute;
      top: 10px;
      right: 10px;
      padding: 8px 12px;
      border: none;
      border-radius: 4px;
      background-color: #4caf50; /* Green button */
      color: white;
      cursor: pointer;
      z-index: 1;
    }

    .color-options {
      display: none;
      position: absolute;
      top: 40px;
      right: 0;
      width: 120px;
      padding: 8px;
      border-radius: 4px;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      z-index: 1;
    }
    .GitHub-div {
      background-color: #e0e0e0;
      padding: 10px;
      border-radius: 5px;
    }

    .Reddit-div {
      background-color: #ff5722;
      padding: 10px;
      border-radius: 5px;
    }

    .color-option {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      display: inline-block;
      margin-right: 8px;
      cursor: pointer;
    }

    #settingsButton.active + .color-options {
      display: block;
    }
  </style>
</head>
<body>
<?php include('header.php'); ?>

  <div class="container">
    
    <button id="settingsButton" onclick="toggleColorOptions()">Settings</button>
    
    <div class="color-options">
      <input type="hidden" id="selectedColor" name="selectedColor">
      <div class="color-option" style="background-color: blue" onclick="changeBackgroundColor('blue')"></div>
      <div class="color-option" style="background-color: yellow" onclick="changeBackgroundColor('yellow')"></div>
      <div class="color-option" style="background-color: green" onclick="changeBackgroundColor('green')"></div>
      <div class="color-option" style="background-color: red" onclick="changeBackgroundColor('red')"></div>
    </div>
    <form id="userDataForm" action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
      <input type="file" id="profilePic" name="profilePic" accept="image/*" onchange="previewImage(event)">
      <br>
      <div class="circle" id="profileCircle"></div>
      <br>
        

        <div class="input-div Twitter-div" style="display: flex; flex-direction:row; ">
        <img src="./images/svg/file6.svg" alt="Twitter Icon" style="width: 1.25em; height: 1.25em;">
    <input type="text" id="Twitter" name="Twitter" placeholder="Twitter">
  </div>
  <div class="input-div Facebook-div" style="display: flex; flex-direction:row;">
    <img src="./images/svg/file1.svg" alt="Facebook Icon"  style="width: 1.25em; height: 1.25em;">
    <input type="text" id="Facebook" name="Facebook" placeholder="Facebook">
  </div>
  <div class="input-div Instagram-div" style="display: flex; flex-direction:row;">
    <img src="./images/svg/file3.svg" alt="Instagram Icon"  style="width: 1.25em; height: 1.25em;">
    <input type="text" id="Instagram" name="Instagram" placeholder="Instagram">
  </div>
  <div class="input-div Linkedin-div" style="display: flex; flex-direction:row;">
    <img src="./images/svg/file4.svg" alt="Linkedin Icon"  style="width: 1.25em; height: 1.25em;">
    <input type="text" id="Linkedin" name="Linkedin" placeholder="Linkedin">
  </div>
  <div class="input-div GitHub-div" style="display: flex; flex-direction:row;">
    <img src="./images/svg/file2.svg" alt="GitHub Icon"  style="width: 1.25em; height: 1.25em;">
    <input type="text" id="GitHub" name="GitHub" placeholder="GitHub">
  </div>
  <div class="input-div Reddit-div" style="display: flex; flex-direction:row;">
    <img src="./images/svg/file5.svg" alt="Reddit Icon"  style="width: 1.25em; height: 1.25em;">
    <input type="text" id="Reddit" name="Reddit" placeholder="Reddit">
  </div>


      <button type="submit" >Save</button>
    </form>
  </div>
  
  <script>
    function toggleColorOptions() {
      const colorOptions = document.querySelector('.color-options');
      const settingsButton = document.getElementById('settingsButton');
      settingsButton.classList.toggle('active');
      colorOptions.style.display = settingsButton.classList.contains('active') ? 'block' : 'none';
    }

    function changeBackgroundColor(color) {
  document.body.style.backgroundColor = color;
  document.getElementById('selectedColor').value = color;
}


    function validateForm() {
      var profilePic = document.getElementById('profilePic').value;
      var Twitter = document.getElementById('Twitter').value;
      var Facebook = document.getElementById('Facebook').value;
      var Instagram = document.getElementById('Instagram').value;
      var Linkedin = document.getElementById('Linkedin').value;

      if (profilePic === '' || Twitter === '' || Facebook === '' || Instagram === '' || Linkedin === '') {
          alert('Please fill in all fields.');
          return false;
      }

      // Additional validation logic can be added here

      // If all validation passes, you can submit the form

      return true;
    }

    function previewImage(event) {
      const file = event.target.files[0];
      const reader = new FileReader();

      reader.onload = function () {
        const profileCircle = document.getElementById('profileCircle');
        profileCircle.style.backgroundImage = `url('${reader.result}')`;
        profileCircle.style.backgroundSize = 'cover';
      };

      if (file) {
        reader.readAsDataURL(file);
      }
    }
  </script>
      <?php include('footer.php'); ?>

</body>
</html>
