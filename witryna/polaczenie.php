<?php
    $typ = 'mysql';
    $serwer = 'localhost';
    $db = 'wypozyczalnia';
    $port = '3306';
    $kodowanie = 'utf8mb4';

    $uzytkownik = 'Tomasz';
    $haslo = 'projekt.123';

    $opcje = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $dsn = "$typ:host=$serwer;dbname=$db;port=$port;charset=$kodowanie";
    try {
        $pdo = new PDO($dsn, $uzytkownik, $haslo, $opcje);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), $e->getCode());
    }
   