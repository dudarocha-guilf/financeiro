<?php
require_once 'config.php';

//fazer logout
session_unset();
session_destroy();

// redireciona para login
header('Location: login.php');
exit;
?>