<?php
$servername = "www-db.xxxxx-xx.pt";
$username = "xxxxxx";
$password = "xxxxxxxxx";

echo "Start \n";
try {
	echo "PDO Start \n";
    $conn = new PDO("mysql:host=$servername;dbname=XXXXX", $username, $password);
    echo "PDO Ok \n";
    // set the PDO error mode to exception
    echo "Connection Start \n";
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully \n";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage() . "\n";
    }
echo "Done \n";
?>