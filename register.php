<?php
include 'db.php';

$message = "";

if (isset($_POST['submit'])) {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

     mysqli_stmt_bind_param(
        $stmt, "ssss",
        $matric, $name, $hashedPassword, $role
    );

    if (mysqli_stmt_execute($stmt)) {
        $message = "Registration successful!";
    } else {
        $message = "Registration failed. Matric number may already exist.";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registration Page</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h2>Registration Form</h2>

        <form method="POST" action="">
            Matric:
            <input type="text" name="matric" maxlength="10" required>
            <br>

            Name:
            <input type="text" name="name" maxlength="100" required>
            <br>

            Password:
            <input type="password" name="password" required>
            <br>

            Role:
            <select name="role" required>
                <option value="">Please Select</option>
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
            </select>
            <br>

            <input type="submit" name="submit" value="Submit">
        </form>

        <p><?php echo $message; ?></p>

    </body>
</html>