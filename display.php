<?php
session_start();

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$sql = "SELECT matric, name, role FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>User List</h2>

    <p>
        Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!
    </p>

    <table border="1">
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
            <th>Action</th>
        </tr>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <tr>
            <td><?php echo htmlspecialchars($row['matric']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['role']); ?></td>

            <td>
                <a href="update.php?matric=<?php echo urlencode($row['matric']); ?>">
                    Update
                </a>

                |

                <a href="delete.php?matric=<?php echo urlencode($row['matric']); ?>"
                   onclick="return confirm('Are you sure you want to delete this user?');">
                    Delete
                </a>
            </td>
        </tr>

        <?php
        }
        ?>

    </table>

    <br>
    <a href="logout.php">Logout</a>

</body>
</html>
