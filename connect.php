<?php

// CONNECT TO DATABASE

require_once('settings.php');

try {
  $PDOconn = new PDO($dsn, $user, $password);
  $PDOconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOexception $e) {
  echo "Connection failed: ".$e->getMessage();
}

?>