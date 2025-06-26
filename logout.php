<?php
session_start();
session_destroy();
session_start();
$_SESSION['logout_success'] = "Logout sukses!";
header('Location: login.php');
exit();
