<?php
// Connecting to development database using variables from .env file.

require_once("vendor/autoload.php");
// Load in DB connection vars
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connect to db
$conn = mysqli_connect($_ENV['HOST'], $_ENV['USERNAME'], $_ENV['PW'], $_ENV['DB']);

?>