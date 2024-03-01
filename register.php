<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    
    // Check if the email is already registered
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingUser) {
        $_SESSION['error'] = "هذا البريد الإلكتروني مسجل بالفعل";
    } else {
        // Insert new user into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password,phone) VALUES (?, ?, ?,?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        if ($stmt->execute([$name, $email, $hashedPassword,$phone])) {
            $_SESSION['success'] = "تم تسجيل الحساب بنجاح";
            header("Location: login.php"); // Redirect to the login page
            exit();
        } else {
            $_SESSION['error'] = "حدثت مشكلة أثناء تسجيل الحساب";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل حساب جديد</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .profile {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body class="container d-lg-flex justify-content-center py-1">
    <div class="col-12 col-md-4 p-2 border border-primary rounded-2" id="main">
        <div class="row m-0">
            <div class="col-12 bg-hint rounded-top-2 d-flex flex-column justify-content-center align-items-center">
                <h2 class="text-center txt-app d-inline"> تسجيل حساب جديد </h2>
                <img src="images/profile.png" class="profile">
            </div>
            <div class="col-12 rounded-2 p-3 border-black p-2">
                <form method="post" action="register.php">
                    <div class="list-unstyled mb-0">
                        <span class="m-2">الاسم</span>
                    </div>
                    <div class="input-group border border-primary px-1 rounded bg-white">
                        <input type="text" name="name" class="form-control border-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-white border-0">
                                <i class="fa fa-user text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="list-unstyled mb-0">
                        <span class="m-2">البريد الإلكتروني</span>
                    </div>
                    <div class="input-group border border-primary px-1 rounded bg-white">
                        <input type="email" name="email" class="form-control border-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-white border-0">
                                <i class="fa fa-envelope text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="list-unstyled mb-0">
                        <span class="m-2"> رقم الهاتف</span>
                    </div>
                    <div class="input-group border border-primary px-1 rounded bg-white">
                        <input type="tel" name="phone" class="form-control border-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-white border-0">
                                <i class="fa fa-phone text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="list-unstyled d-flex align-items-center my-0">
                        <span class="m-2">كلمة المرور</span>
                    </div>
                    <div class="input-group border border-primary px-1 rounded bg-white">
                        <input type="password" name="password" class="form-control border-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-white border-0">
                                <i class="fa fa-lock text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class=" d-flex align-items-center flex-column">
                        <button type="submit" class="btn btn-md bg-primary my-3 text-white fw-bolder skip"> تسجيل الحساب </button>
                        <a href="login.php" class="fw-bolder text-primary mt-2 text-decoration-none"> لديك حساب بالفعل ؟ </a>
                    </div>
                    <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
                        <div class="bg-danger text-white rounded p-2" id="error">
                         <span class="fw-bold"><?php echo $_SESSION['error']; ?></span>
                        </div>
                    <?php elseif (isset($_SESSION['success']) && !empty($_SESSION['success'])): ?>
                        <div class="bg-success text-white rounded p-2" id="error">
                         <span class="fw-bold"><?php echo $_SESSION['success']; ?></span>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
