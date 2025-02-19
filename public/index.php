<?php
session_start();

if (isset($_SESSION["user_id"])) {
    if ($_SESSION["role"] === "admin") {
        header("Location: ../dashboard/admin.php");
    } elseif ($_SESSION["role"] === "interviewer") {
        header("Location: ../dashboard/interviewer.php");
    } elseif ($_SESSION["role"] === "hr") {
        header("Location: ../dashboard/hr.php");
    }
    exit;
} else {
    header("Location: ../auth/login.php");
    exit;
}
?>
