<?php
session_start();
$_SESSION = array();
session_destroy();
$error = "خطأ في  تسجيل الخروج";
$_SESSION['error']=$error;
header("Location: login.php");
exit();
?>
