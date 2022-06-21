<?php
session_start();
define('SITE', true);
//connnection data
include_once 'db.php';
$errors = $success = array ();


//if post
if(isset($_POST['submit'])){

    //Потребител
    if(isset($_POST['user']) AND filter_var($_POST['user'],FILTER_VALIDATE_EMAIL)){
        $user =trim($_POST['user']);
    }else{
        $errors[] = 'Полето трябва да садържа валиден имейл';
    }

    //парола
    if(isset($_POST['pass']) AND strlen($_POST['pass'])>0){
        $pass = md5($_POST['pass']);

    }else{
        $errors[] = 'Полето парола на може да бъде празно';
    }

    //имали грешки
    if(count($errors)==0){

    //escaping
      mysqli_real_escape_string($conn, $user );

      //query
        $sql = "SELECT id, name, middlename, lastname, address, phone, department, position, salary, email, active FROM users 
        WHERE active = 1 AND email = '$user' AND password = '$pass'";
        
        //стартираме query
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result)==1){
            $user = mysqli_fetch_assoc($result);
            $_SESSION['loged_in'] = true;
            $_SESSION['user'] = $user_data;


            //прехвърляне на потребителя на друга страница
            header("Location: list.php");
        }else{
            $errors[] ="Не валидно име или парола";
        }

    }

}




?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Вход</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Вход</h2>

    <?php if(count($errors)>0){
        echo '<div class="alert alert-danger">
        <strong>Грешка!</strong> '.implode('<br>',$errors).'
      </div>';
        }else{
        echo '';
        }
    ?>

    <?php if(count($success)>0){
      echo '<div class="alert alert-success">
        <strong>Готово!</strong> '.implode('<br>',$success).'
      </div>' ;
      }else {
        echo '';
       
      }
    ?>


    <form method= 'POST'action="">

        <div class="form-group">
          <label for="name">Потребител:</label>
         <input type="email" class="form-control" id="name" placeholder="Въведете имейл" name="user" value="<?=(isset($user))?$user:''?>" required>
         </div>

        <div class="form-group">
            <label for="middle name">Парола:</label>
            <input type="password" class="form-control" id="pass"  placeholder="Въведете парола"  name="pass"  required>
        </div>

        <button type="submit" name="submit" value="login" class="btn btn-primary">Вход</button>
    </form>

</div>
