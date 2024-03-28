<?php
     $pdo = new PDO('mysql:dbname=ulht_sin;host=mysql', 'ULHT_SIN', 'password', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
     $query = $pdo->query('SHOW VARIABLES like "version"'); 

     $row = $query->fetch();

     echo 'MySQL version:' . $row['Value'];
?>
