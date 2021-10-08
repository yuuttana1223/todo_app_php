<?php

declare(strict_types=1);

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
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      PDO::ATTR_EMULATE_PREPARES => false,
    ]
  );
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}

function getTodos(PDO $pdo): array
{
  $stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
  $todos = $stmt->fetchAll();
  return $todos;
}

$todos = getTodos($pdo);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>My Todos</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <h1>Todos</h1>
  <ul>
    <li>
      <input type="checkbox">
      <span>Title</span>
    </li>
    <li>
      <input type="checkbox" checked>
      <span class="done">Title</span>
    </li>
    <li>
      <input type="checkbox">
      <span>Title</span>
    </li>
  </ul>
</body>

</html>