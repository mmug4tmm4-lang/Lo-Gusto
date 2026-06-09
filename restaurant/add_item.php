<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';


if (isset($_POST['add_item_btn'])) {
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id']; 
    
    
    $query_insert = "INSERT INTO menu_items (item_name, price, category_id) VALUES ('$item_name', '$price', '$category_id')";
    
    if ($conn->query($query_insert) === TRUE) {
        $success_msg = "تم إضافة الوجبة بنجاح! ";
    } else {
        $error_msg = "حدث خطأ أثناء الإضافة: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة وجبة جديدة - نظام المطعم</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 30px;">

    <h2>إضافة وجبة جديدة للمطعم 🍔🍟</h2>
    <a href="index.php" style="text-decoration: none; color: blue;">⬅️ العودة للرئيسية</a>
    <br><br>

    <?php if (isset($success_msg)) { echo "<p style='color:green; font-weight:bold;'>$success_msg</p>"; } ?>
    <?php if (isset($error_msg)) { echo "<p style='color:red; font-weight:bold;'>$error_msg</p>"; } ?>

    <form action="add_item.php" method="POST" style="background: #f9f9f9; padding: 20px; border-radius: 8px; max-width: 40px0px; border: 1px solid #ccc;">
        
        <label>اسم الوجبة/الأكلة:</label><br>
        <input type="text" name="item_name" required style="width: 90%; padding: 8px; margin-top: 5px;"><br><br>

        <label>السعر (شيكل):</label><br>
        <input type="number" step="0.01" name="price" required style="width: 90%; padding: 8px; margin-top: 5px;"><br><br>

        <label>اختر قسم الوجبة:</label><br>
        <select name="category_id" required style="width: 95%; padding: 8px; margin-top: 5px;">
            <option value="">-- اختر القسم الخاص للوجبة --</option>
            <?php
     
            $sql_cats = "SELECT * FROM categories";
            $res_cats = $conn->query($sql_cats);
            while($cat = $res_cats->fetch_assoc()) {
                
                echo "<option value='" . $cat['id'] . "'>" . $cat['category_name'] . "</option>";
            }
            ?>
        </select><br><br>

        <button type="submit" name="add_item_btn" style="background: green; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">حفظ الوجبة في القائمة</button>
        
    </form>

</body>
</html>