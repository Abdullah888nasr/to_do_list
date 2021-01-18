<?php 

    $dsn = "mysql:host=localhost;dbname=to_do_list";
    $username="root";
    $password = '';
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
    );

    try {
        $con = new PDO($dsn, $username, $password, $option);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        echo 'Connection is failed ' . $e->getMessage();
    }