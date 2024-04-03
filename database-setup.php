<?php

    // Note that these are for the local Docker container
    $host = "db";
    $port = "5432";
    $database = "example";
    $user = "localuser";
    $password = "cs4640LocalUser!"; 

    $dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

    if ($dbHandle) {
        echo "Success connecting to database";
    } else {
        echo "An error occurred connecting to the database";
    }

    // Drop tables and sequences (that are created later)
    $res  = pg_query($dbHandle, "drop table if exists users;");
    if ($res === false) {
        echo "Query failed: " . pg_last_error($connection);
    } 
    $res  = pg_query($dbHandle, "drop sequence if exists user_seq;");
    if ($res === false) {
        echo "Query failed: " . pg_last_error($connection);
    } 
    
    /*
    $res = pg_query($dbHandle, "drop table if exists wordle_words");
    if ($res === false) {
        echo "Query failed: " . pg_last_error($connection);
    } */
   

    // Create sequences
    $res  = pg_query($dbHandle, "create sequence user_seq;");
    if ($res === false) {
        echo "Query failed: " . pg_last_error($connection);
    } 
    //wordle
    $res = pg_query($dbHandle, "create sequence if not exists wordle_words_seq");
    if ($res === false) {
        echo "Query failed: " . pg_last_error($connection);
    } 
    // Create tables
    $res  = pg_query($dbHandle, "create table users (
            id  int primary key default nextval('user_seq'),
            name text,
            password text,
            score int);");
    if ($res === false) {
        echo "Query failed: " . pg_last_error($connection);
    } 

    //wordle
    $res = pg_query($dbHandle, "CREATE TABLE IF NOT EXISTS wordle_words (
                                    id INT PRIMARY KEY DEFAULT nextval('wordle_words_seq'),
                                    word VARCHAR(255) NOT NULL,
                                    date VARCHAR(255) NOT NULL);"); //date can be annoying in SQL so just going to use a string for the date instead - i think it will be much easier

    if ($res === false) {
        echo "Query failed: " . pg_last_error($connection);
    } 

    $table_empty_query = "SELECT COUNT(*) FROM wordle_words";
    $table_empty_result = pg_query($dbHandle, $table_empty_query);
    if ($table_empty_result === false) {
        echo "Query failed: " . pg_last_error($connection);
    } 
    $table_empty_row = pg_fetch_row($table_empty_result);
    if ($table_empty_row === false) {
        echo "Query failed: " . pg_last_error($connection);
    } 

    if ($table_empty_row[0] == 0) {
        //table is empty - insert the wordle words!!!
        echo("inserting!");
        $wordList = [
            "Jefferson",
            "Cavaliers",
            "Bennet",
            "Wahoos",
            "Grounds",
            "Legacy",
            "Honor",
            "Monticello",
            "Cville",
            "Rotunda",
            "Corner",
            "Alumni",
            "History",
            "Tradition",
            "Education",
            "Thomas",
            "Columns",
            "Brick",
            "Arts",
            "Engagement",
            "Ohill",
            "runk", 
            "Newcomb", 
            "Lawn", 
            "Tundy", 
            "Memorial",
            "Ampitheater",
            "Corner",
            "Dillard", 
            "Kihei", 
            "McCormick", 
            "Graduation",
        ];
        
        for($i=0;$i<count($wordList);$i++){
            $dateString = date("Y-m-d" ,strtotime("+$i day"));
            $res = pg_query("INSERT INTO wordle_words (word, date) VALUES ('{$wordList[$i]}', '$dateString')");
            if ($res === false) {
                echo "Query failed: " . pg_last_error($connection);
            } 
            //$this->db->query("INSERT INTO users (name, password) VALUES ($1, $2);", $name, $hashedPassword);
        }
    } else {
        echo "wordle_words table is already filled!";
    }
    // Read json and insert the trivia questions into the database, assuming
    // the trivia-s24.json file is in the same directory as this script.
    // $questions = json_decode(
    //     file_get_contents("trivia-s24.json"), true);

    // $res = pg_prepare($dbHandle, "myinsert", "insert into questions (question, answer) values 
    // ($1, $2);");
    // foreach ($questions as $q) {
    //         $res = pg_execute($dbHandle, "myinsert", [$q["question"], $q["answer"]]);
    // }
