<?php
session_start();

unset($_SESSION['userLoggedIn']);
unset($_SESSION['userData']);

header('Location: pagInicial.php');
exit;