<?php

// require_once("../app/config.php");
// 絶対パス推奨
require_once(__DIR__ . "/../app/config.php");

use MyApp\Database, MyApp\Todo, MyApp\Utils;

$pdo = Database::getInstance();

$todo = new Todo($pdo);
$todo->processPost();
$todos = $todo->getAll();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>My Todos</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <main data-token="<?= Utils::h($_SESSION["token"]) ?>">
    <header>
      <h1>Todos</h1>
      <span class="purge">Purge</span>
    </header>
    <form>
      <input type="text" name="title" placeholder="Type new todo. ">
    </form>
    <ul>
      <?php foreach ($todos as $todo) : ?>
        <li data-id="<?= Utils::h($todo->id) ?>">
          <input type="checkbox" <?= $todo->is_done ? "checked" : ""; ?>>
          <span><?= Utils::h($todo->title); ?></span>
          <span class="delete">削除</span>
        </li>
      <?php endforeach; ?>
    </ul>
    <script src="js/main.js"></script>
  </main>
</body>

</html>