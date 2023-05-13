<?php
session_start();
// console_log($_SESSION);
session_destroy();
header("Location: ./login.php");
?>