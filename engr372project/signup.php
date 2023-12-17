<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300&display=swap" rel="stylesheet">
    <title>ATKTREE - LINK KISALTMA SERVİSİ </title>
</head>
<body>
<!-- KAYIT SAYFASI İÇİN OLUŞTURULAN FORM-->
    <div class="body-container">
    <div class="container" id="container">
        <div>
        
        <div class="form-container sign-in-container">
            <form action="signup-start.php" method="post">
                <b><h1>Create your account</h1>
				<?php 
				
				if (isset($_GET['error'])) { ?>
					
				<p class="error"> <?php echo $_GET['error'] ?> </p>
				
				<?php
				}
				
				?>
                <input type="text" name="name" placeholder="Name" />
                <input type="text" name="uname" placeholder="atktree.com/username" />
                <input type="text" name="mail" placeholder="Email" />
                <input type="password" name="pword" placeholder="Password" />
                <br>
                <p>Already have an account? <a href="login.php" style="color: blue;">Log in</a></p>
                <button type="submit" name="submit" class="btn-grad">Create Account</button>
                
            </form>
        </div>
        </div>

        <div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                <img src="./images/black_link.png" alt="" style="width: 50%;" >
                <br>
                    <h1>Link In Bio</h1>
                </div>
            </div>
        </div>
        </div>
    </div>

    </div>
</body>
</html>