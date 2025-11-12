<?php
include 'config.php';
session_start();



// Get all orders from database
$orders_query = mysqli_query($conn, "SELECT * FROM `orders` ORDER BY order_date DESC") or die('query failed');

// Update order status
if(isset($_POST['update_status'])){
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    
    mysqli_query($conn, "UPDATE `orders` SET status = '$new_status' WHERE id = '$order_id'") or die('query failed');
    $message[] = 'تم تحديث حالة الطلب بنجاح!';
}
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - الطلبات</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #3498db;
        --accent-color: #e74c3c;
        --light-color: #ecf0f1;
        --dark-color: #2c3e50;
        --success-color: #2ecc71;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
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
        color: var(--dark-color);
        line-height: 1.6;
    }

    .admin-container {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar Styles */
    .admin-sidebar {
        width: 250px;
        background: var(--primary-color);
        color: white;
        padding: 20px 0;
        transition: var(--transition);
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
    }

    .menu-item i {
        margin-left: 10px;
        font-size: 18px;
    }

    .menu-item:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .menu-item.active {
        background: var(--accent-color);
    }

    /* Main Content Styles */
    .admin-main {
        flex: 1;
        padding: 20px;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .page-title {
        font-size: 24px;
        color: var(--primary-color);
    }

    .admin-user {
        display: flex;
        align-items: center;
    }

    .admin-user img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-left: 10px;
    }

    .logout-btn {
        color: var(--danger-color);
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .logout-btn i {
        margin-left: 5px;
    }

    /* Orders Table Styles */
    .orders-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 20px;
        overflow-x: auto;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table th {
        background: var(--primary-color);
        color: white;
        padding: 15px;
        text-align: right;
    }

    .orders-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        text-align: right;
    }

    .orders-table tr:last-child td {
        border-bottom: none;
    }

    .orders-table tr:hover {
        background: #f9f9f9;
    }

    .order-id {
        font-weight: bold;
        color: var(--secondary-color);
    }

    .customer-name {
        font-weight: 500;
    }

    .order-date {
        color: #777;
        font-size: 14px;
    }

    .order-total {
        font-weight: bold;
        color: var(--primary-color);
    }

    .status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-processing {
        background: #cce5ff;
        color: #004085;
    }

    .status-shipped {
        background: #d4edda;
        color: #155724;
    }

    .status-delivered {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .order-actions {
        display: flex;
        gap: 10px;
    }

    .action-btn {
        padding: 5px 10px;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-size: 14px;
        transition: var(--transition);
    }

    .view-btn {
        background: var(--secondary-color);
        color: white;
    }

    .view-btn:hover {
        background: #2980b9;
    }

    .update-btn {
        background: var(--warning-color);
        color: white;
    }

    .update-btn:hover {
        background: #e67e22;
    }

    .delete-btn {
        background: var(--danger-color);
        color: white;
    }

    .delete-btn:hover {
        background: #c0392b;
    }

    /* Order Details Modal */
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
    }

    .modal-content {
        background: white;
        width: 90%;
        max-width: 800px;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 30px;
        max-height: 90vh;
        overflow-y: auto;
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
        font-size: 20px;
        color: var(--primary-color);
    }

    .close-modal {
        font-size: 24px;
        cursor: pointer;
        color: #777;
    }

    .order-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .detail-group {
        margin-bottom: 15px;
    }

    .detail-label {
        font-weight: bold;
        color: var(--primary-color);
        margin-bottom: 5px;
    }

    .detail-value {
        padding: 10px;
        background: #f9f9f9;
        border-radius: var(--border-radius);
    }

    .products-list {
        margin-top: 20px;
    }

    .product-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }

    .product-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 5px;
        margin-left: 15px;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-weight: 500;
    }

    .product-price {
        color: var(--primary-color);
    }

    .status-form {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .status-select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        flex: 1;
    }

    .update-status-btn {
        background: var(--success-color);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: var(--border-radius);
        cursor: pointer;
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

    /* Responsive Styles */
    @media (max-width: 992px) {
        .admin-sidebar {
            width: 80px;
            overflow: hidden;
        }

        .sidebar-header h2, .menu-item span {
            display: none;
        }

        .menu-item {
            justify-content: center;
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

        .order-details-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <img src="images.png" alt="Logo">
                <h2>Infinite Energy</h2>
            </div>
            
            <div class="sidebar-menu">
                <a href="index.php" class="menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>لوحة التحكم</span>
                </a>
                <a href="products.php" class="menu-item">
                    <i class="fas fa-box-open"></i>
                    <span>المنتجات</span>
                </a>
                <a href="orders.php" class="menu-item active">
                    <i class="fas fa-shopping-cart"></i>
                    <span>الطلبات</span>
                </a>
                <a href="users.php" class="menu-item">
                    <i class="fas fa-users"></i>
                    <span>العملاء</span>
                </a>
                <a href="admin_logout.php" class="menu-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>تسجيل الخروج</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-main">
            <div class="admin-header">
                <h1 class="page-title">إدارة الطلبات</h1>
                <div class="admin-user">
                    <span>مرحباً، المشرف</span>
                    <img src="admin.png" alt="Admin">
                </div>
            </div>

            <?php
            if(isset($message)){
                foreach($message as $msg){
                    echo '<div class="message" onclick="this.remove();">'.$msg.'</div>';
                }
            }
            ?>

            <div class="orders-container">
                <?php if(mysqli_num_rows($orders_query) > 0): ?>
                    <table class="orders-table">
    <thead>
        <tr>
            <th>رقم الطلب</th>
            <th>العميل</th>
            <th>الهاتف</th> <!-- Added phone column -->
            <th>التاريخ</th>
            <th>المجموع</th>
            
        </tr>
    </thead>
    <tbody>
        <?php while($order = mysqli_fetch_assoc($orders_query)): ?>
            <tr>
                <td class="order-id">#<?php echo $order['id']; ?></td>
                <td class="customer-name"><?php echo $order['name']; ?></td>
                <td class="customer-phone"><?php echo $order['phone']; ?></td> <!-- Display phone -->
                <td class="order-date"><?php echo date('Y/m/d', strtotime($order['order_date'])); ?></td>
                <td class="order-total"><?php echo $order['total_price']; ?> ر.س</td>
                <td>
                    <!-- ... existing status code ... -->
                </td>
                <td class="order-actions">
                    <!-- ... existing action buttons ... -->
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
                <?php else: ?>
                    <div style="text-align: center; padding: 40px; color: #777;">
                        <i class="fas fa-shopping-cart" style="font-size: 50px; margin-bottom: 20px;"></i>
                        <h3>لا توجد طلبات حتى الآن</h3>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div class="modal" id="orderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">تفاصيل الطلب #<span id="modalOrderId"></span></h3>
                <span class="close-modal" onclick="closeModal()">&times;</span>
            </div>
            
            <div class="order-details-grid">
                <div>
                    <div class="detail-group">
                        <div class="detail-label">معلومات العميل</div>
                        <div class="detail-value">
                            <div><strong>الاسم:</strong> <span id="customerName"></span></div>
                            <div><strong>البريد الإلكتروني:</strong> <span id="customerEmail"></span></div>
                            <div><strong>الهاتف:</strong> <span id="customerPhone"></span></div>
                        </div>
                    </div>
                    
                    <div class="detail-group">
                        <div class="detail-label">عنوان التسليم</div>
                        <div class="detail-value" id="deliveryAddress"></div>
                    </div>
                </div>
                
                <div>
                    <div class="detail-group">
                        <div class="detail-label">معلومات الطلب</div>
                        <div class="detail-value">
                            <div><strong>تاريخ الطلب:</strong> <span id="orderDate"></span></div>
                            <div><strong>طريقة الدفع:</strong> <span id="paymentMethod"></span></div>
                            <div><strong>حالة الطلب:</strong> <span id="orderStatus"></span></div>
                            <div><strong>المجموع الكلي:</strong> <span id="orderTotal"></span> ر.س</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="products-list">
                <div class="detail-label">المنتجات المطلوبة</div>
                <div id="productsContainer"></div>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal" id="updateModal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h3 class="modal-title">تحديث حالة الطلب</h3>
                <span class="close-modal" onclick="closeModal()">&times;</span>
            </div>
            
            <form method="post" id="statusForm">
                <input type="hidden" name="order_id" id="updateOrderId">
                
                <div class="detail-group">
                    <label for="status" class="detail-label">حالة الطلب الجديدة</label>
                    <select name="status" id="status" class="status-select" required>
                        <option value="pending">قيد الانتظار</option>
                        <option value="processing">قيد التجهيز</option>
                        <option value="shipped">تم الشحن</option>
                        <option value="delivered">تم التسليم</option>
                        <option value="cancelled">ملغي</option>
                    </select>
                </div>
                
                <div class="status-form">
                    <button type="submit" name="update_status" class="update-status-btn">
                        <i class="fas fa-save"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Open order details modal
        function openOrderModal(order) 
            document.getElementById('modalOrderId').textContent = order.id;
            document.getElementById('customerName').textContent = order.name;
            document.getElementById('customerEmail').textContent = order.email;
            document.getElementById('customerPhone').textContent = order.phone;
            document.getElementById('deliveryAddress').textContent = order.address;
            document.getElementById('orderDate').textContent = new Date(order.order_date).toLocaleString();
            document.getElementById('paymentMethod').textContent = order.payment_method;
            document.getElementById('orderTotal').textContent = order.total_price;
            
            // Set status with proper label
            const statusLabels = {
                'pending': 'قيد الانتظار',
                'processing': 'قيد التجهيز',
                'shipped': 'تم الشحن',
                'delivered': 'تم التسليم',
                'cancelled': 'ملغي'
            };
            document.getElementById('orderStatus').text