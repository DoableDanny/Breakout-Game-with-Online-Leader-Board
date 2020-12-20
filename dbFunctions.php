<?php

// DB cofig and connect for development only
// include 'dbConfigDev.php';

// DB config and connect for Heroku deployment only
include 'dbConfigHeroku.php';

if(!$conn) {
    echo "Connection error: " . mysqli_connect_error();
}

// Get 1 user and score from db
function getUser($name) {
    global $conn;
    $name = mysqli_real_escape_string($conn, $name);
    $sql = "SELECT name, score FROM leaderboard WHERE name='$name'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user;
}

// Get all users and scores from db
function getAllScores() {
    global $conn;
    $sql = 'SELECT name, score FROM leaderboard ORDER BY score DESC';
    $result = mysqli_query($conn, $sql);
    $scores = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $scores;
}

// Save users high score to db
function saveScore($name, $score) {
    global $conn;
    $name = mysqli_real_escape_string($conn, $name);
    $score = mysqli_real_escape_string($conn, $score);
    $sql = "INSERT INTO leaderboard(name, score) VALUES('$name', '$score')";
    
    if(!mysqli_query($conn, $sql)) {
        echo "Couldn't save to database: " . mysqli_error($conn);
    }
}

// Update users high score in db
function updateScore($name, $score) {
    global $conn;
    $name = mysqli_real_escape_string($conn, $name);
    $score = mysqli_real_escape_string($conn, $score);
    $sql = "UPDATE leaderboard SET score = '$score' WHERE name = '$name'";

    if(!mysqli_query($conn, $sql)) {
        echo "Couldn't update score in database: " . mysqli_error($conn);
    }
}

?>