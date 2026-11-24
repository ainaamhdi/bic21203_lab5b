
<?php
session_start();
include 'db.php';

$error = "";

if (isset($_POST['login'])) {

    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $matric);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {

        if (password_verify($password, $row['password'])) {

            $_SESSION['matric'] = $row['matric'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            header("Location: display.php");
            exit();

        } else {
            $error = "Invalid username or password, try login again.";
        }

    } else {
        $error = "Invalid username or password, try login again.";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Login</h2>

    <form method="POST" action="">

        Matric:
        <input type="text" name="matric" required>
        <br><br>

        Password:
        <input type="password" name="password" required>
        <br><br>

        <input type="submit" name="login" value="Login">

    </form>

    <p style="color:red;">
        <?php echo $error; ?>
    </p>

    <br>

    <a href="register.php">Register</a> here if you have not.

</body>
</html>
