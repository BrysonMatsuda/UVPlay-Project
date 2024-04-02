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
                break;
            case "wordlesubmitguess":
                $this->wordleSubmitGuess();
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

        if(!isset($_SESSION["wordleWord"])){
            $_SESSION["wordleWord"] = "TUNDY";//maybe load this from the database in the future
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
        else{
            $this->showWordle();
            exit();
        }
    }




    public function showWordleVictory(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";

        if(!isset($_SESSION["wordleWord"])){
            $_SESSION["wordleWord"] = "TUNDY";//maybe load this from the database in the future
        }

        $word = $_SESSION["wordleWord"];

        $wordLength = strlen($word);

        $guessArray = isset($_SESSION["wordleGuessArray"]) ? $_SESSION["wordleGuessArray"] : array();

        $victoryMessage = "You won! You correctly guessed todays wordle in " . count($guessArray) . " guesses!";

        include("wordlevictory.php");
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

}


























