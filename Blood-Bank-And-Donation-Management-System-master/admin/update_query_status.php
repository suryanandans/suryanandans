<?php
include 'conn.php'; // Include database connection

// Check if query_id is set and not empty
if (isset($_GET['query_id']) && !empty($_GET['query_id'])) {
    $query_id = $_GET['query_id'];

    // Update query_status to 1 (Read) for the given query_id
    $sql = "UPDATE contact_query SET query_status = 1 WHERE query_id = $query_id";
    if (mysqli_query($conn, $sql)) {
        echo "Query status updated successfully";
    } else {
        echo "Error updating query status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid query ID";
}

mysqli_close($conn);
?>
