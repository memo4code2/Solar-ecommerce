<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infinite Energy | لوحة التحكم</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <div class="logo-container">
            
                <h1> 🌞 Infinite Energy</h1>
                
            </div>
            <nav class="admin-nav">
                <a href="#" class="nav-link active"><i class="fas fa-plus-circle"></i> إضافة منتج</a>
                <a href="products.php" class="nav-link"><i class="fas fa-box-open"></i> عرض المنتجات</a>
                <a href="orders.php" class="nav-link"><i class="fas fa-box-open"></i> عرض الطلبات</a>

                
            </nav>
        </header>
        
        <main class="admin-main">
            <div class="form-container">
                <h2><i class="fas fa-plus"></i> إضافة منتج جديد</h2
                >

                
                <form action="insert.php" method="post" enctype="multipart/form-data" class="product-form">
                    <div class="form-group">
                        <label for="name">اسم المنتج</label>
                        <input type="text" id="name" name="name" placeholder="أدخل اسم المنتج" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">السعر</label>
                        <input type="text" id="price" name="price" placeholder="أدخل سعر المنتج" required>
                    </div>
                    
                    <div class="form-group file-upload">
                        <input type="file" id="file" name="image" accept="image/*" required>
                        <label for="file" class="upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>اختر صورة للمنتج</span>
                        </label>
                        <div class="file-name" id="file-name">لم يتم اختيار صورة بعد</div>
                    </div>
                    
                    <button type="submit" name="upload" class="submit-btn">
                        <i class="fas fa-upload"></i> رفع المنتج
                    </button>
                </form>
            </div>
        </main>
        
        <footer class="admin-footer">
         
        </footer>
    </div>

    <script>
        // Display selected file name
        document.getElementById('file').addEventListener('change', function(e) {
            const fileName = e.target.files.length ? e.target.files[0].name : 'لم يتم اختيار صورة بعد';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</body>
</html>