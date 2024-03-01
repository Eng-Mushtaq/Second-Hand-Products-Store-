<?php
session_start();
if(empty($_SESSION['username'])){
header('location:login.php');
}
?>
<div class="navigation">
    <ul class="nav">
        <li><a href="#home">الرئيسية</a></li>
    
        <li><a href="#contact">تواصل معنا</a></li>
        <li>
            <button type="button" class="btn  text-white" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                إضافة منتج جديد
            </button>
        </li>
        <li>
            <a href="cart.php" class="btn ">
                <i class="fas fa-shopping-cart"></i>  سلة التسوق
            </a>
        </li>
        <li>
            <a href="logout.php" class="btn ">
                <i class="fas fa-sign-out-alt"></i> خروج
            </a>
         
        </li>
    </ul>
</div>