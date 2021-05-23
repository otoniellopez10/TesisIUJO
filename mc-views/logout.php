<?php
session_start();
unset($_SESSION['user_name']);
unset($_SESSION['user']);
session_destroy();
header('Location: login.php');
