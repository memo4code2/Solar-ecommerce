<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
$order = [];
if($order_id){
    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE id = '$order_id' AND user_id = '$user_id'") or die('query failed');
    $order = mysqli_fetch_assoc($order_query);
}

if(empty($order)){
    header('location:index.php');
}
?>







<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم الطلب بنجاح - Infinite Energy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary-color: #c96429;
        --secondary-color: #f8a145;
        --dark-color: #333;
        --light-color: #f9f9f9;
        --success-color: #2ecc71;
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
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .success-container {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin: 50px auto;
    }
    
    .success-icon {
        font-size: 80px;
        color: var(--success-color);
        margin-bottom: 20px;
    }
    
    .success-title {
        font-size: 28px;
        color: var(--primary-color);
        margin-bottom: 20px;
    }
    
    .success-message {
        font-size: 18px;
        margin-bottom: 30px;
    }
    
    .order-details {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        margin: 30px 0;
        text-align: right;
    }
    
    .order-details h3 {
        margin-bottom: 15px;
        color: var(--primary-color);
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .detail-label {
        font-weight: bold;
        color: #555;
    }
    
    .btn {
        display: inline-block;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
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
    
    .products-list {
        margin-top: 20px;
    }
    
    .product-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .product-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
        margin-left: 15px;
    }
    
    .product-info {
        flex: 1;
        text-align: right;
    }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
        <div class="success-container">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="success-title">تم استلام طلبك بنجاح!</h1>
            <p class="success-message">شكراً لثقتك بنا. سنقوم بتجهيز طلبك وإرساله في أقرب وقت ممكن.</p>
            
            <div class="order-details">
                <h3>تفاصيل الطلب</h3>
                
                <div class="detail-row">
                    <span class="detail-value">#<?php echo $order['id']; ?></span>
                    <span class="detail-label">رقم الطلب</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-value"><?php echo date('Y/m/d H:i', strtotime($order['order_date'])); ?></span>
                    <span class="detail-label">تاريخ الطلب</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-value"><?php echo $order['payment_method']; ?></span>
                    <span class="detail-label">طريقة الدفع</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-value"><?php echo $order['total_price']; ?> ر.س</span>
                    <span class="detail-label">المجموع الكلي</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-value"><?php echo $order['address']; ?></span>
                    <span class="detail-label">عنوان التسليم</span>
                </div>
                
                <div class="products-list">
                    <h4>المنتجات المطلوبة:</h4>
                    <?php 
                    $products = json_decode($order['products'], true);
                    foreach($products as $product): 
                    ?>
                        <div class="product-item">
                            <img src="admin/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-img">
                            <div class="product-info">
                                <div><?php echo $product['name']; ?></div>
                                <div><?php echo $product['quantity']; ?> × <?php echo $product['price']; ?> ر.س</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <a href="index.php" class="btn btn-primary">العودة إلى الصفحة الرئيسية</a>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>