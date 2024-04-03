<?php

class HomeGameController{

    private $db;
    public function __construct($input) {
        session_start();
        $this->input = $input;
        $this->db = new Database();
        //get words from an api/json, or somewhere else
    }

    public function run(){
        $command = "none";
        if (isset($this->input["command"])){
            $command = $this->input["command"];
        }

        switch($command){
            case "postwelcome":
                $this->checkPostedInfo();
                break;
            case "showwordle":
                $this->showWordle();
                break;
            case "showcrossword":
                $this->showCrossword();
                break;
            case "showquiz":
                $this->showQuiz();
                break;
            case "showlogin":
                $this->showLogin();
                break;
            case "showwelcome":
                $this->showWelcomePage();
                break;
            case "showleaderboard":
                $this->showLeaderboard();  
                break;
            case "logout":
                $this->sessionDestroyer();
            case "showprofile":
                $this->showProfile();
                break;
            case "editdetails":
                $this->editDetails();
                break;
            case "checkstats":
                $this->checkStats();
                break;
            case "showdetails":
                $this->showDetails();
                break;
            case "wordlesubmitguess":
                $this->wordleSubmitGuess();
                break;
            case "viewwordleleaderboard":
                $this->viewWordleLeaderboard();
                break;
            default:
                $this->showWelcomePage();
                break;
        }
    }

    public function sessionDestroyer(){
        session_destroy();
        header("Location: index.php");
        session_start();
        exit();
    }

    public function showProfile(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";
        include("profile.php");
    }

    public function showDetails(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";
        include("editprofile.php");
    }

    public function editDetails(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";
        $currentUsername = $name;
        $currentPassword = isset($_SESSION["password"]) ? $_SESSION["password"] : "";
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newUsername = isset($_POST["newUsername"]) ? $_POST["newUsername"] : $currentUsername;
            $newPassword = isset($_POST["newPassword"]) ? $_POST["newPassword"] : $currentPassword;
    
            $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
    
            $usernameChanged = $newUsername !== $currentUsername;
            $passwordChanged = $newPassword !== $currentPassword;
    
            if ($usernameChanged || $passwordChanged) {
                if ($passwordChanged && !preg_match($password_pattern, $newPassword)) {
                    echo "<script>alert('Password must contain at least one lowercase letter, one uppercase letter, one digit, and be at least 8 characters long.');</script>";
                } else {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    $result = $this->db->query("UPDATE users SET name = $1, password = $2 WHERE name = $3", $newUsername, $hashedPassword, $currentUsername);
    
                    if ($result !== false) {
                        if (count($result) > 0) {
                            $_SESSION["name"] = $newUsername;
                            $_SESSION["password"] = $hashedPassword;
                            echo "<script>alert('Details updated successfully!');</script>";
                        } else {
                            echo "<script>alert('No rows affected.');</script>";
                        }
                    } else {
                        echo "<script>alert('Error occurred during update.');</script>";
                    }
                }
            } else {
                echo "<script>alert('No changes were made.');</script>";
            }
        }
    
