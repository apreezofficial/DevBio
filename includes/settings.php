<?php
error_reporting(0);
include 'conn.php';

$sql = "SELECT * FROM app_settings WHERE id = 1 LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    $appName = $row['name'];
    $github_client_id = $row['github_client_id'];
    $github_secret_key = $row['github_secret_key'];
    $appLongName = $row['long_name'];
    $ai_api = $row['ai_endpoint'];
    $settings = json_decode($row['settings'], true);
} else {
    echo "No settings found.";
}
date_default_timezone_set('Africa/Lagos'); 
?>
