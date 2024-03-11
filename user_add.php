<?php
// Establish connection to MySQL database
$servername = "localhost"; // Change this to your database host
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "gndec_society_management"; // Change this to your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve form data
$userName = $_POST['userName'];
$session = $_POST['session'];
$society = $_POST['society'];
$subSociety = isset($_POST['sub-society']) ? $_POST['sub-society'] : null;

// Insert data into the database
$sql = "INSERT INTO `DSW_login`(`teacher_username`, `DSW_options`, `session`, `sub_society`) VALUES ('$userName','$society','$session','$subSociety')";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
$sql_update="update Username_detail SET session='$session',`society_id`='$society',`usernametype`='teacher_co' WHERE user_id='$userName'";
if (mysqli_query($conn, $sql_update)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>