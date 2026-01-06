<?php
include ('../database/config.php');
session_start();

if(isset($_POST['submit'])){
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:index.php');
      exit();
   }else{
      $message[] = 'البريد الإلكتروني أو كلمة المرور غير صحيحة!';
   }
}


// <!-- Error messages -->
   
    if(isset($message)){
        foreach($message as $message){
            echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
        }
    }




?>