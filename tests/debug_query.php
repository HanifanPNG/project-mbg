<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../lib/db_helper.php';
$res = db_query("SELECT * FROM users WHERE username=?", "s", "admin");
var_dump($res->fetch_assoc());
