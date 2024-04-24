<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/main.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

        <!-- JQUERY -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src = "quizJS.js"></script>
    
        <title>Daily Quiz</title>
        <script>

            var quizGame = new QuizController();

            

            const url ="index.php?command=getjsonquiz";
            $.ajax({
                url:url,
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    quizGame.question = response.question;
                    quizGame.answers = response.answers;
                    quizGame.currentAnswersLeft = response.answers;
                    quizGame.totalTimeForQuiz = response.timeInSeconds;
                    quizGame.timeLeft = response.timeInSeconds;
                    
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                    alert('Error connecting to the server.');
                }
            })

            function startGame(){

                $("#questionText").removeClass("doNotShow");
                $("#questionText").text(quizGame.question);

                $("#startGameButton").removeClass("btn"); //just had to take out this class bc the below line was not working bc btn added the class display: inlineblock
                $("#startGameButton").addClass("doNotShow");


                //build the table to have a size based on the number of answers in the quiz
                quizGame.buildTable();



                //do stuf with timer?
                $(".timerText").removeClass("doNotShow");
                updateTimerUI();

                //https://www.w3schools.com/js/js_timing.asp
                quizGame.timerVar = setInterval(timerTick, 1000);



                $('#inputBox').on('input', () => {
                    console.log('Input changed to: ' + $('#inputBox').val());
                    quizGame.processGuess($('#inputBox').val());
                });


            }

            function timerTick(){
                quizGame.timeLeft--;
                if(quizGame.timeLeft <= 0){ //TIMES UP
                    timesUp();
                }
                updateTimerUI();
            }

            function updateTimerUI(){

                let minutes = parseInt(quizGame.timeLeft / 60);
                let seconds = parseInt(quizGame.timeLeft % 60);
                if(seconds >= 0 && seconds <= 9){
                    seconds ="0" +seconds;
                }

                $(".timerText").text(""+minutes+":"+seconds);

            }

            function timesUp(){
                //ok so the player ran out of time what should happen?

                //stop the timer
                clearInterval(quizGame.timerVar);

                //show them the answers that they did not get?
                quizGame.gameOverShowCorrectAnswers();

                $("#message").text("You ran out of time! See the other correct answers below in red!");
                $("#message").removeClass("doNotShow");
                $("#message").addClass("alert-danger");

                //turn off answering?
            }

            

            
            
        </script>
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
                        <a class="nav-link" href="?command=showquiz">Daily Quiz<span class = "sr-only">(current)</span></a>
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
            <div id="message" class="alert doNotShow" role="alert"></div>
            <button id="startGameButton" type="button" class="btn btn-primary">Start Quiz</button>
            <div class="topContainerBar ">
                <div class="questionBox">
                    <h3 id="questionText" class="questionText doNotShow"></h3>
                </div> 

                <div class="timerBox">
                    <h3 class="timerText doNotShow"></h3>
                </div>
            </div>

            <div class="inputBoxDiv">
                <input id="inputBox" type="text" class="inputBox" placeholder="Enter Answers Here...">
            </div>

            <div class="tableDiv">
                <table id="gameTable">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
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

        <script>
            $("#startGameButton").click(() => {  // arrow fnction
                startGame();
            });
        </script>
    </body>
</html>