        include("editprofile.php");
    }

    public function checkStats(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";
        include("checkstats.php");
    }

    public function showWelcomePage(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";
        include("welcome.php");
    }

    public function showLeaderboard(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";
        include("leaderboard.php");
    }




    public function showWordle($errorMessage=""){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";

        if(isset($_SESSION["wordleVictory"])){
            if($_SESSION["wordleVictory"]){
                $this->showWordleVictory();
                exit();
            }
        }

        if(isset($_SESSION["wordleLoss"])){
            if($_SESSION["wordleLoss"]){
                $this->showWordleLoss();
                exit();
            }
        }

        
        if(isset($_SESSION["name"])){
            $res = $this->db->query("SELECT * FROM users WHERE name = $1;", $_SESSION["name"]);
            $user_id = $res[0]["id"];
            //echo $user_id;
        
            $dateString=date('Y-m-d',strtotime("Today"));
            $res = $this->db->query("SELECT * FROM wordle_scores where user_id = $1 AND date=$2;", $user_id, $dateString);

            if(count($res)){
                $this->viewWordleLeaderboard();
            }
        }

        if(!isset($_SESSION["wordleWord"])){
            //$_SESSION["wordleWord"] = "TUNDY";//maybe load this from the database in the future
            $dateString=date('Y-m-d',strtotime("Today"));
            //echo $dateString ; 
            $res = $this->db->query("SELECT * FROM wordle_words WHERE date = $1;", $dateString);
            //var_dump($res);
            $_SESSION["wordleWord"] = $res[0]["word"];
            $_SESSION["wordleDate"] = $dateString;
            
        }

        $word = $_SESSION["wordleWord"];

        $wordLength = strlen($word);

        $guessArray = isset($_SESSION["wordleGuessArray"]) ? $_SESSION["wordleGuessArray"] : array();

        include("wordle.php");
    }




    public function wordleSubmitGuess(){
        
        $guessString="";
        $errorMessage="";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            foreach ($_POST as $key => $value) {
                
                if(empty($value)){
                    $errorMessage="Invalid Guess: You must enter a letter in every spot.";
                    $this->showWordle($errorMessage);
                    exit();
                }
                elseif(!preg_match('/^[A-Za-z]+$/', $value)){
                    $errorMessage="Invalid Guess: You must only enter letters A-Z.";
                    $this->showWordle($errorMessage);
                    exit();
                }
                else{
                    $guessString = $guessString . $value;
                }
                
            }

        } 

        if(!isset($_SESSION["wordleGuessArray"])){ //this is the first guess - instantiate the guess array
            $_SESSION["wordleGuessArray"] = array();
        }

        $_SESSION["wordleGuessArray"][] = $guessString;

        if(strtoupper($guessString) == strtoupper($_SESSION["wordleWord"])){ //correct guess!
            $this->showWordleVictory();
            exit();
        }
        elseif(count($_SESSION["wordleGuessArray"]) >=6){
            $this->showWordleLoss();
        }
        else{
            $this->showWordle();
            exit();
        }
    }




    public function showWordleVictory(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";

        $_SESSION["wordleVictory"] = true;

        if(!isset($_SESSION["wordleWord"])){
            //$_SESSION["wordleWord"] = "TUNDY";//maybe load this from the database in the future
            $dateString=date('Y-m-d',strtotime("Today"));
            //echo $dateString ; 
            $res = $this->db->query("SELECT * FROM wordle_words WHERE date = $1;", $dateString);
            //var_dump($res);
            $_SESSION["wordleWord"] = $res[0]["word"];
            $_SESSION["wordleDate"] = $dateString;
            
        }

        $word = $_SESSION["wordleWord"];

        $wordLength = strlen($word);

        $guessArray = isset($_SESSION["wordleGuessArray"]) ? $_SESSION["wordleGuessArray"] : array();

        $victoryMessage = "You won! You correctly guessed todays wordle in " . count($guessArray) . " guesses!";
        $user_id = 0;
        if(isset($_SESSION["name"])){
            $res = $this->db->query("SELECT * FROM users WHERE name = $1;", $_SESSION["name"]);
            $user_id = $res[0]["id"];
            //echo $user_id;
        }
        $res = $this->db->query("INSERT INTO wordle_scores (user_id, score, date) VALUES ($1, $2, $3)", $user_id, count($guessArray), $_SESSION["wordleDate"] );

        include("wordlevictory.php");
    }

    public function showWordleLoss(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";
        $_SESSION["wordleLoss"] = true;

        if(!isset($_SESSION["wordleWord"])){
            //$_SESSION["wordleWord"] = "TUNDY";//maybe load this from the database in the future
            $dateString=date('Y-m-d',strtotime("Today"));
            //echo $dateString ; 
            $res = $this->db->query("SELECT * FROM wordle_words WHERE date = $1;", $dateString);
            //var_dump($res);
            $_SESSION["wordleWord"] = $res[0]["word"];
            $_SESSION["wordleDate"] = $dateString;
            
        }

        $word = $_SESSION["wordleWord"];

        $wordLength = strlen($word);

        $guessArray = isset($_SESSION["wordleGuessArray"]) ? $_SESSION["wordleGuessArray"] : array();

        $lossMessage = "You Lost :( ... Today's Wordle was $word";
        $user_id = 0;
        if(isset($_SESSION["name"])){
            $res = $this->db->query("SELECT * FROM users WHERE name = $1;", $_SESSION["name"]);
            $user_id = $res[0]["id"];
            //echo $user_id;
        }
        $res = $this->db->query("INSERT INTO wordle_scores (user_id, score, date) VALUES ($1, $2, $3)", $user_id, 7, $_SESSION["wordleDate"] );

        include("wordleloss.php");
    }


    public function showCrossword(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";
        include("/put file for crossword here");
    }

    public function showQuiz(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";
        include("quiz.php");
    }

    public function showLogin(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";
        include("login.php");
    }

    public function checkPostedInfo(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(!empty($_POST["name"]) && !empty($_POST["password"])){
                $_SESSION["name"] = $_POST["name"];
                $_SESSION["password"] = $_POST["password"];
                $name = $_SESSION["name"];
                $password = $_SESSION["password"];
                $validPassword = false;
    
                $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
                if (preg_match($password_pattern, $password) && $password != null) {
                    $validPassword = true;
                }
    
                if($validPassword) {
                    $res = $this->db->query("SELECT * FROM users WHERE name = $1;", $name);
    
                    if(!empty($res)){
                        // If user exists, verify the password
                        $storedPassword = $res[0]["password"];
                        if(password_verify($password, $storedPassword)){
                            $_SESSION["name"] = $name;
                            setcookie("username", $name, time() + 3600, "/");
                            $this->showWelcomePage();
                        } else {
                            //Password doesn't match
                            echo "Incorrect password.";
                            include("login.php");
                        }
                    } else {
                        // User doesn't exist, add user to the database
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $this->db->query("INSERT INTO users (name, password) VALUES ($1, $2);", $name, $hashedPassword);
                        $_SESSION["name"] = $name;
                        setcookie("username", $name, time() + 3600, "/");
                        $this->showWelcomePage();
                    }
                } else {
                    echo("Please enter a valid password! Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.");
                    include("login.php");
                }
            } else {
                echo("Please enter a username and password!");
                include("login.php");
            }
        } else {
            echo("Please use POST method.");
            include("login.php");
        }
    }




    public function viewWordleLeaderboard(){
        if(!isset($_SESSION["wordleWord"])){
            //$_SESSION["wordleWord"] = "TUNDY";//maybe load this from the database in the future
            $dateString=date('Y-m-d',strtotime("Today"));
            //echo $dateString ; 
            $res = $this->db->query("SELECT * FROM wordle_words WHERE date = $1;", $dateString);
            //var_dump($res);
            $_SESSION["wordleWord"] = $res[0]["word"];
            $_SESSION["wordleDate"] = $dateString;
            
        }

        $res = $this->db->query("SELECT s.score, u.name FROM wordle_scores s JOIN users u ON s.user_id = u.id WHERE date=$1 ORDER BY score ASC LIMIT 10;", $_SESSION["wordleDate"]);

        $scoresArray = $res;
        

        $rank = 1; 
        $prevScore = null; // Keep track of the previous score for tie detection
        $prevRank = null;
        $skip = 0; // Skip count for tied ranks

        foreach ($scoresArray as $key => &$item) {
            
            if($item["score"]==$prevScore){
                $item["rank"]=$prevRank;
                
            }
            else{
                $item["rank"]=$rank;
            }
            $rank++;
            $prevScore = $item["score"];
            $prevRank = $item["rank"];
        }



        $message="";
        if(isset($_SESSION["name"])){
            $res = $this->db->query("SELECT * FROM users WHERE name = $1;", $_SESSION["name"]);
            $user_id = $res[0]["id"];
            //echo $user_id;
        
            $dateString=date('Y-m-d',strtotime("Today"));
            $res = $this->db->query("SELECT * FROM wordle_scores where user_id = $1 AND date=$2;", $user_id, $dateString);

            
            if(count($res)){
                if($res[0]["score"]==7){
                    $message="You lost todays wordle...";
                }else{
                    $message = "Your score on todays Wordle: {$res[0]["score"]}";
                }

            }
        }
        
        //var_dump($scoresArray);
        include("wordleleaderboard.php");
        exit();
    }
}
























