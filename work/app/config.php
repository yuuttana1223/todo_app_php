<?php

declare(strict_types=1);
session_start();

const DSN = "mysql:host=db;dbname=myapp;charset=utf8mb4";
const DB_USER = "myappuser";
const DB_PASS = "myapppass";
define("SITE_URL", "http://{$_SERVER["HTTP_HOST"]}");

// require_once(__DIR__ . "/Utils.php");
// require_once(__DIR__ . "/Token.php");
// require_once(__DIR__ . "/Database.php");
// require_once(__DIR__ . "/Todo.php");

spl_autoload_register(function ($class) {
  $prefix = "MyApp\\";
  if (strpos($class, $prefix) === 0) {
    $fileName = sprintf(__DIR__ . "/%s.php", substr($class, strlen($prefix)));
    if (file_exists($fileName)) {
      require($fileName);
    } else {
      echo "File not found: {$fileName}";
    }
  }
});
