<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/wordle.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
        
        <title>Daily Wordle</title>
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
                        <a class="nav-link" href="?command=showleaderboard">Leaderboard</a>
                    </li>  
                                       
                  </ul>

                  <div class="navbar-nav mx-auto">
                    <span class="text-light middleTitle">UVPlay</span>
                  </div>

                  <div class="navbar-nav ml-auto">
                    <div class = "profile-picture mr-2">
                        <img src="pp.jpg" alt="Profile Picture">
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
            
            <?php if(!empty($errorMessage)){ ?>
                <div class="alert alert-danger" role="alert"><?php echo $errorMessage; ?></div>
            <?php } ?>
            <div class="wordle-container">
                <div>
                    <?php for($numGuessesCounter=0; $numGuessesCounter < 6; $numGuessesCounter++){  ?> 
                    
                    <div class="wordle-row">
                        
                        <?php for($wordLengthCounter=0; $wordLengthCounter < $wordLength; $wordLengthCounter++){  ?> 
                        <div class="wordle-cell" style="background-color: <?php if(isset($guessArray[$numGuessesCounter])){if(strtoupper($guessArray[$numGuessesCounter][$wordLengthCounter]) == strtoupper($word[$wordLengthCounter])){ echo 'green';}elseif(strpos(strtoupper($word), strtoupper($guessArray[$numGuessesCounter][$wordLengthCounter])) != false){echo 'yellow';}else{echo 'darkgray';}}else{ echo 'initial';}?>;"><?php if(isset($guessArray[$numGuessesCounter])){ echo strtoupper($guessArray[$numGuessesCounter][$wordLengthCounter]);}?></div>
                        <?php } ?>
                    </div>
                    
                    <?php }?>
                    
                    <form action="?command=wordlesubmitguess" method="post">
                        <div class="guess-container">
                            <?php for($wordLengthCounter2=0; $wordLengthCounter2 < $wordLength; $wordLengthCounter2++){  ?> 
                            <input type="text" maxlength="1" class="guess-box" name="wordleInput<?php echo $wordLengthCounter2 ?>">
                            <?php } ?>
                        </div>
                        <button type="submit" class="btn btn-primary" id="wordleSubmitButton">Submit Guess</button>
                    </form>
                    <script>
                        //i took CS 3240 so have some memory of how to use JS event listeners
                        document.querySelectorAll('.guess-box').forEach((box, index, boxes) => { //query selctor returns a list of elements with the class. Then for each loops over the whole list, where box is the current elememt, index is the index of the current element, and boxes is the whole arrya. 
                            box.addEventListener('input', () => {
                                if (box.value.length && index < boxes.length - 1) { //if box has a letter and its not the last box 
                                    boxes[index + 1].focus(); //puts keyboard input into the next box
                                }
                            });

                            box.addEventListener('keydown', (event) => { // similar thing, if you press backspace it takes you to the previous box
                                if (event.key === 'Backspace' && box.value.length === 0 && index > 0) {
                                    boxes[index - 1].focus();
                                }
                            });

                        });
                    </script>

                </div>
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





