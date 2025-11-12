<?php
include 'config.php';
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
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enfinty Energy</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="css/style1.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Color Scheme */
        :root {
            --primary: #FF7F00; /* Vibrant orange (main brand color) */
            --primary-light: #FFA040; /* Lighter orange */
            --primary-dark: #E67300; /* Darker orange */
            --secondary: #2C3E50; /* Dark blue-gray */
            --accent: #E8F4F8; /* Light blue background */
            --text: #333333; /* Main text color */
            --text-light: #7F8C8D; /* Secondary text */
            --white: #FFFFFF;
        }

        /* Base Styles */
        body {
            font-family: 'Tajawal', Arial, sans-serif;
            color: var(--text);
            line-height: 1.6;
        }
        
        /* Header Styles */
        .header {
            background-color: var(--secondary);
            color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header span {
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .header a {
            color: var(--white);
            text-decoration: none;
            margin-right: 20px;
            transition: color 0.3s;
        }
        
        .header a:hover {
            color: var(--primary);
        }

        .login-btn {
            background-color: var(--white);
            color: var(--secondary);
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
        }

        .login-btn:hover {
            background-color: var(--primary);
            color: var(--white);
        }
        
        /* Hero Section */
        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            gap: 3rem;
        }
        
        .content {
            flex: 1;
        }
        
        .content h1 {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 1.5rem;
            line-height: 1.3;
        }
        
        .content p {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 2rem;
            max-width: 600px;
        }
        
        .button {
            display: inline-block;
            background-color: var(--primary);
            color: var(--white);
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            border: 2px solid var(--primary);
        }
        
        .button:hover {
            background-color: transparent;
            color: var(--primary);
        }
        
        .image-container {
            flex: 1;
            text-align: center;
        }
        
        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        /* Benefits Section */
        .benefits-section {
            padding: 5rem 2rem;
            background-color: var(--white);
        }
        
        .section-title {
            text-align: center;
            font-size: 2.2rem;
            margin-bottom: 3rem;
            color: var(--secondary);
            position: relative;
        }
        
        .section-title:after {
            content: "";
            display: block;
            width: 80px;
            height: 4px;
            background: var(--primary);
            margin: 1rem auto 0;
        }
        
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .benefit-card {
            background: var(--white);
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border-top: 4px solid var(--primary);
        }
        
        .benefit-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .benefit-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .benefit-title {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            color: var(--secondary);
        }
        
        .benefit-desc {
            color: var(--text-light);
            line-height: 1.7;
        }
        
        /* Alternate Section */
        .alt-section {
            background-color: var(--accent);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            margin: 0;
            color: var(--primary);
            font-size: 1.5rem;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #777;
        }

        .login-form .input-group {
            margin-bottom: 15px;
        }

        .login-form input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }

        .login-form input:focus {
            border-color: var(--primary);
            outline: none;
        }

        .login-form .btn {
            width: 100%;
            padding: 12px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .login-form .btn:hover {
            background-color: var(--primary-dark);
        }

        .modal-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .modal-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        /* Error Messages */
        .message {
            padding: 10px;
            background: #f44336;
            color: white;
            text-align: center;
            margin: 10px 0;
            border-radius: 5px;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1001;
            max-width: 90%;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .container {
                flex-direction: column;
                text-align: center;
            }
            
            .content p {
                margin-left: auto;
                margin-right: auto;
            }
            
            .benefits-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
            }
            
            .header div {
                margin-top: 0.5rem;
            }
            
            .content h1 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .benefits-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Error messages -->
    <?php
    if(isset($message)){
        foreach($message as $message){
            echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
        }
    }
    ?>

    <div class="header">
        <span>🌞 Enfinty Energy</span>
        <div>
            <a href="index.php">الرئيسية</a>
            <button class="login-btn" onclick="showModal('login')">تسجيل الدخول</button>
        </div>
    </div>
    
    <div class="container">
        <div class="content">
            <h1>منذ اللحظة الأولى لبدايتنا ونحن نسعى لتوفير أفضل حلول الطاقة الشمسية</h1>
            <p>مهما كانت الحلول والبدائل التي تبحث عنها، فبالتأكيد سوف تلبي المنتجات عالية الجودة الخاصة بنا كافة احتياجاتك.</p>
            <div class="cta-buttons">
                <a href="login.php" class="button">ابدأ الآن →</a>
                <button onclick="scrollToBottom()" class="button">اعرف المزيد</button>
                <a href="" class="button" style="background-color: transparent; color: var(--primary); margin-right: 15px;"> تواصل معنا ✆ : 0100000000</a>
            </div>
        </div>
        <div class="image-container">
            <img src="IMAGES/sad.jpg" alt="الطاقة الشمسية">
        </div>
    </div>
    
    <!-- Benefits Section -->
    <section class="benefits-section">
        <h2 class="section-title">فوائد الطاقة الشمسية</h2>
        
        <div class="benefits-grid">
            <!-- Benefit 1 -->
            <div class="benefit-card">
                <div class="benefit-icon">🌱</div>
                <h3 class="benefit-title">بيئة نظيفة</h3>
                <p class="benefit-desc">توفير بيئة خالية من التلوث حيث أن الطاقة الشمسية لا تنتج أي انبعاثات ضارة أو غازات دفيئة</p>
            </div>
            
            <!-- Benefit 2 -->
            <div class="benefit-card">
                <div class="benefit-icon">🏠</div>
                <h3 class="benefit-title">تحكم منزلي</h3>
                <p class="benefit-desc">تمكنك من تدفئة وتبريد المنازل بكفاءة عالية مع توفير في استهلاك الطاقة</p>
            </div>
            
            <!-- Benefit 3 -->
            <div class="benefit-card">
                <div class="benefit-icon">♻️</div>
                <h3 class="benefit-title">طاقة متجددة</h3>
                <p class="benefit-desc">استبدال مصادر الطاقة غير المتجددة بمصدر طاقة متجدد وآمن لا ينضب</p>
            </div>
            
            <!-- Benefit 4 -->
            <div class="benefit-card">
                <div class="benefit-icon">💰</div>
                <h3 class="benefit-title">توفير مالي</h3>
                <p class="benefit-desc">انخفاض فواتير الكهرباء بشكل كبير مع عائد استثمار ممتاز على المدى الطويل</p>
            </div>
            
            <!-- Benefit 5 -->
            <div class="benefit-card">
                <div class="benefit-icon">🛠️</div>
                <h3 class="benefit-title">صيانة قليلة</h3>
                <p class="benefit-desc">عدم الحاجة لصيانة متكررة وتكاليف صيانة مرتفعة مقارنة بمصادر الطاقة التقليدية</p>
            </div>
            
            <!-- Benefit 6 -->
            <div class="benefit-card">
                <div class="benefit-icon">🔋</div>
                <h3 class="benefit-title">استقلالية</h3>
                <p class="benefit-desc">الحصول على استقلال طاقوي وعدم التأثر بانقطاعات التيار الكهربائي أو تقلبات الأسعار</p>
            </div>
        </div>
    </section>
    
    <!-- Solar Calculation Section -->
    <section class="benefits-section alt-section">
        <h2 class="section-title">كيفية حساب استهلاك الطاقة الشمسية</h2>
        
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">🧮</div>
                <h3 class="benefit-title">حساب الاستهلاك اليومي</h3>
                <p class="benefit-desc">جمع استهلاك جميع الأجهزة بالواط/ساعة ثم قسمة الناتج على ساعات التشغيل اليومية</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">☀️</div>
                <h3 class="benefit-title">ساعات السطوع الشمسي</h3>
                <p class="benefit-desc">تحديد متوسط ساعات السطوع الشمسي في منطقتك لمعرفة إنتاجية الألواح</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">🔌</div>
                <h3 class="benefit-title">حجم النظام</h3>
                <p class="benefit-desc">(الاستهلاك اليومي ÷ ساعات السطوع) × 1.3 (عامل أمان) = واط الألواح المطلوبة</p>
            </div>
        </div>
    </section>
    
    <!-- What is Solar Energy Section -->
    <section class="benefits-section">
        <h2 class="section-title">ما هي الطاقة الشمسية؟</h2>
        
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">⚡</div>
                <h3 class="benefit-title">تعريف الطاقة الشمسية</h3>
                <p class="benefit-desc">طاقة متجددة نظيفة مصدرها أشعة الشمس يتم تحويلها إلى طاقة كهربائية أو حرارية</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">🖥️</div>
                <h3 class="benefit-title">كيف تعمل؟</h3>
                <p class="benefit-desc">الألواح الضوئية تحول ضوء الشمس إلى تيار مستمر، العاكس يحوله إلى تيار متردد للاستخدام المنزلي</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">🌐</div>
                <h3 class="benefit-title">أنظمة الطاقة الشمسية</h3>
                <p class="benefit-desc">1- أنظمة مرتبطة بالشبكة 2- أنظمة مستقلة 3- أنظمة هجينة تجمع بين المصدرين</p>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>تسجيل الدخول</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <form class="login-form" action="" method="post">
                <div class="input-group">
                    <input type="email" name="email" required placeholder="البريد الإلكتروني">
                </div>
                <div class="input-group">
                    <input type="password" name="password" required placeholder="كلمة المرور">
                </div>
                <button type="submit" name="submit" class="btn">تسجيل الدخول</button>
            </form>
            <div class="modal-footer">
                ليس لديك حساب؟ <a href="register.php">إنشاء حساب جديد</a>
            </div>
        </div>
    </div>

    <script>
        function scrollToBottom() {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        }

        // Show the specified modal
        function showModal(modalType) {
            closeModal(); // Close any open modals
            
            if(modalType === 'login') {
                document.getElementById('loginModal').style.display = 'flex';
            }
            
            document.body.style.overflow = 'hidden';
        }

        // Close all modals
        function closeModal() {
            document.getElementById('loginModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                closeModal();
            }
        });

        // Close modal with ESC key
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>