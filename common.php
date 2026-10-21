<?php
try {
    $dsn = 'mysql:host=HOSTNAME;dbname=DBNAME;charset=utf8mb4';
    $username = USERNAME;
    $password = PASSWORD;
    
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Database connection established successfully.";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}

?>