<?php
session_start();
define('SITE', true);
//defines
$errors = $success = $data =array();
$users = array();

//connnection data
include_once 'db.php';

//if post
if(isset($_POST['submit']) AND $_POST['submit']=='save'){
    //имаме данни -проверка дали са пълни

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

    if(isset($_POST['еmail']) AND filter_var($_POST['еmail'],FILTER_VALIDATE_EMAIL)!==false){
        $data['еmail'] = filter_var($_POST['еmail'],FILTER_VALIDATE_EMAIL);
    }else {
        $errors[] = 'Невалиден имейл';
    }

    


    //проверка за парола

    if(isset($_POST['pwd']) AND strlen(trim($_POST['pwd']))>4){
        $pwd = trim($_POST['pwd']);
    }else{
        $errors[] = 'Паролата трябва да е  по дълга от 4 синвола'; 
        $pwd=false;
    }

    if(isset($_POST['pwd2']) AND $_POST['pwd2'] == $pwd AND $pwd){
        $data['password'] = $pwd;
    }else {
        $errors[] = 'Паролата не съвпада';
    }

    //проверки за грешки
    if(count($errors)==0){


        $sql = "INSERT INTO users(name,middlename,lastname,address,phone,department,position,salary,email,password) 
        VALUES ('".$data['name']."','".$data['middlename']."','".$data['lastname']."','".$data['address']."','".$data['phone']."','".$data['department']."','".$data['position']."','".$data['salary']."','".$data['еmail']."','".md5($data['password'])."')";
        
        // DB  insert
        $result = mysqli_query($conn, $sql);

        //проверка

        if(!$result){
            $errors[] = 'Грешка при запис в базата данни';

        }else{
            // header('Location: list.php');
            $success[] = 'Потребител с имена <b>'.$data['name'].' '.$data['middlename'].' '.$data['lastname'].'</b> е записан успешно';
           
        }

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
  <h2>Добавяне на нов служител</h2>

  <div class="text-right">
        <a href="list.php" class="btn btn-primary">Готово</a> </p>
    </div>
 


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
        <strong>Готово!</strong> ' .implode('<br>',$success).'
      </div>' ;
      
      
      }else {
        echo '';
       
      }
    ?>


  <form method= 'POST'action="">
    <div class="form-group">
      <label for="name">Име:</label>
      <input type="text" class="form-control" id="name" placeholder="Въведете име" name="name"  required>
      <!-- ако искаме да запазим валидните данни value="<?=(isset($data['name']))?$data['name']:''?>" -->
    </div>

    <div class="form-group">
      <label for="middle name">Презиме:</label>
      <input type="text" class="form-control" id="middlename"  placeholder="Въведете презиме"  name="middlename"  required>
    </div>
    
    <div class="form-group">
      <label for="last name">Фамилия:</label>
      <input type="text" class="form-control" id="lastname"  placeholder="Въведете Фамиля" name="lastname"  required>
    </div>

    <div class="form-group">
      <label for="address">Адрес:</label>
      <input type="text" class="form-control" id="address"  placeholder="Въведете адрес"  name="address"   required>
    </div>

    <div class="form-group">
      <label for="phone">Телефон:</label>
      <input type="text" class="form-control" id="phone"  placeholder="Въведете телефон"  name="phone"   required>
    </div>

    <div class="form-group">
      <label for="department">Отдел:</label>
      <input type="text" class="form-control" id="department"  placeholder="Въведете отдел"  name="department"  required>
    </div>

    <div class="form-group">
      <label for="usr">Длъжност:</label>
      <input type="text" class="form-control" id="usr"  placeholder="Въведете длъжност"  name="position"   required>
    </div>

    <div class="form-group">
      <label for="position">Заплата:</label>
      <input type="text" class="form-control" id="position"  placeholder="Въведете заплата"  name="salary"   required>
    </div>

    <div class="form-group">
      <label for="еmail">Имейл:</label>
      <input type="еmail" class="form-control" id="еmail"  placeholder="Въведете имейл"  name="еmail"  required>
    </div>

    <div class="form-group">
      <label for="pwd">Парола:</label>
      <input type="password" class="form-control" id="pwd"  placeholder="Въведете парола"  name="pwd" required>
    </div>

    <div class="form-group">
      <label for="pwd2">Повторете паролата:</label>
      <input type="password" class="form-control" id="pwd2"  placeholder="Повторете паролата"  name="pwd2" required>
    </div>

    <button type="submit" name="submit" value="save" class="btn btn-primary">Добави служител</button>
    <a href="list.php" style="background-color: light blue;" class="btn btn-primary">Отказ</a>
  </form>
</div>


</body>
</html>