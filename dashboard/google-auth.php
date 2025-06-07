<?php
session_start();

// Google OAuth Configuration
$client_id = $row['google_client_id'];
$client_secret = $row['google_secret_key'];
$redirect_uri = 'http://0.0.0.0:3360/dashboard/google-auth.php';
// If Google redirects back with authorization code
if (isset($_GET['code'])) {
    try {
        $code = $_GET['code'];

        // 1. Exchange authorization code for access token
        $token_url = 'https://oauth2.googleapis.com/token';
        $post_data = [
            'code' => $code,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code'
        ];

        $ch = curl_init($token_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post_data),
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
            CURLOPT_SSL_VERIFYPEER => true
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('Token request failed: ' . curl_error($ch));
        }
        curl_close($ch);

        $token_data = json_decode($response, true);
        if (!$token_data || isset($token_data['error'])) {
            throw new Exception('Google error: ' . ($token_data['error_description'] ?? 'Invalid token response'));
        }

        $access_token = $token_data['access_token'] ?? null;
        if (!$access_token) {
            throw new Exception('No access token received from Google');
        }

        // 2. Get user info from Google
        $userinfo_url = 'https://www.googleapis.com/oauth2/v2/userinfo?access_token=' . $access_token;
        $ch = curl_init($userinfo_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        $user_response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('User info request failed: ' . curl_error($ch));
        }
        curl_close($ch);
        $user_data = json_decode($user_response, true);
        if (!$user_data || isset($user_data['error'])) {
            throw new Exception('Google error: ' . ($user_data['error']['message'] ?? 'Invalid user data'));
        }

        // Extract user data
        $google_id = $user_data['id'] ?? null;
        $email = $user_data['email'] ?? '';
        $name = $user_data['name'] ?? 'Google User';
        $avatar = $user_data['picture'] ?? '';

        if (!$google_id) {
            throw new Exception('Missing Google user ID');
        }
        // 3. Database operations
        include '../includes/conn.php';
        if (!isset($conn)) {
            throw new Exception('Database connection failed');
        }
        // Check if user exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE google_id = ? OR email = ?");
        if (!$stmt) {
            throw new Exception('Database prepare failed: ' . $conn->error);
        }

        $stmt->bind_param("ss", $google_id, $email);
        if (!$stmt->execute()) {
            throw new Exception('Database execute failed: ' . $stmt->error);
        }

        $stmt->store_result();
        $user_id = null;

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
        } else {
            $stmt = $conn->prepare("INSERT INTO users (google_id, name, email, avatar) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception('Database prepare failed: ' . $conn->error);
            }

            $stmt->bind_param("ssss", $google_id, $name, $email, $avatar);
            if (!$stmt->execute()) {
                throw new Exception('Database insert failed: ' . $stmt->error);
            }

            $user_id = $stmt->insert_id;
        }

        // 4. Create user session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_avatar'] = $avatar;
        $_SESSION['auth_provider'] = 'google';
        
        setcookie('user_id', $user_id, time() + (86400 * 30), "/", "", false, true);

        header("Location: dashboard.php");
        exit;

    } catch (Exception $e) {
        // Error handling
        echo "<h2>Authentication Error</h2>";
        echo "<p>{$e->getMessage()}</p>";
        
        echo "<h3>Debug Info:</h3>";
        echo "<pre>Token Data: " . print_r($token_data ?? [], true) . "</pre>";
        echo "<pre>User Data: " . print_r($user_data ?? [], true) . "</pre>";
        
        echo '<p><a href="?retry=1">Try again</a></p>';
    }
} 
// Handle OAuth errors from Google
elseif (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
    $error_desc = isset($_GET['error_description']) ? 
                 htmlspecialchars($_GET['error_description']) : 
                 'No description provided';
    
    echo "<h2>Google Authentication Error</h2>";
    echo "<p><strong>Error:</strong> {$error}</p>";
    echo "<p><strong>Description:</strong> {$error_desc}</p>";
    echo '<p><a href="?retry=1">Try again</a></p>';
}
// Initial authorization request
else {
    // Generate CSRF protection token
    $_SESSION['oauth_state'] = bin2hex(random_bytes(16));
    
    $params = [
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'response_type' => 'code',
        'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
        'state' => $_SESSION['oauth_state'],
        'access_type' => 'online',
        'prompt' => 'consent'
    ];
    
    header("Location: https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query($params));
    exit;
}