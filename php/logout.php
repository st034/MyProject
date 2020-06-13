/<?php
session_start();

if (isset($_SESSION['session_user'])) {
    unset($_SESSION['session_user']);
    unset($_SESSION['session_id']);
}
header('Location: ../home.php');
exit;
?>