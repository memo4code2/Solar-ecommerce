<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

// Fetch user details
$select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
$user_data = mysqli_fetch_assoc($select_user);

// Fetch cart items
$cart_items = [];
$grand_total = 0;
$cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
if (mysqli_num_rows($cart_query) > 0) { 
    while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
        $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']);
        $grand_total += $sub_total;
        $cart_items[] = $fetch_cart;
    }
}

// Process checkout form
$show_success_popup = false;
if(isset($_POST['place_order'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    
    // Prepare products data
    $products = [];
    foreach($cart_items as $item){
        $products[] = [
            'name' => $item['name'],
            'price' => $item['price'],
            'quantity' => $item['quantity'],
            'image' => $item['image']
        ];
    }
    $products_json = json_encode($products);
    
    // Insert order into database
    $insert_order = mysqli_query($conn, "INSERT INTO `orders` 
        (user_id, name, email, phone, address, payment_method, products, total_price, order_date) 
        VALUES ('$user_id', '$name', '$email', '$phone', '$address', '$payment_method', '$products_json', '$grand_total', NOW())") 
        or die('query failed');
    
    if($insert_order){
        // Clear the cart
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        
        // Set flag to show success popup
        $show_success_popup = true;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنهاء الطلب - Infinite Energy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        font-family: 'Tajawal', sans-serif;
    }
    
    body {
        background-color: #f5f5f5;
        color: var(--dark-color);
        line-height: 1.6;
    }
    
    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    /* Success Popup Styles */
    .success-popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: 0 5px 30px rgba(0,0,0,0.3);
        z-index: 1000;
        text-align: center;
        max-width: 500px;
        width: 90%;
        display: none;
    }
    
    .success-popup.show {
        display: block;
        animation: fadeIn 0.3s;
    }
    
    .success-popup i {
        font-size: 50px;
        color: var(--success-color);
        margin-bottom: 20px;
    }
    
    .success-popup h2 {
        color: var(--primary-color);
        margin-bottom: 15px;
    }
    
    .success-popup p {
        margin-bottom: 20px;
        font-size: 18px;
    }
    
    .success-popup .btn {
        background-color: var(--primary-color);
        color: white;
        padding: 10px 25px;
        border-radius: var(--border-radius);
        text-decoration: none;
        display: inline-block;
        transition: var(--transition);
    }
    
    .success-popup .btn:hover {
        background-color: #b35624;
    }
    
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.5);
        z-index: 999;
        display: none;
    }
    
    .overlay.show {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translate(-50%, -40%); }
        to { opacity: 1; transform: translate(-50%, -50%); }
    }
    
    /* Rest of your existing styles... */
    .checkout-header {
        text-align: center;
        margin: 30px 0;
        color: var(--primary-color);
    }
    
    .checkout-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin-bottom: 50px;
    }
    
    .checkout-form {
        flex: 1;
        min-width: 300px;
        background: white;
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }
    
    .checkout-summary {
        flex: 1;
        min-width: 300px;
        background: white;
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }
    
    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        font-size: 16px;
        transition: var(--transition);
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(201, 100, 41, 0.2);
    }
    
    .payment-methods {
        margin-top: 20px;
    }
    
    .payment-option {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
    }
    
    .payment-option:hover {
        border-color: var(--primary-color);
    }
    
    .payment-option input {
        margin-left: 10px;
    }
    
    .payment-option i {
        margin-left: 10px;
        font-size: 20px;
    }
    
    .btn {
        display: inline-block;
        padding: 12px 25px;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-size: 16px;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        font-weight: 500;
        text-align: center;
        width: 100%;
    }
    
    .btn-primary {
        background: var(--primary-color);
        color: white;
    }
    
    .btn-primary:hover {
        background: #b35624;
        transform: translateY(-2px);
    }
    
    .order-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    
    .order-item-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 5px;
        margin-left: 15px;
    }
    
    .order-item-details {
        flex: 1;
    }
    
    .order-item-title {
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .order-item-price {
        color: var(--primary-color);
        font-weight: bold;
    }
    
    .order-summary-total {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #eee;
        font-size: 18px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
    }
    
    .empty-cart-message {
        text-align: center;
        padding: 30px;
        color: #777;
    }
    
    @media (max-width: 768px) {
        .checkout-container {
            flex-direction: column;
        }
    }
    </style>
</head>
<body>
    <!-- Success Popup -->
    <div class="overlay <?php echo $show_success_popup ? 'show' : ''; ?>"></div>
    <div class="success-popup <?php echo $show_success_popup ? 'show' : ''; ?>">
        <i class="fas fa-check-circle"></i>
        <h2>شكراً لك!</h2>
        <p>لقد تم تنفيذ طلبك سيتم التواصل معك في أقرب وقت</p>
        <a href="index.php" class="btn">العودة إلى الصفحة الرئيسية</a>
    </div>
    
    <div class="container">
        <h1 class="checkout-header">إنهاء الطلب</h1>
        
        <?php if(empty($cart_items)): ?>
            <div class="empty-cart-message">
                <h2>عربة التسوق فارغة</h2>
                <p>لا يوجد لديك أي منتجات في عربة التسوق</p>
                <a href="products.php" class="btn btn-primary" style="margin-top: 20px; max-width: 300px; margin-left: auto; margin-right: auto;">
                    العودة إلى المتجر
                </a>
            </div>
        <?php else: ?>
            <div class="checkout-container">
                <div class="checkout-form">
                    <h2>معلومات العميل</h2>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">الاسم الكامل</label>
                            <input type="text" id="name" name="name" class="form-control" 
                                value="<?php echo $user_data['name']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" class="form-control" 
                                value="<?php echo $user_data['email']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">رقم الهاتف</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">العنوان</label>
                            <textarea id="address" name="address" class="form-control" rows="4" required></textarea>
                        </div>
                        
                        <div class="payment-methods">
                            <h3>طريقة الدفع</h3>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash_on_delivery" checked>
                                <i class="fas fa-money-bill-wave"></i>
                                <span>الدفع عند الاستلام</span>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="credit_card">
                                <i class="fas fa-credit-card"></i>
                                <span>بطاقة ائتمان</span>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="bank_transfer">
                                <i class="fas fa-university"></i>
                                <span>حوالة بنكية</span>
                            </label>
                        </div>
                        
                        <button type="submit" name="place_order" class="btn btn-primary" style="margin-top: 20px;">
                            تأكيد الطلب
                        </button>
                    </form>
                </div>
                
                <div class="checkout-summary">
                    <h2>ملخص الطلب</h2>
                    
                    <?php foreach($cart_items as $item): ?>
                        <div class="order-item">
                            <img src="admin/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="order-item-img">
                            <div class="order-item-details">
                                <h4 class="order-item-title"><?php echo $item['name']; ?></h4>
                                <div class="order-item-price">
                                    <?php echo $item['price']; ?> ر.س × <?php echo $item['quantity']; ?> = 
                                    <?php echo $item['price'] * $item['quantity']; ?> ر.س
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="order-summary-total">
                        <span>المجموع الكلي:</span>
                        <span><?php echo $grand_total; ?> ر.س</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
   
    
    <script>
        // Show success popup if order was just placed
        <?php if($show_success_popup): ?>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.overlay').classList.add('show');
            document.querySelector('.success-popup').classList.add('show');
        });
        <?php endif; ?>
        
        // Close popup when clicking outside
        document.querySelector('.overlay').addEventListener('click', function() {
            this.classList.remove('show');
            document.querySelector('.success-popup').classList.remove('show');
        });
    </script>
</body>
</html>