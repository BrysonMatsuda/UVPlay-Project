<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/main.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>     
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        
        <title>Leaderboard</title>
    
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
                      <a class="nav-link" href="?command=showwordle">Daily Wordle<span class = "sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?command=showquiz">Daily Quiz</a>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link" href="?command=showleaderboard">Leaderboard<span class = "sr-only">(current)</span></a>
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

            <div class="dropdownDiv">
               
                <select id="myDropdown" name="options" aria-label="Choose a game option to display its leaderboard">
                    <option value="option1">Daily Quiz</option>
                    <option value="option2">Daily Crossword</option>
                    <option value="option3">Daily Wordle</option>
                    
                </select>
            </div>

            
            <?php if(isset($message) && !empty($message)){?>
            <div class="alert alert-info" role="alert"><?php echo $message; ?></div>
            <?php } ?>
            <div class="leaderboardHeading">
                <h2 class="leaderboardText2">Today's Wordle Leaderboard</h2>
            </div>
            <div class="leaderboard-container">
                <table>
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Name</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($scoresArray as $row){?>
                        <tr>
                            <td class="text-light lbentry"><?php echo $row["rank"] ?></td>
                            <td class="text-light lbentry"><?php echo $row["name"] ?></td>
                            <td class="text-light lbentry"><?php echo $row["score"] ?></td>
                        </tr>
                        <?php } ?>
                        <!-- Add more entries here -->
                    </tbody>
                </table>
            </div>
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