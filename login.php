<!DOCTYPE html>
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
                      <a class="nav-link" href="?command=showwelcome">Home</a>
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
                    <span class = "mr-2 user-name text-light"><?php if($name == true){echo $name;}else{echo "Name Here";} ?></span>
                    <button class = "btn btn-primary login-button" id = "loginclick">
                        <span class = "login-button-text">Login</span>
                    </button>
                    </div>
                  
                </div>
            </nav>
        </header>
        <div class = "container-main">
            <div class="login-container"> <!--https://www.w3schools.com/howto/howto_css_login_form.asp-->
                <h2>Login</h2>
                <form id = "login-form" action = "index.php?command=postwelcome" method = "POST">
                    <div class = "form-group">
                        <label for = "name">Username:</label>
                        <input type = "text" id = "name" name = "name" required>
                    </div>
                    <div class = "form-group">
                        <label for = "password">Password:</label>
                        <input type = "text" id = "password" name = "password" required>
                    </div>
                    <button type = "submit" class = "btn btn primary">Login</button>
                </form>
            </div>
            <a href="?command=logout" class="btn btn-danger logout-button">Logout</a>
        </div>
	    <footer class = "footer">
	        <p>
	            <small>All Rights Reserved. Designed by Bryson Matsuda and Sam Harless</small>
	        </p>
        </footer>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            document.getElementById("loginclick").onclick = function(){
                window.location.href = "?command=showlogin";
            };
        </script>
    </body>
</html>