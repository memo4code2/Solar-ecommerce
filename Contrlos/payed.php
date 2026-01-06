<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شكراً لتواصلك معنا</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary: #2c3e50;
        --secondary: #3498db;
        --success: #27ae60;
        --light: #f8f9fa;
        --dark: #343a40;
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
        background-color: #f5f7fa;
        color: var(--dark);
        line-height: 1.6;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        max-width: 800px;
        width: 100%;
        text-align: center;
    }

    .logo {
        width: 120px;
        margin-bottom: 30px;
    }

    .main-content {
        background: white;
        padding: 40px;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        position: relative;
    }

    .notification-popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        max-width: 90%;
        width: 400px;
        text-align: center;
        animation: popIn 0.5s ease forwards;
    }

    @keyframes popIn {
        0% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
        100% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
    }

    .notification-icon {
        font-size: 60px;
        color: var(--success);
        margin-bottom: 20px;
    }

    .notification-title {
        font-size: 24px;
        margin-bottom: 15px;
        color: var(--primary);
    }

    .notification-message {
        font-size: 18px;
        margin-bottom: 25px;
        color: var(--dark);
    }

    .btn {
        display: inline-block;
        padding: 12px 30px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-size: 16px;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn:hover {
        background: var(--secondary);
        transform: translateY(-3px);
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(3px);
        z-index: 999;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .main-content {
            padding: 30px 20px;
        }
        
        .notification-popup {
            width: 90%;
            padding: 25px 20px;
        }
        
        .notification-icon {
            font-size: 50px;
        }
        
        .notification-title {
            font-size: 22px;
        }
        
        .notification-message {
            font-size: 16px;
        }
    }
    </style>
</head>
<body>
    <div class="container">
       <a href="index.php">العودة مرة اخري </a>
        
        <div class="main-content">
            <h1>مرحباً بكم في موقعنا</h1>
            <p>هذه صفحة تأكيد استلام المعلومات، سيظهر لك إشعار تأكيد عند زيارتك لهذه الصفحة</p>
        </div>
    </div>

    <!-- Notification Popup -->
    <div class="overlay" id="overlay"></div>
    <div class="notification-popup" id="notificationPopup">
        <div class="notification-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2 class="notification-title">شكراً لك!</h2>
        <p class="notification-message">تم تسجيل معلوماتك سيتم التواصل معك في أقرب وقت :)</p>
        <button class="btn" onclick="closeNotification()">حسناً</button>
    </div>

    <script>
        // Show notification popup when page loads
        window.onload = function() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('notificationPopup').style.display = 'block';
        };

        // Close notification function
        function closeNotification() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('notificationPopup').style.display = 'none';
            
            // Optional: Redirect after closing
            // window.location.href = "index.php";
        }

        // Close when clicking outside the popup
        document.getElementById('overlay').addEventListener('click', closeNotification);
    </script>
</body>
</html>