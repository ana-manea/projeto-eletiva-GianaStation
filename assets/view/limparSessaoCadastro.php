<?php
session_start();

// Limpar apenas dados do cadastro, manter idioma
unset($_SESSION['user_email']);
unset($_SESSION['user_password']);
unset($_SESSION['user_name']);
unset($_SESSION['user_birth_date']);
unset($_SESSION['user_gender']);
unset($_SESSION['cadastro_errors']);
unset($_SESSION['returning_from_step']);

echo json_encode(['success' => true]);
?>