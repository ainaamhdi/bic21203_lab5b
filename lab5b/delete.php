<?php
session_start();

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_GET['matric'])) {

    $matric = $_GET['matric'];

    $sql = "DELETE FROM users WHERE matric = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $matric);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: display.php");
        exit();
    } else {
        echo "Delete failed!";
    }

} else {
    header("Location: display.php");
    exit();
}
?>
