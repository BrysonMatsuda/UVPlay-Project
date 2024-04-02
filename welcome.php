<!DOCTYPE html>
<!--https://cs4640.cs.virginia.edu/sdh7ksu/UVPlay-Project/index.html-->
<html lang="en">
    <head>
         <link rel="stylesheet" href="styles/main.css">
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1"> 
	 <title>UVPlays</title>

         <meta name="author" content="Bryson Matsuda, Sam Harless">
         <meta name="description" content="This page is the homepage for UVPlays">
         <meta name="keywords" content="UVA, crossword, game">

         <meta property="og:title" content="UVPlays">
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>     
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        
         
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
                      <a class="nav-link" href="welcome.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="wordle.php">Daily Wordle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="quiz.php">Daily Quiz</a>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link" href="leaderboard.php">Leaderboard</a>
                    </li>  
                                       
                  </ul>

                  <div class="navbar-nav mx-auto">
                    <span class="text-light middleTitle">UVPlay</span>
                  </div>

                  <div class="navbar-nav ml-auto">
                    <div class = "profile-picture mr-2">
                        <img src="monkey.jpg" alt="Profile Picture">
                    </div>
                    <span class = "mr-2 user-name text-light">NAME HERE</span>
                    <button class = "btn btn-primary login-button" id = "loginclick">
                        <span class = "login-button-text">Login</span>
                    </button>
                    </div>
                  
                </div>
            </nav>
            <!--
	        <div class = "row justify-content-between align-items-center py-3">
                <div class = "col-auto">
                    <h1>
                        UVPlays
                    </h1>
                </div>
                <div class = "col-auto d-flex align-items-center">
                    <div class = "profile-picture mr-2">
                        <img src="monkey.jpg" alt="Profile Picture">
                    </div>
                    <span class = "mr-2 user-name">NAME HERE</span>
                    <button class = "btn btn-primary login-button">
                        <span class = "login-button-text">Login</span>
                    </button>
                </div>
            </div>
        -->
        </header>
        <div class = "container-main">
            <div class="container">
                <section class="section">
                    <img src="crossword.jpg" width="300" alt="Crossword" class="same-size-image">
                    <h2><a href="quiz.php" style="color:rgb(0, 0, 0); text-decoration: underline;">Crossword</a></h2>
                </section>
                <section class="section">
                    <img src="wordle.jpg" width="300" alt="Wahoo Word" class="same-size-image">
                    <h2><a href="wordle.php" style="color:rgb(0, 0, 0); text-decoration: underline;">Wahoo Word</a></h2>
                </section>
                <section class="section">
                    <img src="lightbulb.jpg" width="300" alt="Random" class="same-size-image">
                    <h2><a href="quiz.php" style="color:rgb(0, 0, 0); text-decoration: underline;">Quiz</a></h2>
                </section>
            </div>
        </div>
	    <footer class = "footer">
	        <p>
	            <small>All Rights Reserved. Designed by Bryson Matsuda and Sam Harless</small>
	        </p>
        </footer>
        <script>
            document.getElementById("loginclick").onclick = function(){
                window.location.href = "login.php";
            };
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
 </html>