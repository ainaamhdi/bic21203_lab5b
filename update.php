<?php
session_start();

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (!isset($_GET['matric'])) {
    header("Location: display.php");
    exit();
}

$matric = $_GET['matric'];

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "sss", $name, $role, $matric);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: display.php");
        exit();
    } else {
        echo "Update failed!";
    }
}

$sql = "SELECT * FROM users WHERE matric = ?";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $matric);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found!");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Update User</h2>

    <form method="POST">

        Matric:
        <input type="text"
               value="<?php echo htmlspecialchars($user['matric']); ?>"
               disabled>
        <br><br>

        Name:
        <input type="text" name="name"
               value="<?php echo htmlspecialchars($user['name']); ?>"
               required>
        <br><br>

        Access Level:
        <select name="role" required>
            <option value="student"
                <?php if ($user['role'] == 'student') echo 'selected'; ?>>
                student
            </option>

            <option value="lecturer"
                <?php if ($user['role'] == 'lecturer') echo 'selected'; ?>>
                lecturer
            </option>
        </select>
        <br><br>

        <input type="submit" name="update" value="Update">

        <a href="display.php">Cancel</a>

    </form>

</body>
</html>
