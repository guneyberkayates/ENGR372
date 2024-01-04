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
    <!-- GİRİŞ SAYFASI İÇİN OLUŞTURULAN FORM-->
    <div class="body-container" >
    <div class="container" id="container">
        <div>
        <div class="form-container sign-in-container">
            <form action="login-start.php" method="post">
                <b><h1>Log in</h1></b>
				<?php 
				
				if (isset($_GET['error'])) { ?>
					
				<p class="error"> <?php echo $_GET['error'] ?> </p>
				
				<?php
				}
				
				?>
                <input type="text" name="uname" placeholder="atktree.com/username" />
                <input type="password" name="pword" placeholder="Password" />
                <br>
                <p>Don't have an account? <a href="signup.php" style="color: blue;">Sign up</a></p>
                <button type="submit" name="submit" class="btn-grad">Login</button>
                
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