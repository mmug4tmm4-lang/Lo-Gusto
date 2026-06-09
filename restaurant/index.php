<?php
session_start();
include 'db.php';


$categories_result = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مطعم لو غوستو الفاخر | Le Gusto 🍽️</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; direction: rtl; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        
        
        .hero-banner { 
            background: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200&auto=format&fit=crop'); 
            background-size: cover; 
            background-position: center; 
            color: white; 
            text-align: center; 
            padding: 80px 20px; 
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            position: relative;
        }
        .hero-banner h1 { 
            font-size: 48px; 
            margin: 0 0 15px 0; 
            font-family: 'Cairo', sans-serif; 
            letter-spacing: 2px;
            text-shadow: 2px 4px 10px rgba(0,0,0,0.5);
            color: #f39c12; /* لون ذهبي فخم */
        }
        .hero-banner p { 
            font-size: 20px; 
            margin: 0; 
            opacity: 0.9; 
            font-weight: 300;
            text-shadow: 1px 2px 5px rgba(0,0,0,0.5);
        }
        .luxury-badge {
            background: rgba(243, 156, 18, 0.2);
            border: 1px solid #f39c12;
            color: #f39c12;
            padding: 6px 18px;
            border-radius: 20px;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 15px;
            font-weight: bold;
        }

        
        .top-bar { max-width: 1200px; margin: 20px auto 0 auto; padding: 0 20px; text-align: left; }
        .admin-btn { display: inline-block; background: #007bff; color: white; text-decoration: none; padding: 10px 22px; border-radius: 25px; font-weight: bold; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,123,255,0.2); }
        .admin-btn:hover { background: #0056b3; transform: translateY(-2px); }
        
        
        .category-section { background: white; padding: 25px; border-radius: 20px; margin-bottom: 40px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); clear: both; border: 1px solid #f1f2f6; }
        .category-title { color: #2c3e50; border-bottom: 3px solid #f39c12; padding-bottom: 8px; margin-top: 0; font-size: 26px; display: inline-block; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px; margin-top: 25px; }
        .menu-card { background: #fff; border: 1px solid #f1f2f6; border-radius: 16px; overflow: hidden; text-align: center; padding-bottom: 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); transition: all 0.3s ease; position: relative; }
        .menu-card:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); border-color: #f39c12; }
        
        
        
.item-img { 
    width: 100%; 
    height: 180px; 
    object-fit: contain; 
    background-color: #f8f9fa; 
    padding: 10px; 
    box-sizing: border-box;
}
        .no-img { width: 100%; height: 180px; display: flex; align-items: center; justify-content: center; background: #e9ecef; color: #6c757d; font-size: 14px; }
        
        .item-name { font-size: 19px; font-weight: bold; color: #2c3e50; margin: 15px 12px 5px 12px; }
        .item-price { font-size: 17px; color: #27ae60; font-weight: bold; margin-bottom: 10px; }
        .actions { margin-top: 10px; padding: 0 10px; }
        .btn-edit { display: inline-block; background: #ffc107; color: #212529; text-decoration: none; padding: 7px 18px; border-radius: 8px; font-size: 14px; font-weight: bold; transition: 0.2s; }
        .btn-edit:hover { background: #e0a800; }
    </style>
</head>
<body>


<div class="hero-banner">
    <div class="luxury-badge">💎 حيث تلتقي الفخامة بالمذاق الرفيع</div>
    <h1>مطعم لو غوستو | LE GUSTO</h1>
    <p>أهلاً بكِ في قائمة طعامنا الرقمية الذكية.. نأخذكِ في رحلة استثنائية لأشهى المأكولات والمشروبات</p>
</div>

<div class="top-bar">
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="logout.php" class="admin-btn" style="background:#dc3545; margin-right: 10px; box-shadow: 0 4px 10px rgba(220,53,69,0.2);">🚪 تسجيل الخروج</a>
        <a href="add_item.php" class="admin-btn" style="background:#27ae60; box-shadow: 0 4px 10px rgba(39,174,96,0.2);">➕ إضافة وجبة جديدة</a>
    <?php else: ?>
       
    <?php endif; ?>
</div>

<div class="container">
    <?php
    if ($categories_result->num_rows > 0) {
        while($category = $categories_result->fetch_assoc()) {
            $category_id = $category['id'];
            
        
            $items_result = $conn->query("SELECT * FROM menu_items WHERE category_id = '$category_id'");
            
            if ($items_result->num_rows > 0) {
                echo "<div class='category-section'>";
                echo "<h2 class='category-title'>📂 " . $category['category_name'] . "</h2>";
                echo "<div class='menu-grid'>";
                
                while($item = $items_result->fetch_assoc()) {
                    echo "<div class='menu-card'>";
                    
                
                    if (!empty($item['image']) && file_exists("images/" . $item['image'])) {
                        echo "<img src='images/" . $item['image'] . "' class='item-img' alt='" . $item['item_name'] . "'>";
                    } else {
                        echo "<div class='no-img'>📸 لا توجد صورة حالياً</div>";
                    }
                    
                    echo "<div class='item-name'>" . $item['item_name'] . "</div>";
                    echo "<div class='item-price'>" . $item['price'] . " شيكل</div>";
                    
       if (isset($_SESSION['user_id'])) {
                    echo "<div class='actions'>";
                    echo "<a href='edit_item.php?id=" . $item['id'] . "' class='btn-edit' style='display:inline-block; width:120px; background-color:#f39c12; color:white; text-decoration:none; padding:6px 10px; border-radius:5px; margin-bottom:5px; font-weight:bold; font-size:14px; text-align:center;'>✏️ تعديل الوجبة</a><br>";
                    echo "<a href='delete_item.php?id=" . $item['id'] . "' onclick='return confirm(\"هل أنتِ متأكدة من حذف هذه الوجبة؟\");' style='display:inline-block; width:120px; background-color:#e74c3c; color:white; text-decoration:none; padding:6px 10px; border-radius:5px; font-weight:bold; font-size:14px; text-align:center;'>❌ حذف الوجبة</a>";
                    echo "</div>";
                } else {
                    echo "<div class='actions'>";
                    echo "<a href='order.php?item_name=" . urlencode($item['item_name']) . "&price=" . $item['price'] . "' style='display:inline-block; width:120px; background-color:#27ae60; color:white; text-decoration:none; padding:8px 12px; border-radius:5px; font-weight:bold; font-size:14px; text-align:center;'>🛒 اطلب الآن</a>";
                    echo "</div>";
                }

                echo "</div>"; 
            } 
            echo "</div>"; 
        } 
        echo "</div>"; 
    } 
} else {
    echo "<p style='text-align:center; font-size:18px;'>لا توجد أقسام مضافة حالياً في قاعدة البيانات</p>";
}
    ?>
</div>

</body>
</html>