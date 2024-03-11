<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: auto;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php
include 'connection.php'; // Include the database connection file

// Check if username is provided
if(isset($_GET['UserName']) && !empty($_GET['UserName'])) {
    $username = $_GET['UserName'];

    // Prepare and execute SQL query
    $sql = "SELECT ud.username, ud.email, up.Password FROM Username_details ud
            JOIN user_password up ON ud.user_id = up.UserName
            WHERE ud.user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Fetch data
            $row = mysqli_fetch_assoc($result);
            $name = $row['username'];
            $email = $row['email'];
            $password = $row['Password'];
?>
        <table>
            <tr>
                <th>Attribute</th>
                <th>Details</th>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo htmlspecialchars($name); ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo htmlspecialchars($email); ?></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><?php echo htmlspecialchars($password); ?></td>
            </tr>
        </table>
<?php
        } else {
            echo "User not found";
        }
    } else {
        echo "Error executing query: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Username not provided";
}
?>
</body>
</html>
