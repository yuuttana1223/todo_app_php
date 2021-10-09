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
          $this->add();
          break;
        case "toggle":
          $this->toggle();
          break;
        case "delete":
          $this->delete();
          break;
        default:
          exit;
      }

      header("Location: " . SITE_URL);
      exit;
    }
  }

  private function add(): void
  {
    $title = trim(filter_input(INPUT_POST, "title"));
    if ($title === "") {
      return;
    }

    $stmt = $this->pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
    $stmt->bindValue("title", $title, PDO::PARAM_STR);
    $stmt->execute();
  }

  private function toggle(): void
  {
    $id = filter_input(INPUT_POST, "id");
    if (empty($id)) {
      return;
    }
    $stmt = $this->pdo->prepare("UPDATE todos SET is_done = NOT is_done WHERE id = :id");
    $stmt->bindValue("id", $id, PDO::PARAM_INT);
    $stmt->execute();
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


  function getAll(): array
  {
    $stmt = $this->pdo->query("SELECT * FROM todos ORDER BY id DESC");
    $todos = $stmt->fetchAll();
    return $todos;
  }
}
