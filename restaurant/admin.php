<?php
session_start();
include 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['login_btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit();
    } else {
        $error = "❌ اسم المستخدم أو كلمة المرور غير صحيحة!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول | مطعم النكهة الذهبية 🍔</title>
    <style>
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-container {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-sizing: border-box;
        }

        .login-container h2 {
            margin-bottom: 5px;
            color: #333;
            font-size: 24px;
        }

        .login-container p {
            color: #777;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .restaurant-logo {
            font-size: 50px;
            margin-bottom: 10px;
        }

        .form-group {
            text-align: right;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #eaeaea;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: #fda085;
            box-shadow: 0 0 8px rgba(253, 160, 133, 0.2);
        }

        .btn-login {
            background: linear-gradient(135deg, #fda085 0%, #f6d365 100%);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(253, 160, 133, 0.3);
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(253, 160, 133, 0.4);
        }

        .error-msg {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <div class="login-container">
        
        <div class="restaurant-logo">🍔</div>
        <h2>لوحة تحكم المدير</h2>
        <p>لو غوستو |LE GUSTO</p>

        
        <?php if(isset($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

       
        <form action="admin.php" method="POST">
            <div class="form-group">
                <label for="username">👤 اسم المستخدم:</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="أدخلي اسم المستخدم" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="password">🔒 كلمة المرور:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="أدخلي كلمة المرور" required>
            </div>

            <button type="submit" name="login_btn" class="btn-login"> تسجيل الدخول</button>
        </form>
    </div>

</body>
</html>