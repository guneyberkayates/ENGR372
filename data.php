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

// Get user information from the session
$user_id = $_SESSION['id'];
$user_name = $_SESSION['username'];

try {
    $query = "SELECT * FROM user_data WHERE id = :user_id";
    $statement = $con->prepare($query);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $statement->execute();

    // Fetch the first record as an associative array
    $firstRecord = $statement->fetch(PDO::FETCH_ASSOC);

    if ($firstRecord) {
        $profilePic = $firstRecord['profile_pic'];
        $Twitter = $firstRecord['Twitter'];
        $Facebook = $firstRecord['Facebook'];
        $Instagram = $firstRecord['Instagram'];
        $Linkedin = $firstRecord['Linkedin'];
        $selectedColor = $firstRecord['selectedColor'];
    } else {
        // Handle the case when no user data is found
        echo 'No user data found';
        exit;
    }
} catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saved User Data</title>
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

        img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .data-div {
            margin-bottom: 15px;
        }

        .data-div p {
            padding: 10px;
            border-radius: 5px;
        }

        /* Different colored divs for displaying user data */
        .Twitter-div {
            background-color: #ffd54f; /* Light yellow */
        }

        .Facebook-div {
            background-color: #ffccbc; /* Light orange */
        }

        .Instagram-div {
            background-color: #81c784; /* Light green */
        }

        .Linkedin-div {
            background-color: #90caf9; /* Light blue */
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Saved User Data</h1>

    <?php
   if (!empty($profilePic)) {
    // Determine the image type dynamically
    $imageData = base64_decode($profilePic);
    $imageInfo = getimagesizefromstring($imageData);

    if ($imageInfo !== false) {
        $imageType = $imageInfo['mime'];
        echo '<img src="data:' . $imageType . ';base64,' . $profilePic . '" alt="User Photo">';
    } else {
        echo '<p>Invalid image data</p>';
    }
} else {
    echo '<p>No profile picture available</p>';
}

    ?>

<div class="data-div Twitter-div">
    <p><strong>Twitter:</strong> <a href="<?php echo $Twitter; ?>" target="_blank" id="Twitter"><?php echo $Twitter; ?></a></p>
</div>
<div class="data-div Facebook-div">
    <p><strong>Facebook:</strong> <a href="<?php echo $Facebook; ?>" target="_blank" id="Facebook"><?php echo $Facebook; ?></a></p>
</div>
<div class="data-div Instagram-div">
    <p><strong>Instagram:</strong> <a href="<?php echo $Instagram; ?>" target="_blank" id="Instagram"><?php echo $Instagram; ?></a></p>
</div>
<div class="data-div Linkedin-div">
    <p><strong>Linkedin:</strong> <a href="<?php echo $Linkedin; ?>" target="_blank" id="Linkedin"><?php echo $Linkedin; ?></a></p>
</div>

</div>
</body>
</html>
