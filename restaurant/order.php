<?php
include 'db.php';

$item_name = isset($_GET['item_name']) ? $_GET['item_name'] : 'وجبة مختارة';
$price = isset($_GET['price']) ? $_GET['price'] : '0';

$menu_item_id = isset($_GET['item_id']) ? $_GET['item_id'] : 4;


if (isset($_POST['submit_order'])) {
    $total_price = $_POST['total_price'];
    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    
    $sql = "INSERT INTO orders (order_date, total_price, status, user_id, customer_name, customer_phone, customer_address) 
            VALUES (NOW(), '$total_price', 'قيد الانتظار', 1, '$customer_name', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        
        $order_id = $conn->insert_id;

        
        if (!isset($_GET['item_id'])) {
            $result_item = $conn->query("SELECT id FROM menu_items WHERE item_name = '$item_name' LIMIT 1");
            if ($result_item && $result_item->num_rows > 0) {
                $row_item = $result_item->fetch_assoc();
                $menu_item_id = $row_item['id'];
            }
        }

        
        $sql_details = "INSERT INTO order_details (order_id, menu_item_id, quantity, subtotal) 
                        VALUES ('$order_id', '$menu_item_id', 1, '$total_price')";
        $conn->query($sql_details);

        echo "<script>alert('🎉 تم إرسال طلبك بنجاح   !'); window.location.href='index.php';</script>";
    } else {
        echo "خطأ في السيرفر: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تأكيد طلب الوجبة 🛒</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f6f9; padding: 40px; direction: rtl; text-align: center; }
        .order-box { max-width: 500px; background: white; margin: 0 auto; padding: 30px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2 { color: #2c3e50; margin-bottom: 25px; }
        .info { background: #fff9e6; border: 1px solid #f39c12; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-weight: bold; color: #d35400; font-size: 18px; }
        label { display: block; text-align: right; margin-top: 15px; font-weight: bold; color: #333; }
        input[type="text"] { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; font-size: 16px; margin-top: 5px; }
        .btn-submit { background: #27ae60; color: white; border: none; padding: 14px 30px; border-radius: 25px; font-size: 16px; font-weight: bold; cursor: pointer; width: 100%; margin-top: 25px; }
    </style>
</head>
<body>

<div class="order-box">
    <h2>📝 تأكيد طلبكِ</h2>
    <div class="info">
        🍔 الوجبة: <?php echo htmlspecialchars($item_name); ?> <br>
        💰 السعر: <?php echo htmlspecialchars($price); ?> شيكل
    </div>

    <form action="order.php?item_name=<?php echo urlencode($item_name); ?>&price=<?php echo $price; ?>" method="POST">
        <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($price); ?>">

        <label>اسمكِ الكريم:</label>
        <input type="text" name="customer_name" required placeholder="أدخل اسمكِ بالكامل">

        <label>رقم الهاتف للاتصال:</label>
        <input type="text" name="phone" required placeholder="059xxxxxxx">

        <label>عنوان التوصيل:</label>
        <input type="text" name="address" required placeholder="المدينة، الشارع">

        <button type="submit" name="submit_order" class="btn-submit">🚀 تأكيد وإرسال الطلب</button>
    </form>
    <br>
    <a href="index.php" style="color: #7f8c8d; text-decoration: none;">⬅️ العودة للمنيو</a>
</div>

</body>
</html>