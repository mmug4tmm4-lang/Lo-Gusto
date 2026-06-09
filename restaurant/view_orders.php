<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: admin.php");
    exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة طلبات الزبائن</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4;">

    <h2>📋 قائمة طلبات المطعم الحالية</h2>
    <a href="index.php" style="text-decoration: none; font-weight: bold; color: #333;">⬅️ العودة للصفحة الرئيسية</a>
    <br><br>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; background: white;">
        <tr style="background-color: #333; color: white;">
            <th>رقم الطلب</th>
            <th>اسم الوجبة</th>
            <th>اسم الزبون</th>
            <th>رقم الهاتف</th>
            <th>العنوان</th>
            <th>إجمالي الحساب</th>
            <th>تاريخ الطلب</th>
        </tr>

<?php
$sql = "SELECT 
            orders.id AS order_id,
            orders.customer_name,
            orders.customer_phone,
            orders.customer_address,
            orders.total_price,
            orders.order_date,
            menu_items.item_name
        FROM orders
        LEFT JOIN order_details ON orders.id = order_details.order_id
        LEFT JOIN menu_items ON order_details.menu_item_id = menu_items.id
        ORDER BY orders.id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['order_id'] . "</td>";
        echo "<td style='font-weight:bold; color:#d35400;'>" . $row['item_name'] . "</td>";
        echo "<td>" . (isset($row['customer_name']) ? $row['customer_name'] : '') . "</td>";
        echo "<td>" . (isset($row['customer_phone']) ? $row['customer_phone'] : '') . "</td>";
        echo "<td>" . (isset($row['customer_address']) ? $row['customer_address'] : '') . "</td>";
        echo "<td style='color: green; font-weight: bold;'>$" . $row['total_price'] . "</td>";
        echo "<td>" . $row['order_date'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7' style='text-align:center; color: gray;'>لا توجد طلبات مسجلة حالياً في النظام</td></tr>";
}
?>
    </table>

</body>
</html>