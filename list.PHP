<?php
session_start();
define('SITE', true);
//defines
$errors = $success = $data =array();
$users = array();

//connnection data
include_once 'db.php';


// списък със съществуващи данни на служители
$sql = "SELECT id, CONCAT(name,\" \",middlename,\" \",lastname) AS name, address,phone,department,position,salary,email FROM users ;";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
    
    while($row = mysqli_fetch_assoc($result)){
        $users[] = $row;
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
    <div class="text-right">
        <a href="login.php" class="btn btn-primary">Изход</a> </p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>

            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Position</th>
            <th>Salary</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
            </tr>
        </thead>

        <tbody>
             <?php

              foreach($users AS $u){?>

                <tr>
                    <td><?= $u['id']?></td>
                    <td><?= $u['name']?></td>
                    <td><?= $u['address']?></td>
                    <td><?= $u['phone']?></td>
                    <td><?= $u['department']?></td>
                    <td><?= $u['position']?></td>
                    <td><?= $u['salary']?></td>
                    <td><?= $u['email']?></td>
                    <td><a href="edit.php?id=<?= $u['id']?>"><span class="glyphicon glyphicon-pencil">Редактиране</span></td>
                    <td><a href="delete.php?id=<?= $u['id']?>"><span class="glyphicon glyphicon-trash"></span>Изтриване</a></td>
                    

                </tr>
            
             <?php } ?>



        </tbody>


    </table>

  


    <ul>
 

        <!-- списък -->
        <!-- <?php foreach($users as $u){?>
        <li> <?= $u['name']?> (<?= $u['address']?>) (<?= $u['phone']?>) (<?= $u['department']?>) 
        (<?= $u['position']?>) (<?= $u['salary']?>) (<?= $u['email']?>) -- <a href="edit.php?id=<?=$u['id']?>">редактиране</a> -- <a href="delete.php?id=<?=$u['id']?>">изтриване</a>
         <?php } ?> -->
    </ul>


    <div class="text-left">

    <a href="adding.php" style="background-color: light blue;" class="btn btn-primary">Добави служител</a>
    </div>

</div>
