<?php
session_start();
include("../db/db_connect.php");

if (isset($_POST['supervisorid']) && isset($_POST['sectioninchargeid'])) {
    $supervisorId = $_POST['supervisorid'];
    $sectionInChargeId = $_POST['sectioninchargeid'];
    
    $dbconnection = new DatabaseConnection;
    $dbconnection->connect();

    // Update the supervisor table
    $query = "UPDATE supervisor_tbl SET section_incharge_assign = $sectionInChargeId WHERE supervisorid = $supervisorId";
    $result = $dbconnection->firequery($query);
    
    if ($result) {
        // Fetch updated in-charge details
        $inChargeQuery = "SELECT firstname, lastname FROM sectionincharge_tbl WHERE sectioninchargeid = $sectionInChargeId";
        $inChargeResult = $dbconnection->firequery($inChargeQuery);
        $inChargeData = mysqli_fetch_assoc($inChargeResult);
        
        // Return the full name of the in-charge
        $fullName = $inChargeData['firstname'] . ' ' . $inChargeData['lastname'];
        
        echo json_encode(['status' => 'success', 'fullName' => $fullName]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed']);
    }
}
?>
