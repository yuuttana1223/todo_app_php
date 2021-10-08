<?php
const DSN = "mysql:host=db;dbname=myapp;charset=utf8mb4";
const DB_USER = "myappuser";
const DB_PASS = "myapppass";

try {
  $pdo = new PDO(
    DSN,
    DB_USER,
    DB_PASS,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]
  );
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>My Todos</title>
</head>

<body>
  <h1>Todos</h1>
</body>

</html>