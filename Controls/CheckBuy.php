<?php
include '../Database/config.php';
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
    <title>إنهاء الطلب - Enfinty Energy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/CSS/CheckBuy.css">
    
</head>
<body>
    <!-- Morph Background Elements -->
    <div class="morph-bg"></div>
    <div class="morph-bg"></div>
    <div class="morph-bg"></div>
    
    <!-- Success Popup -->
    <div class="overlay <?php echo $show_success_popup ? 'show' : ''; ?>"></div>
    <div class="success-popup <?php echo $show_success_popup ? 'show' : ''; ?>">
        <i class="fas fa-check-circle"></i>
        <h2>تم تأكيد الطلب بنجاح! 🎉</h2>
        <p>شكراً لك على ثقتك بنا! سيتم التواصل معك في أقرب وقت لتأكيد التفاصيل وإرسال الطلب.</p>
        <a href="../index.php" class="btn btn-primary">العودة إلى الصفحة الرئيسية</a>
    </div>
    
    <div class="container">
        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step active">
                <div class="step-number">1</div>
                <div class="step-label">عربة التسوق</div>
            </div>
            <div class="step-line"></div>
            <div class="step active">
                <div class="step-number">2</div>
                <div class="step-label">الدفع والشحن</div>
            </div>
            <div class="step-line"></div>
            <div class="step <?php echo $show_success_popup ? 'active' : ''; ?>">
                <div class="step-number">3</div>
                <div class="step-label">التأكيد</div>
            </div>
        </div>
        
        <div class="checkout-header">
            <h1>إنهاء الطلب</h1>
        </div>
        
        <?php if(empty($cart_items)): ?>
            <div class="empty-cart-message">
                <i class="fas fa-shopping-cart" style="font-size: 4rem; color: var(--primary); margin-bottom: 20px;"></i>
                <h2>عربة التسوق فارغة</h2>
                <p>لا يوجد لديك أي منتجات في عربة التسوق. ابدأ بالتسوق الآن!</p>
                <a href="../index.php" class="btn btn-primary" style="max-width: 300px;">
                    <i class="fas fa-arrow-right" style="margin-right: 10px;"></i> العودة إلى المتجر
                </a>
            </div>
        <?php else: ?>
            <div class="checkout-container">
                <div class="checkout-form">
                    <h2>معلومات العميل</h2>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name"><i class="fas fa-user" style="margin-left: 10px;"></i> الاسم الكامل</label>
                            <input type="text" id="name" name="name" class="form-control" 
                                value="<?php echo htmlspecialchars($user_data['name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope" style="margin-left: 10px;"></i> البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" class="form-control" 
                                value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone"><i class="fas fa-phone" style="margin-left: 10px;"></i> رقم الهاتف</label>
                            <input type="tel" id="phone" name="phone" class="form-control" 
                                placeholder="+966 XX XXX XXXX" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address"><i class="fas fa-map-marker-alt" style="margin-left: 10px;"></i> العنوان</label>
                            <textarea id="address" name="address" class="form-control" rows="4" 
                                placeholder="الرجاء إدخال العنوان الكامل بما في ذلك المدينة والرمز البريدي" required></textarea>
                        </div>
                        
                        <div class="payment-methods">
                            <h3><i class="fas fa-credit-card" style="margin-left: 10px;"></i> طريقة الدفع</h3>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash_on_delivery" checked>
                                <i class="fas fa-money-bill-wave"></i>
                                <span>الدفع عند الاستلام</span>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="credit_card">
                                <i class="fas fa-credit-card"></i>
                                <span>بطاقة ائتمان / مدى</span>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="bank_transfer">
                                <i class="fas fa-university"></i>
                                <span>حوالة بنكية</span>
                            </label>
                        </div>
                        
                        <button type="submit" name="place_order" class="btn btn-primary">
                            <i class="fas fa-shipping-fast" style="margin-left: 10px;"></i> تأكيد الطلب والدفع
                        </button>
                    </form>
                </div>
                
                <div class="checkout-summary">
                    <h2>ملخص الطلب</h2>
                    
                    <?php foreach($cart_items as $item): ?>
                        <div class="order-item">
                            <img src="admin/<?php echo htmlspecialchars($item['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                 class="order-item-img">
                            <div class="order-item-details">
                                <h4 class="order-item-title"><?php echo htmlspecialchars($item['name']); ?></h4>
                                <div class="order-item-quantity">
                                    الكمية: <?php echo htmlspecialchars($item['quantity']); ?>
                                </div>
                                <div class="order-item-price">
                                    <?php echo number_format($item['price'], 2); ?> ر.س × 
                                    <?php echo htmlspecialchars($item['quantity']); ?> = 
                                    <?php echo number_format($item['price'] * $item['quantity'], 2); ?> ر.س
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="order-summary-total">
                        <span><i class="fas fa-receipt" style="margin-left: 10px;"></i> المجموع الكلي:</span>
                        <span><?php echo number_format($grand_total, 2); ?> ر.س</span>
                    </div>
                    
                    <div style="margin-top: 30px; padding: 20px; background: linear-gradient(45deg, rgba(255,127,0,0.1), rgba(255,160,64,0.1)); border-radius: 15px;">
                        <h4 style="color: var(--primary); margin-bottom: 10px;">
                            <i class="fas fa-info-circle" style="margin-left: 10px;"></i> معلومات مهمة
                        </h4>
                        <p style="color: var(--text-light); font-size: 0.9rem; line-height: 1.6;">
                            • سيتم التواصل معك خلال 24 ساعة لتأكيد الطلب<br>
                            • مدة التوصيل من 3-7 أيام عمل<br>
                            • يمكنك تتبع طلبك من خلال حسابك الشخصي
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        // Show success popup if order was just placed
        <?php if($show_success_popup): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.querySelector('.overlay');
            const popup = document.querySelector('.success-popup');
            
            overlay.classList.add('show');
            popup.classList.add('show');
            
            // Add celebration effect
            createConfetti();
        });
        <?php endif; ?>
        
        // Close popup when clicking outside
        document.querySelector('.overlay').addEventListener('click', function() {
            this.classList.remove('show');
            document.querySelector('.success-popup').classList.remove('show');
        });
        
        // Add focus effects to form inputs
        const formInputs = document.querySelectorAll('.form-control');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if(this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
        
        // Add ripple effect to buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
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
        
        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            .form-group.focused label {
                color: var(--primary);
                transform: translateX(-5px);
            }
        `;
        document.head.appendChild(style);
        
        // Confetti effect for success
        function createConfetti() {
            const colors = ['#FF7F00', '#FFA040', '#FFD700', '#10B981', '#3B82F6'];
            
            for(let i = 0; i < 100; i++) {
                const confetti = document.createElement('div');
                confetti.style.cssText = `
                    position: fixed;
                    width: 10px;
                    height: 10px;
                    background: ${colors[Math.floor(Math.random() * colors.length)]};
                    border-radius: 50%;
                    top: -20px;
                    left: ${Math.random() * 100}vw;
                    z-index: 1001;
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
        
        // Auto-format phone number
        const phoneInput = document.getElementById('phone');
        if(phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = this.value.replace(/\D/g, '');
                if(value.length > 0) {
                    value = '+966 ' + value;
                }
                this.value = value;
            });
        }
    </script>
</body>
</html>