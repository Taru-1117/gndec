<?php
include 'connection.php';

session_start();
$username = $_SESSION["username"];

// Fetch coordinator's society from user information
$sql_society = "SELECT society_name FROM Username_detail WHERE username = '$username'";
$result_society = $con->query($sql_society);

if ($result_society->num_rows > 0) {
    $row_society = $result_society->fetch_assoc();
    $society_name = $row_society["society_name"];

    // Form for granting permission with confirmation alert
    echo '<form id="grantPermissionForm" action="grant_permission.php" method="post" class="border p-4 rounded">';
    
    // Hidden field for selected society
    echo '<input type="hidden" name="society" value="' . $society_name . '">';

    // Display the society name
    echo '<div class="mb-3">';
    echo '<label for="society_name" class="form-label">Society Name:</label>';
    echo '<input type="text" name="society_name" id="society_name" class="form-control" value="' . $society_name . '" readonly>';
    echo '</div>';
    
    // Register button for granting permission with confirmation alert
    echo '<button type="button" id="grantPermissionBtn" class="btn btn-primary">Generate Registrations</button>';
    
    echo '</form>';

    // JavaScript for confirmation alert
    echo '<script>
            document.getElementById("grantPermissionBtn").addEventListener("click", function() {
                if (confirm("Are you sure you want to grant permission to register for this society?")) {
                    document.getElementById("grantPermissionForm").submit();
                }
            });
          </script>';
} else {
    // Assuming every coordinator has an associated society in Username_detail
    // You may consider handling this case differently based on your application's requirements
    echo "Coordinator information not found or society information not found for the coordinator.";
}
?>
