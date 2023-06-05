<?php
session_start();
include 'connection.php';

if (isset($_POST['orderid'])) {
    $orderid = $_POST['orderid'];
    echo $orderid;
    // Lanjutkan dengan logika dan operasi lain yang Anda butuhkan
    // ...
}

?>