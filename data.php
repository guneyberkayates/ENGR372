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


if (isset($_POST['exit_button_clicked'])) {
    session_destroy();
    header("Location: login.php"); // Redirect to login page after session destruction
    exit();
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
        $GitHub = $firstRecord['GitHub'];
        $Reddit = $firstRecord['Reddit'];
    } else {
        // Handle the case when no user data is found
        echo 'No user data found';
        exit;
    }
} catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}

// Check if a delete request is submitted
if (isset($_POST['deleteTwitter'])) {
    try {
        $query = "UPDATE user_data SET Twitter = NULL WHERE id = :user_id";
        $statement = $con->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $statement->execute();
        echo 'Twitter deleted successfully'; // Debugging statement
        header('Location: data.php');
        exit;
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}

// Repeat the above block for other social media platforms
if (isset($_POST['deleteFacebook'])) {
    try {
        $query = "UPDATE user_data SET Facebook = NULL WHERE id = :user_id";
        $statement = $con->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $statement->execute();
        echo 'Facebook deleted successfully'; // Debugging statement
        header('Location: data.php');
        exit;
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}

if (isset($_POST['deleteInstagram'])) {
    try {
        $query = "UPDATE user_data SET Instagram = NULL WHERE id = :user_id";
        $statement = $con->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $statement->execute();
        echo 'Instagram deleted successfully'; // Debugging statement
        header('Location: data.php');
        exit;
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}

if (isset($_POST['deleteLinkedin'])) {
    try {
        $query = "UPDATE user_data SET Linkedin = NULL WHERE id = :user_id";
        $statement = $con->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $statement->execute();
        echo 'LinkedIn deleted successfully'; // Debugging statement
        header('Location: data.php');
        exit;
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}

if (isset($_POST['deleteGitHub'])) {
    try {
        $query = "UPDATE user_data SET GitHub = NULL WHERE id = :user_id";
        $statement = $con->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $statement->execute();
        echo 'GitHub deleted successfully'; // Debugging statement
        header('Location: data.php');
        exit;
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}

if (isset($_POST['deleteReddit'])) {
    try {
        $query = "UPDATE user_data SET Reddit = NULL WHERE id = :user_id";
        $statement = $con->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $statement->execute();
        echo 'Reddit deleted successfully'; // Debugging statement
        header('Location: data.php');
        exit;
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}

if (isset($_POST['removeImage'])) {
    try {
        $query = "UPDATE user_data SET profile_pic = NULL WHERE id = :user_id";
        $statement = $con->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $statement->execute();
        echo 'Image removed successfully'; // Debugging statement
        header('Location: data.php');
        exit;
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
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
        .GitHub-div {
            background-color: #e0e0e0; /* Light grey for GitHub */
        }

        .Reddit-div {
            background-color: #ff5722; /* Deep orange for Reddit */
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
<?php include('header.php'); ?>

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
        <form method="post" >
            <input type="hidden" name="removeImage" value="true">
            <button type="submit">Remove Image</button>
        </form>
        <div class="data-div Twitter-div" style="display: flex; flex-direction: row;">
            <img src="./images/svg/file6.svg" alt="Twitter Icon" style="width: 1.25em; height: 1.25em;">
            <p><strong>Twitter:</strong> <a href="<?php echo $Twitter; ?>" target="_blank" id="Twitter"><?php echo $Twitter; ?></a>
                <!-- Add delete button -->
                <form method="post" >
                    <input type="hidden" name="deleteTwitter" value="true">
                    <button type="submit">Delete</button>
                </form>
            </p>
        </div>

        <div class="data-div Facebook-div" style="display: flex; flex-direction: row;">
            <img src="./images/svg/file1.svg" alt="Facebook Icon" style="width: 1.25em; height: 1.25em;">
            <p><strong>Facebook:</strong> <a href="<?php echo $Facebook; ?>" target="_blank" id="Facebook"><?php echo $Facebook; ?></a>
                <!-- Add delete button -->
                <form method="post" >
                    <input type="hidden" name="deleteFacebook" value="true">
                    <button type="submit">Delete</button>
                </form>
            </p>
        </div>

        <div class="data-div Instagram-div" style="display: flex; flex-direction: row;">
            <img src="./images/svg/file3.svg" alt="Instagram Icon" style="width: 1.25em; height: 1.25em;">
            <p><strong>Instagram:</strong> <a href="<?php echo $Instagram; ?>" target="_blank" id="Instagram"><?php echo $Instagram; ?></a>
                <!-- Add delete button -->
                <form method="post" >
                    <input type="hidden" name="deleteInstagram" value="true">
                    <button type="submit">Delete</button>
                </form>
            </p>
        </div>

        <div class="data-div Linkedin-div" style="display: flex; flex-direction: row;">
            <img src="./images/svg/file4.svg" alt="LinkedIn Icon" style="width: 1.25em; height: 1.25em;">
            <p><strong>LinkedIn:</strong> <a href="<?php echo $Linkedin; ?>" target="_blank" id="Linkedin"><?php echo $Linkedin; ?></a>
                <!-- Add delete button -->
                <form method="post" >
                    <input type="hidden" name="deleteLinkedin" value="true">
                    <button type="submit">Delete</button>
                </form>
            </p>
        </div>

        <div class="data-div GitHub-div" style="display: flex; flex-direction: row;">
            <img src="./images/svg/file2.svg" alt="GitHub Icon" style="width: 1.25em; height: 1.25em;">
            <p><strong>GitHub:</strong> <a href="<?php echo $GitHub; ?>" target="_blank" id="GitHub"><?php echo $GitHub; ?></a>
                <!-- Add delete button -->
                <form method="post" >
                    <input type="hidden" name="deleteGitHub" value="true">
                    <button type="submit">Delete</button>
                </form>
            </p>
        </div>

        <div class="data-div Reddit-div" style="display: flex; flex-direction: row;">
            <img src="./images/svg/file5.svg" alt="Reddit Icon" style="width: 1.25em; height: 1.25em;">
            <p><strong>Reddit:</strong> <a href="<?php echo $Reddit; ?>" target="_blank" id="Reddit"><?php echo $Reddit; ?></a>
                <!-- Add delete button -->
                <form method="post" >
                    <input type="hidden" name="deleteReddit" value="true">
                    <button type="submit">Delete</button>
                </form>
            </p>
        </div>
    </div>
    <?php include('footer.php'); ?>

</body>
</html>
