<!DOCTYPE html>
<!--https://cs4640.cs.virginia.edu/sdh7ksu/UVPlay-Project/index.html-->
<html lang="en">
    <head>
    <meta charset="utf-8">
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <title>Login</title>
        
         
    </head>  
    <body>
	    <header>
            <!--https://cs4640.cs.virginia.edu/han3wf/UVPlay-Project/-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="#">
                    <img src="logo.png" id="logo" alt="Logo" class="navbar-logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                      <a class="nav-link" href="?command=showwelcome">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="?command=showwordle">Daily Wordle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?command=showquiz">Daily Quiz</a>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link" href="?command=showleaderboard">Leaderboard</a>
                    </li>  
                                       
                  </ul>

                  <div class="navbar-nav mx-auto">
                    <span class="text-light middleTitle">UVPlay</span>
                  </div>

                  <div class="navbar-nav ml-auto">
                    <div class = "profile-picture mr-2">
                        <img src="monkey.jpg" alt="Profile Picture">
                    </div>
                    <span class = "mr-2 user-name text-light">
                        <?php if(isset($_SESSION["name"])): ?>
                            <a href="index.php?command=showprofile"><?php echo $_SESSION["name"]; ?></a>
                        <?php else: ?>
                            Name Here
                        <?php endif; ?>
                    </span>
                    <button class = "btn btn-primary login-button" id = "loginclick">
                        <span class = "login-button-text">Login/Logout</span>
                    </button>
                    </div>
                  
                </div>
            </nav>
        </header>
        <div class = "container-main">
            <h1 class="text-light">Edit Profile</h2>
            <div class="container">
            <?php if(isset($_SESSION["name"])): ?>
                <form action="?command = editdetails" method="POST">
                    <div class="form-group">
                        <label for="currentUsername">Current Username:</label>
                        <input type="text" class="form-control" id="currentUsername" name="currentUsername" value="<?php echo $_SESSION["name"]; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="newUsername">New Username:</label>
                        <input type="text" class="form-control" id="newUsername" name="newUsername">
                    </div>
                    <div class="form-group">
                        <label for="currentPassword">Current Password:</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" value="<?php echo $_SESSION["password"]; ?>" readonly>
                        <button type="button" class="btn btn-secondary" onclick="togglePasswordVisibility('currentPassword')">Show Password</button>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                    </div>
                </form>
            <?php endif; ?>
            </div>
            <div class="d-flex justify-content-end align-items-end fixed-bottom mb-3 mr-3">
                <button class="btn btn-primary mr-2" onclick="window.location.href='index.php?command=showprofile';">Cancel</button>
                <button class="btn btn-primary" onclick="confirmEdit();">Confirm</button>
            </div>
        </div>

	    <footer class = "footer">
	        <p>
	            <small>All Rights Reserved. Designed by Bryson Matsuda and Sam Harless</small>
	        </p>
        </footer>
        <script>
            document.getElementById("loginclick").onclick = function(){
                window.location.href = "?command=showlogin";
            };
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            function togglePasswordVisibility(inputId) {
                var passwordInput = document.getElementById(inputId);
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }
            }
        </script>
    </body>
 </html>