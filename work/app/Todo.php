<?php

namespace MyApp;

use PDO;

class Todo
{
  private $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
    Token::create();
  }

  public function processPost(): void
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      Token::validate();

      $action = filter_input(INPUT_GET, "action");

      switch ($action) {
        case "add":
          $id = $this->add();
          header("Content-Type: application/json");
          echo json_encode(["id" => $id]);
          break;
        case "toggle":
          $isDone = $this->toggle();
          header("Content-Type: application/json");
          echo json_encode(["isDone" => $isDone]);
          break;
        case "delete":
          $this->delete();
          break;
        case "purge":
          $this->purge();
          break;

        default:
          exit;
      }
      exit;
    }
  }

  private function add(): int
  {
    $title = trim(filter_input(INPUT_POST, "title"));
    if ($title === "") {
      return -1;
    }

    $stmt = $this->pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
    $stmt->bindValue("title", $title, PDO::PARAM_STR);
    $stmt->execute();
    return (int) $this->pdo->lastInsertId();
  }

  private function toggle(): bool
  {
    $id = filter_input(INPUT_POST, "id");
    if (empty($id)) {
      return false;
    }
    $stmt = $this->pdo->prepare("SELECT * FROM todos WHERE id = :id");
    $stmt->bindValue("id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $todo = $stmt->fetch();
    if (empty($todo)) {
      // header("HTTP/1.1 404 Not Found");
      header("HTTP", true, 404); // HTTP status code
      exit;
    }

    $stmt = $this->pdo->prepare("UPDATE todos SET is_done = NOT is_done WHERE id = :id");
    $stmt->bindValue("id", $id, PDO::PARAM_INT);
    $stmt->execute();
    // mysqlの真偽値は0, 1で管理されているため
    return (bool) !$todo->is_done;
  }

  private function delete(): void
  {
    $id = filter_input(INPUT_POST, "id");
    if (empty($id)) {
      return;
    }
    $stmt = $this->pdo->prepare("DELETE FROM todos WHERE id = :id");
    $stmt->bindValue("id", $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  private function purge(): void
  {
    $this->pdo->query("DELETE FROM todos WHERE is_done = 1");
  }


  function getAll(): array
  {
    $stmt = $this->pdo->query("SELECT * FROM todos ORDER BY id DESC");
    $todos = $stmt->fetchAll();
    return $todos;
  }
}
