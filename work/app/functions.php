<?php



function createToken(): void
{
  if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(32));
  }
}

function validateToken(): void
{
  if (empty($_SESSION["token"]) || $_SESSION["token"] !== filter_input(INPUT_POST, "token")) {
    exit("Invalid post request");
  }
}

function getPdoInstance(): PDO
{
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
    return $pdo;
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  }
}

function addTodo(PDO $pdo): void
{
  $title = trim(filter_input(INPUT_POST, "title"));
  if ($title === "") {
    return;
  }

  $stmt = $pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
  $stmt->bindValue("title", $title, PDO::PARAM_STR);
  $stmt->execute();
}

function toggleTodo(PDO $pdo): void
{
  $id = filter_input(INPUT_POST, "id");
  if (empty($id)) {
    return;
  }
  $stmt = $pdo->prepare("UPDATE todos SET is_done = NOT is_done WHERE id = :id");
  $stmt->bindValue("id", $id, PDO::PARAM_INT);
  $stmt->execute();
}

function deleteTodo(PDO $pdo): void
{
  $id = filter_input(INPUT_POST, "id");
  if (empty($id)) {
    return;
  }
  $stmt = $pdo->prepare("DELETE FROM todos WHERE id = :id");
  $stmt->bindValue("id", $id, PDO::PARAM_INT);
  $stmt->execute();
}

function getTodos(PDO $pdo): array
{
  $stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
  $todos = $stmt->fetchAll();
  return $todos;
}
