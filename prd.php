<?php



include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'المنتج أضيف بالفعل إلى عربة التسوق!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
      $message[] = 'المنتج يضاف الى عربة التسوق!';
   }

};

if(isset($_POST['update_cart'])){
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
   $message[] = 'تم تحديث كمية سلة التسوق بنجاح!';
}

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:index.php');
}
  
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:index.php');
}

?>








<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>عربة التسوق</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <style>
   :root {
      --primary-color: #c96429;
      --secondary-color: #f8a145;
      --dark-color: #333;
      --light-color: #f9f9f9;
      --danger-color: #e74c3c;
      --success-color: #2ecc71;
      --border-radius: 8px;
      --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
   }
   
   * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
   }
   
   body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      direction: rtl;
      background-color: #f5f5f5;
      color: var(--dark-color);
      line-height: 1.6;
   }
   
   .container {
      width: 90%;
      max-width: 1400px;
      margin: 0 auto;
      padding: 20px;
   }
   
   /* Header Styles */
   .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 50px;
      font-size: 18px;
      background-color: var(--primary-color);
      color: white;
      box-shadow: var(--box-shadow);
      position: sticky;
      top: 0;
      z-index: 1000;
   }
   
   .logo {
      font-weight: bold;
      font-size: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
   }
   
   .logo i {
      font-size: 28px;
   }
   
   .nav-links {
      display: flex;
      align-items: center;
      gap: 25px;
   }
   
   .nav-links a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition);
      padding: 5px 0;
      position: relative;
   }
   
   .nav-links a:hover {
      color: var(--secondary-color);
   }
   
   .nav-links a:after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      background: var(--secondary-color);
      bottom: 0;
      right: 0;
      transition: var(--transition);
   }
   
   .nav-links a:hover:after {
      width: 100%;
   }
   
   .user-info {
      display: flex;
      align-items: center;
      font-size: 16px;
      gap: 15px;
   }
   
   .user-info span {
      font-weight: bold;
   }
   
   .btn {
      display: inline-block;
      padding: 8px 20px;
      border-radius: var(--border-radius);
      text-decoration: none;
      font-size: 14px;
      cursor: pointer;
      transition: var(--transition);
      border: none;
      font-weight: 500;
   }
   
   .btn-primary {
      background: var(--primary-color);
      color: white;
   }
   
   .btn-primary:hover {
      background: #b35624;
      transform: translateY(-2px);
   }
   
   .btn-danger {
      background: var(--danger-color);
      color: white;
   }
   
   .btn-danger:hover {
      background: #c0392b;
      transform: translateY(-2px);
   }
   
   .btn-success {
      background: var(--success-color);
      color: white;
   }
   
   .btn-success:hover {
      background: #27ae60;
      transform: translateY(-2px);
   }
   
   .disabled {
      opacity: 0.6;
      pointer-events: none;
   }
   
   /* Message Styles */
   .message {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 15px 25px;
      background: var(--success-color);
      color: white;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      z-index: 1000;
      animation: slideIn 0.5s, fadeOut 0.5s 2.5s forwards;
   }
   
   @keyframes slideIn {
      from { right: -100%; opacity: 0; }
      to { right: 20px; opacity: 1; }
   }
   
   @keyframes fadeOut {
      to { opacity: 0; }
   }
   
   /* Products Section */
   .section-title {
      text-align: center;
      margin: 30px 0;
      font-size: 32px;
      color: var(--primary-color);
      position: relative;
   }
   
   .section-title:after {
      content: '';
      position: absolute;
      width: 80px;
      height: 3px;
      background: var(--secondary-color);
      bottom: -10px;
      right: 50%;
      transform: translateX(50%);
   }
   
   .products {
      margin: 40px 0;
   }
   
   .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 25px;
   }
   
   .box {
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      overflow: hidden;
      transition: var(--transition);
   }
   
   .box:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
   }
   
   .box-img {
      height: 200px;
      overflow: hidden;
      position: relative;
   }
   
   .box-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: var(--transition);
   }
   
   .box:hover .box-img img {
      transform: scale(1.05);
   }
   
   .box-content {
      padding: 20px;
   }
   
   .box-title {
      font-size: 18px;
      margin-bottom: 10px;
      color: var(--dark-color);
      font-weight: 600;
   }
   
   .box-price {
      font-size: 20px;
      color: var(--primary-color);
      font-weight: 700;
      margin-bottom: 15px;
   }
   
   .quantity-input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: var(--border-radius);
      margin-bottom: 15px;
      text-align: center;
   }
   
   /* Shopping Cart Styles */
   .shopping-cart {
      background: white;
      padding: 30px;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      margin-bottom: 40px;
   }
   
   .cart-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
   }
   
   .cart-table th {
      background: var(--primary-color);
      color: white;
      padding: 15px;
      text-align: center;
   }
   
   .cart-table td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #eee;
   }
   
   .cart-table tr:hover {
      background: #f9f9f9;
   }
   
   .cart-product-img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 5px;
   }
   
   .update-form {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
   }
   
   .update-input {
      width: 60px;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: var(--border-radius);
      text-align: center;
   }
   
   .table-footer {
      font-weight: bold;
      background: #f5f5f5;
   }
   
   .cart-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
   }
   
   .empty-cart {
      text-align: center;
      padding: 30px;
      color: #777;
   }
   
   /* Responsive Styles */
   @media (max-width: 992px) {
      .header {
         flex-direction: column;
         padding: 15px 20px;
         gap: 15px;
      }
      
      .nav-links {
         gap: 15px;
      }
      
      .box-container {
         grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      }
   }
   
   @media (max-width: 768px) {
      .cart-table {
         display: block;
         overflow-x: auto;
      }
      
      .update-form {
         flex-direction: column;
      }
      
      .cart-actions {
         flex-direction: column;
         gap: 10px;
      }
   }
   
   @media (max-width: 576px) {
      .box-container {
         grid-template-columns: 1fr;
      }
      
      .box-img {
         height: 250px;
      }
   }


   <button onclick="scrollToBottom()" class="scroll-btn">Go to Bottom</button>

