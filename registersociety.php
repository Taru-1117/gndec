<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<center> <img src="images/front.jpeg"></center>
 <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand me-5" style="margin-left: 30px;" href="student_dashboard.php">HOME</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item me-5"></li>
                    <li class="nav-item me-5"></li>
                    <li class="nav-item dropdown me-4">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Control Panel
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="registersociety.php">Register Society</a></li>
                            <li><a  class="dropdown-item"href="eventsgoinon.php">Register Event</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            User
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            <li><a class="dropdown-item" href="#">Forget Password</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php
        include 'connection.php';

        session_start();
        $username = $_SESSION["username"];

        $sql = "SELECT * FROM `Username_detail`  WHERE user_id='$username'";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "Username: " . $row["username"]. " - Email: " . $row["email"]. "<br>";
            }

            // Fetch society names from database
            $sql_societies = "SELECT society_name FROM DSW_options";
            $result_societies = $con->query($sql_societies);

            if ($result_societies->num_rows > 0) {
                // Form for society registration
                echo '<form action="register.php" method="post" class="border p-4 rounded">';
                
                // Dropdown menu for selecting society
                echo '<div class="mb-3">';
                echo '<label for="society" class="form-label">Select Society:</label>';
                echo '<select name="society" id="society" class="form-select">';
                echo '<option value="">Select Society</option>';
                while($row_society = $result_societies->fetch_assoc()) {
                    echo '<option value="' . $row_society["society_name"] . '">' . $row_society["society_name"] . '</option>';
                }
                echo '</select>';
                echo '</div>';
                
                // Additional input field for manually entering society name
                echo '<div class="mb-3">';
                echo '<label for="custom_society" class="form-label">Or Enter Society Name:</label>';
                echo '<input type="text" name="custom_society" id="custom_society" class="form-control" placeholder="Enter Society Name">';
                echo '</div>';
                
                // Dropdown menu for selecting post
                echo '<div class="mb-3">';
                echo '<label for="post" class="form-label">Select Post:</label>';
                echo '<select name="post" id="post" class="form-select">';
                echo '<option value="">Select Post</option>';
                echo '<option value="President">President</option>';
                echo '<option value="Vice President">Vice President</option>';
                echo '<option value="Secretary">Secretary</option>';
                echo '<option value="Treasurer">Treasurer</option>';
                echo '</select>';
                echo '</div>';
                
                // Register button
                echo '<button type="submit" name="register" class="btn btn-primary">Register</button>';
                
                echo '</form>';
            } else {
                echo "No societies found";
            }
        } else {
            echo "User information not found";
        }
        ?>
    </div>

    <!-- Bootstrap JS Bundle (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
