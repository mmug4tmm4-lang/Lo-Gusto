<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: admin.php");
    exit();
}

include 'db.php';

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];
    $sql = "SELECT * FROM menu_items WHERE id = '$item_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        header("Location: index.php");
        exit();
    }
}


if (isset($_POST['update_btn'])) {
    $id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    
    $image_name = $item['image'];
    
    
    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] == 0) {
        $image_name = time() . "_" . $_FILES['item_image']['name'];
        $target_file = "images/" . $image_name;
        move_uploaded_file($_FILES['item_image']['tmp_name'], $target_file);
    }
    
    $sql_update = "UPDATE menu_items SET item_name='$item_name', price='$price', category_id='$category_id', image='$image_name' WHERE id='$id'";
    
    if ($conn->query($sql_update) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        $error = "حدث خطأ أثناء التعديل: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل الوجبة مع الصورة ✏️</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f8f9fa; padding: 30px; direction: rtl; }
        .form-container { max-width: 400px; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin: 0 auto; }
        h2 { text-align: center; color: #333; margin-top: 0; }
        label { font-weight: bold; display: block; margin-top: 15px; color: #555; }
        .form-control { width: 100%; padding: 10px; margin-top: 5px; border: 2px solid #eaeaea; border-radius: 6px; box-sizing: border-box; font-size: 15px; }
        .form-control:focus { border-color: #ffc107; outline: none; }
        .btn-submit { background: #007bff; color: white; border: none; padding: 12px; width: 100%; border-radius: 6px; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 20px; }
        .btn-submit:hover { background: #0056b3; }
        .back-link { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #555; font-weight: bold; }
        .current-img-box { margin-top: 10px; text-align: center; }
        .current-img { max-width: 120px; height: 80px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; }
    </style>
</head>
<body>

<div class="form-container">
    <a href="index.php" class="back-link">⬅️ العودة للرئيسية</a>
    <h2>✏️ تعديل بيانات الوجبة</h2>

    <?php if(isset($error)) { echo "<p style='color:red; text-align:center;'>$error</p>"; } ?>

    <form action="edit_item.php?id=<?php echo $item['id']; ?>" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">

        <label>اسم الوجبة:</label>
        <input type="text" name="item_name" class="form-control" value="<?php echo $item['item_name']; ?>" required>

        <label>السعر (شيكل):</label>
        <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $item['price']; ?>" required>

        <label>القسم:</label>
        <select name="category_id" class="form-control" required>
            <?php
            $cats = $conn->query("SELECT * FROM categories");
            while($cat = $cats->fetch_assoc()) {
                $selected = ($cat['id'] == $item['category_id']) ? "selected" : "";
                echo "<option value='".$cat['id']."' $selected>📂 ".$cat['category_name']."</option>";
            }
            ?>
        </select>

        <label>📸 اختيار صورة الوجبة:</label>
        <input type="file" name="item_image" class="form-control" accept="image/*">
        
        <?php if(!empty($item['image'])): ?>
            <div class="current-img-box">
                <span style="font-size: 12px; color: #777; display:block; margin-bottom:5px;">الصورة الحالية:</span>
                <img src="images/<?php echo $item['image']; ?>" class="current-img">
            </div>
        <?php endif; ?>

        <button type="submit" name="update_btn" class="btn-submit">💾 حفظ التعديلات</button>
    </form>
</div>

</body>
</html>