<script>
    function scrollToBottom() {
        window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth'
        });
    }
</script>

<style>
    .scroll-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 10px 15px;
        background-color: #c96429;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
        transition: background 0.3s;
    }

    .scroll-btn:hover {
        background-color: #a04d20;
    }
</style>


   </style>
</head>
<body>
<div class="header">
    <div class="logo">
        
        <span> 🌞Enfinty Energy </span>
    </div>
    <div class="nav-links">
        <a href="home.php">الرئيسية</a>
        <a href="index.php">المنتجات</a>
       
        <a href="#">اتصل بنا</a>
       

        
    </div>
    <div class="user-info">
    <button onclick="scrollToBottom()" class="scroll-btn">🛒</button>
        <?php
        $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_user) > 0){
            $fetch_user = mysqli_fetch_assoc($select_user);
            echo '<span><i class="fas fa-user"></i> ' . $fetch_user['name'] . '</span>';
        }
        ?>
        
        <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('هل أنت متأكد أنك تريد تسجيل الخروج؟');" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
        </a>
    </div>
</div>

<?php
if(isset($message)){
   foreach($message as $msg){
      echo '<div class="message" onclick="this.remove();">'.$msg.'</div>';
   }
}
?>

<div class="container">
   <h1 class="section-title">منتجاتنا</h1>
   
   <div class="products">
      <div class="box-container">
      <?php
      include('config.php');
      $result = mysqli_query($conn, "SELECT * FROM products");      
      while($row = mysqli_fetch_array($result)){
      ?>
         <form method="post" class="box" action="">
            <div class="box-img">
               <img src="admin/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
            </div>
            <div class="box-content">
               <h3 class="box-title"><?php echo $row['name']; ?></h3>
               <div class="box-price"><?php echo $row['price']; ?> ر.س</div>
               <input type="number" min="1" name="product_quantity" value="1" class="quantity-input">
               <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
               <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
               <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
               <button type="submit" name="add_to_cart" class="btn btn-primary" style="width: 100%;">
                  <i class="fas fa-cart-plus"></i> أضف إلى السلة
               </button>
            </div>
         </form>
      <?php }; ?>
      </div>
   </div>

   <h1 class="section-title">عربة التسوق</h1>
   
   <div class="shopping-cart">
      <?php
         $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         $grand_total = 0;
      ?>
      
      <table class="cart-table">
         <thead>
            <tr>
               <th>الصورة</th>
               <th>الاسم</th>
               <th>السعر</th>
               <th>الكمية</th>
               <th>المجموع</th>
               <th>إجراء</th>
            </tr>
         </thead>
         <tbody>
         <?php if(mysqli_num_rows($cart_query) > 0){
            while($fetch_cart = mysqli_fetch_assoc($cart_query)){
               $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']);
               $grand_total += $sub_total;
         ?>
            <tr>
               <td><img src="admin/<?php echo $fetch_cart['image']; ?>" class="cart-product-img" alt=""></td>
               <td><?php echo $fetch_cart['name']; ?></td>
               <td><?php echo $fetch_cart['price']; ?> ر.س</td>
               <td>
                  <form method="post" class="update-form">
                     <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                     <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>" class="update-input">
                     <button type="submit" name="update_cart" class="btn btn-success">
                        <i class="fas fa-sync-alt"></i>
                     </button>
                  </form>
               </td>
               <td><?php echo $sub_total; ?> ر.س</td>
               <td>
                  <a href="index.php?remove=<?php echo $fetch_cart['id']; ?>" class="btn btn-danger" onclick="return confirm('إزالة العنصر من سلة التسوق؟');">
                     <i class="fas fa-trash"></i>
                  </a>
               </td>
            </tr>
         <?php } ?>
            <tr class="table-footer">
               <td colspan="4">المجموع الكلي:</td>
               <td><?php echo $grand_total; ?> ر.س</td>
               <td>
                  <a href="index.php?delete_all" onclick="return confirm('حذف كل المنتجات من العربة؟');" class="btn btn-danger <?php echo ($grand_total > 1)?'':'disabled'; ?>">
                     <i class="fas fa-trash"></i> حذف الكل
                  </a>
               </td>
            </tr>
         <?php } else { ?>
            <tr>
               <td colspan="6" class="empty-cart">عربة التسوق فارغة</td>
            </tr>
         <?php } ?>
         </tbody>
      </table>
      
      <?php if(mysqli_num_rows($cart_query) > 0) { ?>
      <div class="cart-actions">
      <a href="checkout.php" class="btn btn-primary">
    <i class="fas fa-shopping-cart"></i> متابعة الشراء
</a>
         <a href="index.php?delete_all" onclick="return confirm('حذف كل المنتجات من العربة؟');" class="btn btn-danger">
            <i class="fas fa-trash"></i> حذف الكل
         </a>
      </div>
      <?php } ?>
   </div>
</div>

<script>
   // Auto-remove messages after 3 seconds
   setTimeout(() => {
      const messages = document.querySelectorAll('.message');
      messages.forEach(msg => msg.remove());
   }, 3000);


   
    function scrollToBottom() {
        window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth'
        });
    }


</script>

</body>
</html>