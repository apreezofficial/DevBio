<?php
header('Content-Type: application/json');

try {
    // Get and validate input
    $raw = file_get_contents("php://input");
    if ($raw === false) {
        throw new Exception('Failed to read input');
    }

    $data = json_decode($raw, true);
    if ($data === null) {
        throw new Exception('Invalid JSON input');
    }

    // Validate required fields
    if (empty($data['filename']) || empty($data['code'])) {
        throw new Exception('Filename and code are required');
    }

    // Sanitize inputs (without escaping for prepared statements)
    $filename = trim($data['filename']);
    $code = $data['code'];

    // Validate filename format
    if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $filename)) {
        throw new Exception('Invalid filename format');
    }

    // DB connection
    require_once '/includes/conn.php'; 
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception('Database connection failed: ' . $conn->connect_error);
    }

    // Prepare statement
    $stmt = $conn->prepare("INSERT INTO generated_files (filename, code, created_at) VALUES (?, ?, NOW())");
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ss", $filename, $code);

    // Execute
    if ($stmt->execute()) {
        $response = [
            'status' => 'success',
            'message' => 'Stored in DB',
            'file_id' => $conn->insert_id
        ];
    } else {
        throw new Exception('Insert failed: ' . $stmt->error);
    }

    // Close connections
    $stmt->close();
    $conn->close();

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(400); // Bad request
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
    exit;
}