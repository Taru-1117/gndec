<?php
session_start();
include('connection.php');

$UserName = $_POST['user'];  
$Password = $_POST['pass'];  

// Prevent SQL injection
$UserName = mysqli_real_escape_string($con, $UserName);
$Password = mysqli_real_escape_string($con, $Password);  

// Perform a JOIN operation to retrieve user details
$sql = "SELECT ud.*, up.password
        FROM Username_detail AS ud
        INNER JOIN user_password AS up ON ud.user_id = up.username
        WHERE up.username = '$UserName' AND up.password = '$Password'";
$result = mysqli_query($con, $sql);  
if ($result) {
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["username"] = $UserName;
        
        // Retrieve user type
        $user_type = $row['usernametype']; // Adjust column name here
        echo "User Type: " . $user_type . "<br>";
        
        // Redirect based on user type
        if ($user_type == 'teacher') {
            header("Location: teacher_dashboard.php");
            exit();
        } elseif ($user_type == 'student_a') {
            header("Location: studentco_dashboard.php");
            exit();
        }
        elseif($user_type=='teacher_a'){
            header("Location: admin.php");
        exit();
        }
        elseif($user_type=='student')
        {
            header("Location:student_dashboard.php");
            exit();
        }
        elseif($user_type=='student_co'){
            header("Location:studentco_dashboard.php");
            exit();  
        }
        elseif($user_type=='teacher_co'){
            header("Location:teacherco_dashboard.php");
            exit();  
        }
        else {
            echo "Unknown user type!";
            exit();
        }
    } else {
        // Incorrect username or password
        echo "<script>alert('Login failed. Invalid username or password.');</script>";
        echo '<meta http-equiv="refresh" content="2;url=index.html">';
        exit();
    }
} else {
    // SQL query execution failed
    echo "Error: " . mysqli_error($con);
    exit();
}
?>