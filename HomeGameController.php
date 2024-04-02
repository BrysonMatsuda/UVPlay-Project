<?php

class HomeGameController{
    public function __construct($input) {
        session_start();
        $this->input = $input;
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
            default:
                $this->showWelcomePage();
                break;
        }
    }

    public function sessionDestroyer(){
        session_destroy();
        header("Location: index.php");
        exit();
    }

    public function showWelcomePage(){
        include("welcome.php");
    }

    public function showWordle(){
        $word = "TUNDY"; //maybe load this from the database in the future

        $wordLength = strlen($word);

        $firstGuess = false;

        if(!isset($_SESSION["wordleGuessHistory"])){ //current user has not started this game - so show the starting point of the game
            $firstGuess = true;
        }
        else{ //user has already started the game - so show the table with the guesses populated

        }

        $empty = "";
        
        $guessArray = ["angie", "fives", "tndya", "TUNDY"];

        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";

        include("wordle.php");
    }

    public function showCrossword(){
        include("/put file for crossword here");
    }

    public function showQuiz(){
        include("quiz.php");
    }

    public function showLogin(){
        include("login.php");
    }

    public function checkPostedInfo(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            if(!empty($_POST["name"]) && !empty($_POST["password"])){
                $_SESSION["name"] = $_POST["name"];
                $_SESSION["password"] = $_POST["password"];
                $this->showWelcomePage();
            }
            else{
                echo("Please enter a username and password!");
                include("welcome.php");
            }
        }
        else{
            echo("Please enter a username and password!");
            include("welcome.php");
        }
    }
}


























