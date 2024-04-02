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
    $res  = pg_query($dbHandle, "drop sequence if exists user_seq;");
    $res  = pg_query($dbHandle, "drop table if exists users;");

    // Create sequences
    $res  = pg_query($dbHandle, "create sequence user_seq;");

    // Create tables
    $res  = pg_query($dbHandle, "create table users (
            id  int primary key default nextval('user_seq'),
            name text,
            email text,
            password text,
            score int);");

    // Read json and insert the trivia questions into the database, assuming
    // the trivia-s24.json file is in the same directory as this script.
    // $questions = json_decode(
    //     file_get_contents("trivia-s24.json"), true);

    // $res = pg_prepare($dbHandle, "myinsert", "insert into questions (question, answer) values 
    // ($1, $2);");
    // foreach ($questions as $q) {
    //         $res = pg_execute($dbHandle, "myinsert", [$q["question"], $q["answer"]]);
    // }