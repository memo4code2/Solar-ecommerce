<?php
include('Controls/HomePage.php');
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>عربة التسوق - Enfinty Energy</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
   <style>
   :root {
      --primary: #FF7F00;
      --primary-light: #FFA040;
      --primary-dark: #E67300;
      --secondary: #1a1a2e;
      --accent: #e8f4f8;
      --morph-bg: #f0f5ff;
      --text: #2d3748;
      --text-light: #718096;
      --white: #ffffff;
      --glass-bg: rgba(255, 255, 255, 0.1);
      --glass-border: rgba(255, 255, 255, 0.2);
      --shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      --morph-shadow: 20px 20px 60px #d9d9d9, -20px -20px 60px #ffffff;
      --success: #10B981;
      --warning: #F59E0B;
      --danger: #EF4444;
   }
   
   * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
   }
   
   body {
      font-family: 'Tajawal', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #e8f4f8 100%);
      color: var(--text);
      line-height: 1.6;
      min-height: 100vh;
      overflow-x: hidden;
   }
   
   /* Morph Background Elements */
   .morph-bg {
      position: fixed;
      width: 500px;
      height: 500px;
      border-radius: 50%;
      background: linear-gradient(45deg, var(--primary-light), transparent);
      filter: blur(60px);
      opacity: 0.15;
      z-index: -1;
      animation: float 20s ease-in-out infinite;
   }
   
   .morph-bg:nth-child(1) {
      top: 10%;
      right: 10%;
      animation-delay: 0s;
   }
   
   .morph-bg:nth-child(2) {
      bottom: 10%;
      left: 10%;
      background: linear-gradient(45deg, transparent, var(--primary));
      animation-delay: 5s;
   }
   
   .morph-bg:nth-child(3) {
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 300px;
      height: 300px;
      animation-delay: 10s;
   }
   
   @keyframes float {
      0%, 100% {
         transform: translate(0, 0) rotate(0deg);
         border-radius: 50%;
      }
      33% {
         transform: translate(30px, -50px) rotate(120deg);
         border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
      }
      66% {
         transform: translate(-20px, 20px) rotate(240deg);
         border-radius: 40% 60% 70% 30% / 30% 70% 40% 60%;
      }
   }
   
   /* Glass Morph Header */
   .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 3rem;
      background: rgba(26, 26, 46, 0.95);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      color: var(--white);
      box-shadow: var(--shadow);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      border-bottom: 1px solid var(--glass-border);
      transition: all 0.3s ease;
   }
   
   .logo {
      font-weight: 800;
      font-size: 1.8rem;
      display: flex;
      align-items: center;
      gap: 15px;
      background: linear-gradient(45deg, var(--primary), var(--primary-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
   }
   
   .logo i {
      font-size: 2rem;
   }
   
   .nav-links {
      display: flex;
      align-items: center;
      gap: 30px;
   }
   
   .nav-links a {
      color: var(--white);
      text-decoration: none;
      font-weight: 500;
      padding: 10px 20px;
      border-radius: 25px;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
   }
   
   .nav-links a:hover {
      background: var(--glass-bg);
      transform: translateY(-2px);
   }
   
   .nav-links a.active {
      background: linear-gradient(45deg, var(--primary), var(--primary-light));
      color: white;
      box-shadow: 0 4px 15px rgba(255, 127, 0, 0.3);
   }
   
   .nav-links a:hover::before {
      left: 100%;
   }
   
   .user-info {
      display: flex;
      align-items: center;
      gap: 20px;
   }
   
   .user-info span {
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
   }
   
   /* Floating Cart Button */
   .floating-cart {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 60px;
      height: 60px;
      background: linear-gradient(45deg, var(--primary), var(--primary-light));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: white;
      cursor: pointer;
      box-shadow: 0 10px 25px rgba(255, 127, 0, 0.4);
      transition: all 0.3s ease;
      z-index: 999;
      animation: pulse 2s infinite;
   }
   
   .floating-cart:hover {
      transform: scale(1.1) rotate(360deg);
   }
   
   .floating-cart .cart-count {
      position: absolute;
      top: -5px;
      left: -5px;
      background: var(--danger);
      color: white;
      width: 25px;
      height: 25px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
      font-weight: bold;
   }
   
   @keyframes pulse {
      0%, 100% {
         box-shadow: 0 10px 25px rgba(255, 127, 0, 0.4);
      }
      50% {
         box-shadow: 0 10px 30px rgba(255, 127, 0, 0.6);
      }
   }
   
   /* Container */
   .container {
      width: 90%;
      max-width: 1400px;
      margin: 100px auto 50px;
      padding: 20px;
      position: relative;
      z-index: 1;
   }
   
   /* Section Title */
   .section-title {
      text-align: center;
      margin: 40px 0 60px;
      position: relative;
   }
   
   .section-title h1 {
      font-size: 3.5rem;
      background: linear-gradient(45deg, var(--secondary), var(--primary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: 800;
      position: relative;
      display: inline-block;
      padding-bottom: 20px;
   }
   
   .section-title h1::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 150px;
      height: 5px;
      background: linear-gradient(45deg, var(--primary), var(--primary-light));
      border-radius: 5px;
   }
   
   /* Products Grid */
   .products {
      margin: 40px 0;
   }
   
   .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 40px;
      perspective: 1000px;
   }
   
   .box {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 25px;
      overflow: hidden;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: var(--morph-shadow);
      border: 1px solid var(--glass-border);
      position: relative;
      animation: slideUp 0.6s ease-out forwards;
      opacity: 0;
   }
   
   .box:nth-child(1) { animation-delay: 0.1s; }
   .box:nth-child(2) { animation-delay: 0.2s; }
   .box:nth-child(3) { animation-delay: 0.3s; }
   .box:nth-child(4) { animation-delay: 0.4s; }
   
   @keyframes slideUp {
      from {
         opacity: 0;
         transform: translateY(50px);
      }
      to {
         opacity: 1;
         transform: translateY(0);
      }
   }
   
   .box:hover {
      transform: translateY(-15px) rotateY(5deg);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
   }
   
   .box-img {
      height: 250px;
      overflow: hidden;
      position: relative;
   }
   
   .box-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: all 0.5s ease;
   }
   
   .box:hover .box-img img {
      transform: scale(1.1);
   }
   
   .box-content {
      padding: 30px;
   }
   
   .box-title {
      font-size: 1.5rem;
      margin-bottom: 15px;
      color: var(--secondary);
      font-weight: 700;
      line-height: 1.4;
   }
   
   .box-price {
      font-size: 1.8rem;
      font-weight: 800;
      margin-bottom: 20px;
      background: linear-gradient(45deg, var(--primary), var(--primary-light));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
   }
   
   .quantity-input {
      width: 100%;
      padding: 15px;
      margin-bottom: 20px;
      border: 2px solid transparent;
      border-radius: 15px;
      font-size: 16px;
      text-align: center;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      font-family: 'Tajawal', sans-serif;
   }
   
   .quantity-input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(255, 127, 0, 0.15);
   }
   
   /* Shopping Cart Styles */
   .shopping-cart {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      padding: 40px;
      border-radius: 30px;
      margin-bottom: 60px;
      box-shadow: var(--morph-shadow);
      border: 1px solid var(--glass-border);
      animation: slideUp 0.6s ease-out 0.5s forwards;
      opacity: 0;
   }
   
   .cart-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      margin-top: 30px;
   }
   
   .cart-table th {
      background: linear-gradient(45deg, var(--secondary), var(--primary-dark));
      color: white;
      padding: 20px;
      text-align: center;
      font-weight: 600;
      border: none;
      font-size: 1.1rem;
   }
   
   .cart-table th:first-child {
      border-top-right-radius: 15px;
   }
   
   .cart-table th:last-child {
      border-top-left-radius: 15px;
   }
   
   .cart-table td {
      padding: 25px 20px;
      text-align: center;
      background: white;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
   }
   
   .cart-table tr:hover td {
      background: rgba(255, 127, 0, 0.05);
      transform: scale(1.01);
   }
   
   .cart-product-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
   }
   
   .cart-table tr:hover .cart-product-img {
      transform: scale(1.05);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
   }
   
   .update-form {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
   }
   
   .update-input {
      width: 70px;
      padding: 10px;
      border: 2px solid transparent;
      border-radius: 10px;
      text-align: center;
      font-size: 16px;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
   }
   
   .update-input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(255, 127, 0, 0.1);
   }
   
   .table-footer {
      background: linear-gradient(45deg, rgba(255, 127, 0, 0.1), rgba(255, 160, 64, 0.1));
   }
   
   .table-footer td {
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--secondary);
   }
   
   .table-footer td:last-child {
      color: var(--primary);
      font-size: 1.5rem;
   }
   
   .empty-cart {
      text-align: center;
      padding: 60px;
      color: var(--text-light);
      font-size: 1.2rem;
   }
   
   .cart-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 40px;
      gap: 20px;
   }
   
   /* Buttons */
   .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 15px 35px;
      border-radius: 50px;
      font-size: 16px;
      font-weight: 700;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      border: none;
      position: relative;
      overflow: hidden;
      font-family: 'Tajawal', sans-serif;
      box-shadow: 0 4px 15px rgba(255, 127, 0, 0.3);
      gap: 10px;
   }
   
   .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.6s;
   }
   
   .btn:hover::before {
      left: 100%;
   }
   
   .btn-primary {
      background: linear-gradient(45deg, var(--primary), var(--primary-light));
      color: white;
   }
   
   .btn-primary:hover {
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 12px 30px rgba(255, 127, 0, 0.4);
   }
   
   .btn-success {
      background: linear-gradient(45deg, var(--success), #34D399);
      color: white;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
   }
   
   .btn-success:hover {
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 12px 30px rgba(16, 185, 129, 0.4);
   }
   
   .btn-danger {
      background: linear-gradient(45deg, var(--danger), #F87171);
      color: white;
      box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
   }
   
   .btn-danger:hover {
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 12px 30px rgba(239, 68, 68, 0.4);
   }
   
   .disabled {
      opacity: 0.5;
      pointer-events: none;
   }
   
   /* Message Styles */
   .message {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 20px 30px;
      background: linear-gradient(45deg, var(--success), #34D399);
      color: white;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
      z-index: 1000;
      animation: slideInRight 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      max-width: 400px;
      font-weight: 500;
   }
   
   @keyframes slideInRight {
      from {
         right: -100%;
         opacity: 0;
      }
      to {
         right: 20px;
         opacity: 1;
      }
   }
   
   /* Cart Counter */
   .cart-counter {
      position: absolute;
      top: -8px;
      left: -8px;
      background: var(--danger);
      color: white;
      width: 25px;
      height: 25px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
      font-weight: bold;
   }
   
   /* Responsive Design */
   @media (max-width: 1200px) {
      .box-container {
         grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
         gap: 30px;
      }
      
      .container {
         width: 95%;
      }
   }
   
   @media (max-width: 992px) {
      .header {
         flex-direction: column;
         padding: 1rem;
         gap: 1rem;
      }
      
      .nav-links {
         gap: 15px;
         flex-wrap: wrap;
         justify-content: center;
      }
      
      .user-info {
         flex-direction: column;
         gap: 10px;
      }
      
      .section-title h1 {
         font-size: 2.8rem;
      }
   }
   
   @media (max-width: 768px) {
      .cart-table {
         display: block;
         overflow-x: auto;
      }
      
      .cart-table th,
      .cart-table td {
         padding: 15px 10px;
         font-size: 0.9rem;
      }
      
      .cart-product-img {
         width: 70px;
         height: 70px;
      }
      
      .box-container {
         grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
         gap: 20px;
      }
      
      .section-title h1 {
         font-size: 2.2rem;
      }
      
      .box-content {
         padding: 20px;
      }
      
      .cart-actions {
         flex-direction: column;
      }
      
      .btn {
         width: 100%;
         justify-content: center;
      }
   }
   
   @media (max-width: 576px) {
      .box-container {
         grid-template-columns: 1fr;
      }
      
      .box-img {
         height: 200px;
      }
      
      .section-title h1 {
         font-size: 1.8rem;
      }
      
      .shopping-cart {
         padding: 20px;
      }
      
      .header {
         padding: 0.8rem;
      }
      
      .nav-links a {
         padding: 8px 15px;
         font-size: 0.9rem;
      }
   }
   
   /* Custom Scrollbar */
   ::-webkit-scrollbar {
      width: 10px;
   }
   
   ::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
   }
   
   ::-webkit-scrollbar-thumb {
      background: linear-gradient(45deg, var(--primary), var(--primary-light));
      border-radius: 10px;
   }
   
   ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(45deg, var(--primary-dark), var(--primary));
   }
   </style>
</head>
<body>
   <!-- Morph Background Elements -->
   <div class="morph-bg"></div>
   <div class="morph-bg"></div>
   <div class="morph-bg"></div>
   
   <!-- Floating Cart Button -->
   <div class="floating-cart" onclick="scrollToCart()">
      <div class="cart-count" id="cartCount">0</div>
      <i class="fas fa-shopping-cart"></i>
   </div>
   
   <!-- Glass Morph Header -->
   <div class="header">
      <div class="logo">
         <i class="fas fa-sun"></i>
         <span>Enfinty Energy</span>
      </div>
      <div class="nav-links">
         <a href="home.php" class="active"><i class="fas fa-home"></i> الرئيسية</a>
         <a href="index.php"><i class="fas fa-shopping-bag"></i> المنتجات</a>
         <a href="#"><i class="fas fa-phone"></i> اتصل بنا</a>
      </div>
      <div class="user-info">
         <?php
         $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_user) > 0){
            $fetch_user = mysqli_fetch_assoc($select_user);
            echo '<span><i class="fas fa-user-circle"></i> ' . htmlspecialchars($fetch_user['name']) . '</span>';
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
      <!-- Products Section -->
      <div class="section-title">
         <h1>منتجات الطاقة الشمسية</h1>
      </div>
      
      <div class="products">
         <div class="box-container">
         <?php
         include('Database/config.php');
         $result = mysqli_query($conn, "SELECT * FROM products");      
         while($row = mysqli_fetch_array($result)){
         ?>
            <form method="post" class="box" action="">
               <div class="box-img">
                  <img src="https://m.media-amazon.com/images/I/614Lol8TYfL._AC_SY300_SX300_QL70_ML2_.jpg">
               </div>
               <div class="box-content">
                  <h3 class="box-title"><?php echo htmlspecialchars($row['name']); ?></h3>
                  <div class="box-price"><?php echo number_format($row['price'], 2); ?> ر.س</div>
                  <input type="number" min="1" name="product_quantity" value="1" class="quantity-input" placeholder="الكمية">
                  <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($row['image']); ?>">
                  <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
                  <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($row['price']); ?>">
                  <button type="submit" name="add_to_cart" class="btn btn-primary">
                     <i class="fas fa-cart-plus"></i> أضف إلى السلة
                  </button>
               </div>
            </form>
         <?php } ?>
         </div>
      </div>
      
      <!-- Shopping Cart Section -->
      <div class="section-title">
         <h1>عربة التسوق</h1>
      </div>
      
      <div class="shopping-cart">
         <?php
            $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            $grand_total = 0;
            $cart_count = mysqli_num_rows($cart_query);
         ?>
         
         <table class="cart-table">
            <thead>
               <tr>
                  <th>الصورة</th>
                  <th>الاسم</th>
                  <th>السعر</th>
                  <th>الكمية</th>
                  <th>المجموع</th>
                  <th>الإجراءات</th>
               </tr>
            </thead>
            <tbody>
            <?php if($cart_count > 0){
               while($fetch_cart = mysqli_fetch_assoc($cart_query)){
                  $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']);
                  $grand_total += $sub_total;
            ?>
               <tr>
                  <td>
                     <img src="admin/<?php echo htmlspecialchars($fetch_cart['image']); ?>" 
                          class="cart-product-img" 
                          alt="<?php echo htmlspecialchars($fetch_cart['name']); ?>">
                  </td>
                  <td>
                     <strong><?php echo htmlspecialchars($fetch_cart['name']); ?></strong>
                  </td>
                  <td>
                     <span class="box-price"><?php echo number_format($fetch_cart['price'], 2); ?> ر.س</span>
                  </td>
                  <td>
                     <form method="post" class="update-form">
                        <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                        <input type="number" min="1" name="cart_quantity" 
                               value="<?php echo $fetch_cart['quantity']; ?>" 
                               class="update-input">
                        <button type="submit" name="update_cart" class="btn btn-success">
                           <i class="fas fa-sync-alt"></i>
                        </button>
                     </form>
                  </td>
                  <td>
                     <strong style="color: var(--primary);">
                        <?php echo number_format($sub_total, 2); ?> ر.س
                     </strong>
                  </td>
                  <td>
                     <a href="index.php?remove=<?php echo $fetch_cart['id']; ?>" 
                        class="btn btn-danger" 
                        onclick="return confirm('هل تريد إزالة هذا المنتج من عربة التسوق؟');">
                        <i class="fas fa-trash"></i>
                     </a>
                  </td>
               </tr>
            <?php } ?>
               <tr class="table-footer">
                  <td colspan="4" style="text-align: left; padding-left: 30px;">
                     <strong>المجموع الكلي:</strong>
                  </td>
                  <td colspan="2">
                     <strong style="font-size: 1.5rem;">
                        <?php echo number_format($grand_total, 2); ?> ر.س
                     </strong>
                  </td>
               </tr>
            <?php } else { ?>
               <tr>
                  <td colspan="6" class="empty-cart">
                     <i class="fas fa-shopping-cart" style="font-size: 3rem; margin-bottom: 20px; color: var(--text-light);"></i>
                     <h3 style="color: var(--text-light); margin-bottom: 10px;">عربة التسوق فارغة</h3>
                     <p>ابدأ التسوق الآن وأضف منتجات الطاقة الشمسية إلى عربتك!</p>
                  </td>
               </tr>
            <?php } ?>
            </tbody>
         </table>
         
         <?php if($cart_count > 0) { ?>
         <div class="cart-actions">
            <a href="Controls/CheckBuy.php" class="btn btn-primary">
               <i class="fas fa-shopping-cart"></i> متابعة الشراء
            </a>
            <a href="index.php?delete_all" 
               onclick="return confirm('هل تريد حذف جميع المنتجات من عربة التسوق؟');" 
               class="btn btn-danger">
               <i class="fas fa-trash"></i> حذف الكل
            </a>
         </div>
         <?php } ?>
      </div>
   </div>
   
   <script>
      // Update cart count
      document.addEventListener('DOMContentLoaded', function() {
         const cartCount = <?php echo $cart_count; ?>;
         document.getElementById('cartCount').textContent = cartCount;
         
         // Auto-remove messages after 3 seconds
         setTimeout(() => {
            const messages = document.querySelectorAll('.message');
            messages.forEach(msg => {
               msg.style.animation = 'slideInRight 0.5s reverse';
               setTimeout(() => msg.remove(), 500);
            });
         }, 3000);
      });
      
      // Scroll to cart section
      function scrollToCart() {
         const cartSection = document.querySelector('.shopping-cart');
         cartSection.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
         });
         
         // Add animation effect
         cartSection.style.animation = 'none';
         setTimeout(() => {
            cartSection.style.animation = 'slideUp 0.6s ease-out';
         }, 10);
      }
      
      // Scroll to bottom
      function scrollToBottom() {
         window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth'
         });
      }
      
      // Add ripple effect to buttons
      document.querySelectorAll('.btn').forEach(button => {
         button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
               position: absolute;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.6);
               transform: scale(0);
               animation: ripple-animation 0.6s linear;
               width: ${size}px;
               height: ${size}px;
               top: ${y}px;
               left: ${x}px;
            `;
            
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
         });
      });
      
      // Add ripple animation CSS
      const style = document.createElement('style');
      style.textContent = `
         @keyframes ripple-animation {
            to {
               transform: scale(4);
               opacity: 0;
            }
         }
      `;
      document.head.appendChild(style);
      
      // Add hover effect to product boxes
      document.querySelectorAll('.box').forEach(box => {
         box.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) rotateY(5deg)';
         });
         
         box.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) rotateY(0)';
         });
      });
      
      // Add loading animation to add to cart buttons
      document.querySelectorAll('button[name="add_to_cart"]').forEach(button => {
         button.addEventListener('click', function() {
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإضافة...';
            this.disabled = true;
            
            setTimeout(() => {
               this.innerHTML = originalHTML;
               this.disabled = false;
               
               // Update cart count
               const cartCount = document.getElementById('cartCount');
               cartCount.textContent = parseInt(cartCount.textContent) + 1;
               
               // Add celebration effect
               createConfetti();
            }, 1500);
         });
      });
      
      // Confetti effect
      function createConfetti() {
         const colors = ['#FF7F00', '#FFA040', '#FFD700', '#10B981', '#3B82F6'];
         
         for(let i = 0; i < 50; i++) {
            const confetti = document.createElement('div');
            confetti.style.cssText = `
               position: fixed;
               width: 10px;
               height: 10px;
               background: ${colors[Math.floor(Math.random() * colors.length)]};
               border-radius: 50%;
               top: -20px;
               left: ${Math.random() * 100}vw;
               z-index: 9999;
               animation: confetti-fall ${Math.random() * 3 + 2}s linear forwards;
            `;
            
            document.body.appendChild(confetti);
            setTimeout(() => confetti.remove(), 4000);
         }
         
         const confettiStyle = document.createElement('style');
         confettiStyle.textContent = `
            @keyframes confetti-fall {
               0% {
                  transform: translateY(0) rotate(0deg);
               }
               100% {
                  transform: translateY(100vh) rotate(${Math.random() * 360}deg);
               }
            }
         `;
         document.head.appendChild(confettiStyle);
      }
      
      // Cart table row animation
      document.querySelectorAll('.cart-table tr').forEach((