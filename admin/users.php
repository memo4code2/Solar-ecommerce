<?php
include 'config.php';

// Check database connection
if (!$conn) {
    die('فشل الاتصال بقاعدة البيانات: ' . mysqli_connect_error());
}

$message = [];

// Get all users
$users_query = mysqli_query($conn, "SELECT * FROM `users` ORDER BY id DESC") or die('فشل الاستعلام');

// Delete user
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('فشل الاستعلام');
    $message[] = 'تم حذف المستخدم بنجاح!';
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - المستخدمين</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary: #2c3e50;
        --primary-light: #3d566e;
        --secondary: #3498db;
        --accent: #e74c3c;
        --success: #27ae60;
        --warning: #f39c12;
        --danger: #e74c3c;
        --light: #f8f9fa;
        --dark: #343a40;
        --gray: #6c757d;
        --border-radius: 8px;
        --box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
    }

    .admin-container {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar Styles */
    .admin-sidebar {
        width: 250px;
        background: var(--primary);
        color: white;
        padding: 20px 0;
        transition: var(--transition);
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-header img {
        width: 40px;
        margin-left: 10px;
    }

    .sidebar-header h2 {
        font-size: 18px;
        font-weight: 600;
    }

    .sidebar-menu {
        padding: 20px 0;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: white;
        text-decoration: none;
        transition: var(--transition);
        font-size: 15px;
    }

    .menu-item i {
        margin-left: 10px;
        font-size: 18px;
        width: 24px;
        text-align: center;
    }

    .menu-item:hover {
        background: rgba(255, 255, 255, 0.1);
        padding-right: 25px;
    }

    .menu-item.active {
        background: var(--accent);
        font-weight: 500;
    }

    /* Main Content Styles */
    .admin-main {
        flex: 1;
        padding: 25px;
        background-color: #f5f7fa;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .page-title {
        font-size: 24px;
        color: var(--primary);
        font-weight: 600;
    }

    .admin-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-user span {
        font-size: 15px;
    }

    .admin-user img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary);
    }

    /* Users Container */
    .users-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 25px;
        overflow-x: auto;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .users-table th {
        background: var(--primary);
        color: white;
        padding: 15px;
        text-align: right;
        font-weight: 500;
        position: sticky;
        top: 0;
    }

    .users-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        text-align: right;
    }

    .users-table tr:last-child td {
        border-bottom: none;
    }

    .users-table tr:hover {
        background: rgba(52, 152, 219, 0.05);
    }

    .user-id {
        font-weight: bold;
        color: var(--primary);
    }

    .user-name {
        font-weight: 500;
        color: var(--dark);
    }

    .user-email {
        color: var(--gray);
        direction: ltr;
        text-align: left;
    }

    .user-date {
        font-size: 14px;
        color: var(--gray);
    }

    .user-actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        padding: 8px 12px;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-size: 14px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .view-btn {
        background: var(--secondary);
        color: white;
    }

    .view-btn:hover {
        background: #2980b9;
        transform: translateY(-2px);
    }

    .delete-btn {
        background: var(--danger);
        color: white;
    }

    .delete-btn:hover {
        background: #c0392b;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: var(--gray);
    }

    .empty-state i {
        font-size: 50px;
        margin-bottom: 20px;
        color: #e0e0e0;
    }

    .empty-state h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: var(--dark);
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(3px);
    }

    .modal-content {
        background: white;
        width: 90%;
        max-width: 600px;
        border-radius: var(--border-radius);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        padding: 30px;
        animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .modal-title {
        font-size: 22px;
        color: var(--primary);
        font-weight: 600;
    }

    .close-modal {
        font-size: 24px;
        cursor: pointer;
        color: var(--gray);
        transition: var(--transition);
    }

    .close-modal:hover {
        color: var(--danger);
    }

    .user-details {
        margin-top: 20px;
    }

    .detail-group {
        margin-bottom: 20px;
    }

    .detail-label {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 8px;
        font-size: 15px;
    }

    .detail-value {
        padding: 12px;
        background: #f8f9fa;
        border-radius: var(--border-radius);
        border-left: 3px solid var(--primary);
    }

    /* Message Styles */
    .message {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: var(--success);
        color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        z-index: 1000;
        animation: slideIn 0.5s, fadeOut 0.5s 2.5s forwards;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .message i {
        font-size: 18px;
    }

    @keyframes slideIn {
        from { right: -100%; opacity: 0; }
        to { right: 20px; opacity: 1; }
    }

    @keyframes fadeOut {
        to { opacity: 0; }
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
        .admin-sidebar {
            width: 80px;
        }

        .sidebar-header h2, .menu-item span {
            display: none;
        }

        .menu-item {
            justify-content: center;
            padding: 12px 0;
        }

        .menu-item i {
            margin-left: 0;
        }
    }

    @media (max-width: 768px) {
        .admin-container {
            flex-direction: column;
        }

        .admin-sidebar {
            width: 100%;
            padding: 10px 0;
        }

        .sidebar-menu {
            display: flex;
            overflow-x: auto;
            padding: 0;
        }

        .menu-item {
            padding: 10px 15px;
            white-space: nowrap;
        }

        .admin-main {
            padding: 15px;
        }
    }
    </style>
</head>
<body>

<div class="admin-container">
    <div class="admin-sidebar">
        <div class="sidebar-header">
            <img src="images.png" alt="Logo">
            <h2>Infinite Energy</h2>
        </div>
        
        <div class="sidebar-menu">
            <a href="index.php" class="menu-item"><i class="fas fa-tachometer-alt"></i> <span>لوحة التحكم</span></a>
            <a href="products.php" class="menu-item"><i class="fas fa-box-open"></i> <span>المنتجات</span></a>
            <a href="orders.php" class="menu-item"><i class="fas fa-shopping-cart"></i> <span>الطلبات</span></a>
            <a href="users.php" class="menu-item active"><i class="fas fa-users"></i> <span>العملاء</span></a>
        </div>
    </div>

    <div class="admin-main">
        <div class="admin-header">
            <h1 class="page-title">إدارة العملاء</h1>
            
        </div>

        <?php if (!empty($message)): ?>
            <div class="message">
                <i class="fas fa-check-circle"></i>
                <span><?php echo $message[0]; ?></span>
            </div>
        <?php endif; ?>

        <div class="users-container">
            <?php if (mysqli_num_rows($users_query) > 0): ?>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>رقم المستخدم</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($users_query)): ?>
                            <tr>
                                <td class="user-id">#<?php echo htmlspecialchars($user['id']); ?></td>
                                <td class="user-name"><?php echo htmlspecialchars($user['name']); ?></td>
                                <td class="user-email"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="user-date">
                                    <?php echo !empty($user['created_at']) ? date('Y/m/d', strtotime($user['created_at'])) : 'غير متوفر'; ?>
                                </td>
                                <td class="user-actions">
                                    <a href="#" class="action-btn view-btn" onclick="openUserModal(<?php echo htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8'); ?>)">
                                        <i class="fas fa-eye"></i> عرض
                                    </a>
                                    <a href="users.php?delete=<?php echo htmlspecialchars($user['id']); ?>" class="action-btn delete-btn" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                        <i class="fas fa-trash"></i> حذف
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h3>لا يوجد عملاء مسجلين حتى الآن</h3>
                    <p>سيظهر هنا العملاء المسجلين في الموقع عند تسجيلهم</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- User Details Modal -->
<div class="modal" id="userModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">تفاصيل المستخدم #<span id="modalUserId"></span></h3>
            <span class="close-modal" onclick="closeModal()">&times;</span>
        </div>
        
        <div class="user-details">
            <div class="detail-group">
                <div class="detail-label">الاسم الكامل</div>
                <div class="detail-value" id="userFullName"></div>
            </div>
            
            <div class="detail-group">
                <div class="detail-label">البريد الإلكتروني</div>
                <div class="detail-value" id="userEmail"></div>
            </div>
            
            <div class="detail-group">
                <div class="detail-label">رقم الهاتف</div>
                <div class="detail-value" id="userPhone"></div>
            </div>
            
            <div class="detail-group">
                <div class="detail-label">تاريخ التسجيل</div>
                <div class="detail-value" id="userJoinDate"></div>
            </div>
            
            <div class="detail-group">
                <div class="detail-label">آخر نشاط</div>
                <div class="detail-value" id="userLastActivity"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function openUserModal(user) {
        document.getElementById('modalUserId').textContent = user.id;
        document.getElementById('userFullName').textContent = user.name || 'غير متوفر';
        document.getElementById('userEmail').textContent = user.email || 'غير متوفر';
        document.getElementById('userPhone').textContent = user.phone || 'غير متوفر';
        document.getElementById('userJoinDate').textContent = user.created_at ? new Date(user.created_at).toLocaleString('ar-SA') : 'غير متوفر';
        document.getElementById('userLastActivity').textContent = user.last_login ? new Date(user.last_login).toLocaleString('ar-SA') : 'غير معروف';

        document.getElementById('userModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('userModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal') {
            closeModal();
        }
    }

    // Auto-remove messages after 3 seconds
    setTimeout(() => {
        document.querySelectorAll('.message').forEach(msg => msg.remove());
    }, 3000);
</script>

</body>
</html>