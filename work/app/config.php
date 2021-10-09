<?php

declare(strict_types=1);
session_start();

const DSN = "mysql:host=db;dbname=myapp;charset=utf8mb4";
const DB_USER = "myappuser";
const DB_PASS = "myapppass";
// const SITE_URL = "http://localhost:8562";
// constだと変数は使えないからエラーが出る
define("SITE_URL", "http://{$_SERVER["HTTP_HOST"]}");

require_once(__DIR__ . "/Utils.php");
require_once(__DIR__ . "/Token.php");
require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/functions.php");
