<?php
require 'connection.php';
$_SESSION = [];
session_unset();
session_destroy();
header("Location: sign-in.php");
?>