<?php
session_start();
define('SITE', true);
//defines
$errors = $success =array();
$user = array();

//connnection data
include_once 'db.php';

//if GET
if(isset($_GET['id']) AND intval(strval($_GET['id']),10)>0){
    $id = intval(strval($_GET['id']),10);
    $sql = "SELECT id,  name, middlename, lastname, address, phone, department, position, salary, email, active FROM users WHERE id=$id;";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)==1){
        $user = mysqli_fetch_assoc($result);
    } else{
        $errors[] = "Невалидно ИД на потребителя";
    }
}



//if POST

if(isset($_POST['edit']) AND $_POST['edit'] == 'save'){

    if($_POST['edit_id']!=$id){
        $errors[] = 'Невалидно ID на служителя';
    }

     //проверка за Име
     if(isset($_POST['name']) AND strlen(trim(htmlspecialchars($_POST['name'])))>2){
        $data['name'] = trim(htmlspecialchars($_POST['name']));
    }else{
        $errors[] = 'Невалидно или не попълнено поле за Име';
    }

    //проверка за презиме

    if(isset($_POST['middlename']) AND strlen(trim(htmlspecialchars($_POST['middlename'])))>2){
        $data['middlename'] = trim(htmlspecialchars($_POST['middlename']));
    }else{
        $errors[] = 'Невалидно или не попълнено поле за Презиме';
    }

    //проверка за Фамилия

    if(isset($_POST['lastname']) AND strlen(trim(htmlspecialchars($_POST['lastname'])))>2){
        $data['lastname'] = trim(htmlspecialchars($_POST['lastname']));
    }else{
        $errors[] = 'Невалидно или не попълнено поле за Фамилия';
    }

    //проверка Адрес 

    if(isset($_POST['address']) AND strlen(trim(htmlspecialchars($_POST['address'])))>2){
        $data['address'] = trim(htmlspecialchars($_POST['address']));
    }else{
        $errors[] = 'Невалидно или не попълнено поле за Адрес';
    }

    //проверка за телефон

    if(isset($_POST['phone']) AND strlen(trim(htmlspecialchars($_POST['phone'])))>2){
        $data['phone'] = trim(htmlspecialchars($_POST['phone']));
    }else{
        $errors[] = 'Невалидно или не попълнено поле за Телефон';
    }
    
    //проверка за отдел

    if(isset($_POST['department']) AND strlen(trim(htmlspecialchars($_POST['department'])))>2){
        $data['department'] = trim(htmlspecialchars($_POST['department']));
    }else{
        $errors[] = 'Невалидно или не попълнено поле за Отдел';
    }

    //проверка за длъжност

    if(isset($_POST['position']) AND strlen(trim(htmlspecialchars($_POST['position'])))>2){
        $data['position'] = trim(htmlspecialchars($_POST['position']));
    }else{
        $errors[] = 'Невалидно или не попълнено поле за Длъжност';
    }

    //проверка за заплата

    if(isset($_POST['salary']) AND strlen(trim(htmlspecialchars($_POST['salary'])))>2){
        $data['salary'] = trim(htmlspecialchars($_POST['salary']));
    }else{
        $errors[] = 'Невалидно или не попълнено поле за Заплата';
    }

    //проверка за имейл

    if(isset($_POST['email']) AND filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)!==false){
        $data['email'] = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
    }else {
        $errors[] = 'Невалиден имейл';
    }

     //проверка за парола

     if(isset($_POST['pwd']) AND strlen(trim($_POST['pwd']))>4){
        $data['password'] = md5(trim($_POST['pwd']));
    }

    //Active
    if(isset($_POST['active'])){
        if($_POST['active'] == 1){
            $data['active'] = 1;

        }else{
            $data['active'] = 0;
        }
    }

    //проверка за грешка
    
    if(!count($errors)>0){
        $sql = "UPDATE users SET ";
        $tmp = array();
        foreach($data AS $key=>$val){
            $tmp[] = "$key='$val' ";
        }

        $sql .= implode(',',$tmp);
        $sql .= "WHERE id= $id";
        //проверка код за база данни
        // echo $sql;
        // exit();


        $result = mysqli_query($conn, $sql);
        if(!$result){
            $errors[] = "Грешка на масива при запис на редакцията в базата";
        }else{
            header("Location: list.php");
        }
    }



}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Редактирана на акаунт на  служител</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Редактиране на служител</h2>

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


    <form method='POST' action="">
         <input type="hidden" name="edit_id" value="<?= $user['id']?>">
        <div class="form-group">
               <label for="name">Активен:</label>

            <select name="active" id="">
                <option value="0" <?= ($user['active'] == 0)?'selected': ''?>> Неактивен </option>
                <option value="1" <?= ($user['active'] == 1)?'selected': ''?>> Активен </option>
            </select>
        </div>


        <div class="form-group">
          <label for="name">Име:</label>
          <input type="text" class="form-control" id="name" placeholder="Въведете име" name="name" value="<?=(isset($user['name']))?$user['name']:''?>" required>
        </div>

        <div class="form-group">
          <label for="middle name">Презиме:</label>
          <input type="text" class="form-control" id="middlename"  placeholder="Въведете презиме"  name="middlename" value="<?=(isset($user['middlename']))?$user['middlename']:''?>" required>
        </div>
    
        <div class="form-group">
          <label for="last name">Фамилия:</label>
          <input type="text" class="form-control" id="lastname"  placeholder="Въведете Фамиля" name="lastname"  value="<?=(isset($user['lastname']))?$user['lastname']:''?>" required>
        </div>

        <div class="form-group">
          <label for="address">Адрес:</label>
          <input type="text" class="form-control" id="address"  placeholder="Въведете адрес"  name="address"  value="<?=(isset($user['address']))?$user['address']:''?>" required>
        </div>

        <div class="form-group">
          <label for="phone">Телефон:</label>
          <input type="text" class="form-control" id="phone"  placeholder="Въведете телефон"  name="phone"  value="<?=(isset($user['phone']))?$user['phone']:''?>" required>
        </div>

        <div class="form-group">
          <label for="department">Отдел:</label>
          <input type="text" class="form-control" id="department"  placeholder="Въведете отдел"  name="department" value="<?=(isset($user['department']))?$user['department']:''?>" required>
        </div>

        <div class="form-group">
          <label for="usr">Длъжност:</label>
          <input type="text" class="form-control" id="usr"  placeholder="Въведете длъжност"  name="position"  value="<?=(isset($user['position']))?$user['position']:''?>" required>
        </div>

        <div class="form-group">
          <label for="position">Заплата:</label>
          <input type="text" class="form-control" id="position"  placeholder="Въведете заплата"  name="salary"  value="<?=(isset($user['salary']))?$user['salary']:''?>" required>
        </div>

        <div class="form-group">
          <label for="email">Имейл:</label>
          <input type="email" class="form-control" id="email"  placeholder="Въведете имейл"  name="email" value="<?=(isset($user['email']))?$user['email']: ''?>" required>
        </div>

        <div class="form-group">
        <label for="pwd">Парола:</label>
          <input type="password" class="form-control" id="pwd"  placeholder="Въведете парола"  name="pwd">
        </div>

        <button type="submit" name="edit" value="save" class="btn btn-primary">Запази</button>
        <a href="list.php" style="background-color: light blue;" class="btn btn-primary">Отказ</a>

        <!-- <button type="submit" name="delete" value="delete" class="btn btn-primary">Отказ</button> -->
  </form>
</div>