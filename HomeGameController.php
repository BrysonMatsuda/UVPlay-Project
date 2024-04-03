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


























