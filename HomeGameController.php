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
            case "showwelcome":
                $this->showWelcomePage();
                break;
            case "showleaderboard":
                $this->showLeaderboard();  
                break;
            case "logout":
                $this->sessionDestroyer();
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

    public function showWordle(){
        $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "Name Here";
        include("wordle.php");
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
                    setcookie("username", $name, time() + 3600, "/");
                    $this->showWelcomePage();
                } else {
                    echo("Please enter a valid password! Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.");
                    include("login.php");
                }
            }
            else{
                echo("Please enter a username and password!");
                include("login.php");
            }
        }
        else{
            echo("Please enter a username and password!");
            include("login.php");
        }
    }

}



























