<?php
include 'connection.php'; // Include the database connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (isset($_POST["session"]) && isset($_POST["coordinators"]) &&
        !empty($_POST["session"]) && !empty($_POST["coordinators"])) {
        
        // Retrieve form data
        $session = $_POST["session"];
        $coordinators = $_POST["coordinators"];

        // Fetch the user_id based on the logged-in username
        session_start(); // Start session to access logged-in user's data
        $logged_in_username = $_SESSION['username']; // Assuming you have stored the logged-in username in session upon login

        $fetchUserIdSql = "SELECT user_id FROM user_password WHERE UserName = ?";
        $fetchStmt = $con->prepare($fetchUserIdSql);
        $fetchStmt->bind_param("s", $logged_in_username);
        $fetchStmt->execute();
        $fetchResult = $fetchStmt->get_result();

        if ($fetchResult->num_rows == 1) {
            $row = $fetchResult->fetch_assoc();
            $user_id = $row["user_id"];

            // Now, fetch the society_id associated with the retrieved user_id
            $fetchSocietyIdSql = "SELECT society_id FROM Username_detail WHERE user_id = ?";
            $fetchSocietyStmt = $con->prepare($fetchSocietyIdSql);
            $fetchSocietyStmt->bind_param("i", $user_id);
            $fetchSocietyStmt->execute();
            $fetchSocietyResult = $fetchSocietyStmt->get_result();

            if ($fetchSocietyResult->num_rows == 1) {
                $society_row = $fetchSocietyResult->fetch_assoc();
                $society_id = $society_row["society_id"];

                // Update DSW_login table with coordinator usernames
                $updateSql = "UPDATE DSW_login SET coordinator_username = ? WHERE society_id = ?";
                $updateStmt = $con->prepare($updateSql);
                $updateStmt->bind_param("si", $coordinators, $society_id);
                
                if ($updateStmt->execute()) {
                    echo "DSW Login table updated successfully.";
                } else {
                    echo "Error updating DSW Login table: " . $con->error;
                }

                // Close update statement
                $updateStmt->close();
            } else {
                echo "Error: Society ID not found for the logged-in user.";
            }

            // Close society ID fetch statement
            $fetchSocietyStmt->close();
        } else {
            echo "Error: User ID not found for the logged-in username.";
        }

        // Close user ID fetch statement
        $fetchStmt->close();
    } else {
        echo "Please fill out all fields.";
    }
}

// Close connection (if needed)
$con->close();
?>
