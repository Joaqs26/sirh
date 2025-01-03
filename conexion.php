<?php
$password = "630545";
$username = "postgres";
$dbname = "produc_prod";
$host = "localhost";
$port = "5432";
$options = "--client_encoding=UTF8";

try {
    $connectionDB = "host=$host port=$port dbname=$dbname user=$username password=$password options=$options";
    $connectionDBsPro = pg_pconnect($connectionDB);
} catch (\Throwable $e) {
    echo "Error connecting to data base + " . $e;
}

/// Connection to server
/*
$password = "sirh2024";
$username = "postgres";
$dbname = "sirh";
$host = "localhost";
$port = "5432";
$options = "--client_encoding=UTF8";
*/





