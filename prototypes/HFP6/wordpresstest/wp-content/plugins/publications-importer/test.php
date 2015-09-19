<?php
$servername = "www-db.inesc-id.pt";
$username = "dblist";
$password = "db2004ac1";

echo "Start \n";
try {
	echo "PDO Start \n";
    $conn = new PDO("mysql:host=$servername;dbname=INESC", $username, $password);
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