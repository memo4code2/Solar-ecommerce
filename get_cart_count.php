<?php
include 'config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $cart_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM `cart` WHERE user_id = '$user_id'");
    $count = mysqli_fetch_assoc($cart_count);
    echo $count['count'];
} else {
    echo '0';
}
?>