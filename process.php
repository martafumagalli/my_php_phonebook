<?php

require_once "connect.php";

session_start();

$name = '';
$phone = '';
$updateBtn = false;
$id = 0;
$valid_phone = false;

// CRUD - CREATE

if(isset($_POST['add'])) {
  
  $name = ($_POST['name']);
  $phone = ($_POST['phone']);
  $valid_phone = validate_phone($phone);

    if($name != '' && $phone != '' && $valid_phone == true) {
        try {
          $create = "INSERT INTO phonebook(name, phone) VALUES (:namePl, :phonePl)";
          $st = $PDOconn->prepare($create);
          $st->bindParam(":namePl", $name, PDO::PARAM_STR);
          $st->bindParam(":phonePl", $phone, PDO::PARAM_STR);
          $st->execute();
        } catch (PDOexception $e) {
          echo "Error: ".$e->getMessage();
        }
    
        $_SESSION['message'] = "Record has been saved!";
        $_SESSION['msg_type'] = "success"; 
  
        header('location: index.php');

    } else {

      $_SESSION['message'] = "Please, enter a valid  NAME and PHONE NUMBER";
      $_SESSION['msg_type'] = "warning";

      header('location: index.php');
    
    }
 } 


// CRUD - READ

try {
  $read = "SELECT * from phonebook";
  $st = $PDOconn->query($read);
  $records = $st->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOexception $e) {
  echo "Error: ".$e->getMessage();
}

// CRUD - UPDATE

if(isset($_GET['edit'])) {
  try {
    $updateCheck = "SELECT * FROM phonebook WHERE id = :idPl";
    $id = $_GET['edit'];
    $updateBtn = true;
    $st = $PDOconn->prepare($updateCheck);
    $st->bindParam(':idPl', $id, PDO::PARAM_STR);
    $st->execute();
      if(count([$st])==1) {
        $rows = $st->fetch();
        $name = $rows['name'];
        $phone = $rows['phone'];
    }
  } catch ( PDOexception $e) {
    echo "Error: ".$e->getMessage();
  }
}

if(isset($_POST['update'])) {
  
  $id = $_POST['id'];
  $name = $_POST['name'];
  $phone = $_POST['phone'];

  $valid_phone = validate_phone($phone);

  if($name != '' && $phone != '' && $valid_phone == true) {

    try {
      $update = "UPDATE phonebook SET name = :namePl , phone = :phonePl WHERE id = :idPl";
      $st= $PDOconn->prepare($update);
      $st->bindParam(":namePl", $name, PDO::PARAM_STR);
      $st->bindParam(":phonePl", $phone, PDO::PARAM_INT);
      $st->bindParam(":idPl", $id, PDO::PARAM_STR);
      $st->execute();

      $_SESSION['message'] = "Record has been updated!";
      $_SESSION['msg_type'] = "success";

      header('location: index.php');

    } catch ( PDOexception $e) {
      echo "Error: ".$e->getMessage();
    }
    
  } else {
      $_SESSION['message'] = "Please, enter a valid  NAME and PHONE NUMBER";
      $_SESSION['msg_type'] = "warning";

      header('Location: ' . $_SERVER['HTTP_REFERER']); 
  }

}

// CRUD - DELETE

if(isset($_GET['delete'])) {
  try {
    $delete = "DELETE from phonebook WHERE id = :idPl";
    $id = $_GET['delete'];
    $st = $PDOconn->prepare($delete);
    $st->bindParam(':idPl', $id, PDO::PARAM_INT);
    $st->execute();
  } catch (PDOexception $e) {
    echo "Error: ".$e->getMessage();
  }

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";

  header('location: index.php');
}

// VALIDATE NUMBER

function validate_phone($phone){
  $valid_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
  if (strlen($valid_number) < 10 || strlen($valid_number) > 14) {
    return false;
  } else {
    return true;
  }
}

?>