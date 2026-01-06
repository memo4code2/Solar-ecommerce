<?php  include ('Contrlos/check.php')     ?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enfinty Energy</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="css/style1.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="public/css/login.css">

    <style>
      
    </style>
</head>
<body>
    

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
            <form class="login-form" action="check.php" method="post">
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

    <script src="public/js/login.js" ></script>
</body>
</html>