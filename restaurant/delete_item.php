<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: admin.php");
    exit();
}

include 'db.php';
 
if (isset($_GET['id'])) {
    $item_id = $_GET['id'];
    
    $sql_delete = "DELETE FROM menu_items WHERE id = '$item_id'";
    
    if ($conn->query($sql_delete) === TRUE) {
        
        header("Location: index.php");
        exit();
    } else {
        echo "حدث خطأ أثناء الحذف: " . $conn->error;
    }
} else {

    header("Location: index.php");
    exit();
}
?>