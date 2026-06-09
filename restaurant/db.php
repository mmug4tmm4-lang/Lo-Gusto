<?php
$conn = new mysqli("localhost", "root", "", "restaurant");
if ($conn->connect_error){
    die("فشل بقاعدة البيانات: " . $conn->connect-error);
}
