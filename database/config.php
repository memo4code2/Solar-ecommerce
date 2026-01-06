<?php



$host='localhost';
$username='root';
$pass='';
$db= 'shop_dbn';

$conn = mysqli_connect('localhost','root','','shop_dbn') ;

if(! $conn){

    die("Cant Connect");

}else{
    // echo "Done";
}
?>