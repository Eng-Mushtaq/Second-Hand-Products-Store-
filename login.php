<?php
session_start();
include('db_connection.php');
// Function to validate user credentials
function validateUser($email, $password, $pdo)
{
    $found = false;

    // Retrieve the user's record from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email ");
    $stmt->bindParam(':email', $email);

    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if a user with the given email exists
    if ($user !== false) {
        // Verify the password

        if (password_verify($password, $user['password'])) {
            $found = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['userid'] = $user['id'];
            $_SESSION['email'] = $user['email'];
        
        }
    }

    return $found;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  echo $email;

  $password = $_POST['password'];
  if (validateUser($email, $password, $pdo)) {
        header("Location: index.php");
        exit();
    
   
  } else {
    $error = "خطأ في بيانات تسجيل الدحول";
    $_SESSION['error']=$error;
  }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>توفير</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
     .profile{
    width: 100px;
    height: 100px;
   }


</style>
</head>
<body class="container d-lg-flex justify-content-center py-1">
    <div class="col-12 col-md-4 p-2 border border-primary rounded-2" id="main">
        <div class="row m-0">
            <div class="col-12 bg-hint rounded-top-2 d-flex flex-column justify-content-center align-items-center">
                <h2 class="text-center txt-app d-inline"> تسجيل الدخول </h2>

                <img src="images/profile.png" class="profile">
             
            </div>
        
            <div class="col-12 rounded-2 p-3 border-black p-2">

            <form method="POST" action="login.php">
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
                    <button type="submit" class="btn btn-md bg-primary my-3 text-white fw-bolder skip" > تسجيل الدخول </button>
                    <a href="register.php" class="fw-bolder text-primary mt-2 text-decoration-none">  ليس لديك حساب  ؟ </a>
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

