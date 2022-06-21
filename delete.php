<?php
session_start();
define('SITE', true);
//defines
$errors = $success =array();
$user = array();

//connnection data
include_once 'db.php';

//имамели данни GET
if(isset($_GET['id']) AND intval(strval($_GET['id']),10)>0){
    $id = intval(strval($_GET['id']),10);
    $sql = "SELECT id, CONCAT(name,\" \",middlename,\" \",lastname) AS name, address,phone,department,position,salary,email FROM users WHERE id=$id;";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)==1){
        $user = mysqli_fetch_assoc($result);
    } else{
        $errors[] = "Невалидно ИД на потребителя";
    }
}

//IF POST 
 if(isset($_POST['delete']) AND $_POST['delete_id'] == $id AND $id>0){
    $sql = "DELETE FROM users WHERE id=$id";

    $result = mysqli_query($conn, $sql);
    if(!$result){
        $errors = "Грешка при изтриване";
    }else{
        header('Location: list.php');
    }
 }



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Добавяне  на нов служител</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Изтриване на потребителя</h2>

    <?php if(count($errors)>0){
        echo '<div class="alert alert-danger">
        <strong>Грешка!</strong> '.implode('<br>',$errors).'
      </div>';
    }else{
        echo '';
    }
    ?>

    <?=(count($success)>0)? '<div class="alert alert-success">
        <strong>Готово!</strong> '.implode('<br>',$success).'
      </div>': '';?>

    <?php if(count($user)>0){ ?>
        <div class="row">
           <div class="col">
                <h5>Потвърждаване на изтриването</h5>
                <p>наистина ли искате да изтриете потребител с имена:<br>

                <b><?=$user['name']?></b>
               </p>
            </div>
      </div>

      <form method= 'POST'action="">
          <input type="hidden" name="delete_id" value="<?=$user['id']?>">
          <button type="submit" name="delete" value="delete" class="btn btn-primary">Изтриване</button>
          <a href="list.php" style="background-color: light blue;" class="btn btn-primary">Отказ</a>
      </form>
    <?php } ?>
</div>