<?php
session_start();
require '../includes/settings.php';
$client_id = $row['github_client_id'];
    $client_secret = $row['github_secret_key'];
$redirect_uri = 'http://devbio.preciousadedokun.com.ng/dashboard/github-auth.php';
if (isset($_GET['code'])) {
    try {
        $code = $_GET['code'];

        // 1. Exchange code for access token
        $token_url = 'https://github.com/login/oauth/access_token';
        $post_data = [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $code,
            'redirect_uri' => $redirect_uri
        ];

        $ch = curl_init($token_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($post_data),
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded'
            ],
            CURLOPT_SSL_VERIFYPEER => false, 
            CURLOPT_FAILONERROR => true
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('Token request failed: ' . curl_error($ch));
        }
        curl_close($ch);

        $token_data = json_decode($response, true);
        if (!$token_data || isset($token_data['error'])) {
            throw new Exception('GitHub error: ' . ($token_data['error_description'] ?? 'Invalid token response'));
        }

        $access_token = $token_data['access_token'] ?? null;
        if (!$access_token) {
            throw new Exception('No access token received from GitHub');
        }

        // 2. Get user profile data
        $user_url = 'https://api.github.com/user';
        $ch = curl_init($user_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $access_token",
                "User-Agent: APCodeSphere-App",
                "Accept: application/json"
            ],
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $user_response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('User data request failed: ' . curl_error($ch));
        }
        curl_close($ch);

        $user_data = json_decode($user_response, true);
        if (!$user_data || isset($user_data['message'])) {
            throw new Exception('GitHub error: ' . ($user_data['message'] ?? 'Invalid user data'));
        }

        // 3. Get user emails 
        $emails_url = 'https://api.github.com/user/emails';
        $ch = curl_init($emails_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $access_token",
                "User-Agent: APCodeSphere-App",
                "Accept: application/json"
            ],
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $emails_response = curl_exec($ch);
        curl_close($ch);

        $emails = json_decode($emails_response, true) ?: [];
        $email = '';
        $backup_email = '';
        
        foreach ($emails as $e) {
            // Priority 1: Primary verified email
            if (($e['primary'] ?? false) && ($e['verified'] ?? false)) {
                $email = $e['email'];
                break;
            }
            // Priority 2: Any verified email
            if (($e['verified'] ?? false) && empty($backup_email)) {
                $backup_email = $e['email'];
            }
        }

        // Final fallback strategies
        if (empty($email)) {
            $email = $backup_email ?: // To Use any verified email
                    ($user_data['email'] ?? // To Check if email in profile
                    ($user_data['login'] . '@users.noreply.github.com'));
        }
        $github_id = $user_data['id'] ?? null;
        $name = $user_data['name'] ?? $user_data['login'] ?? 'GitHub User';
        $avatar = $user_data['avatar_url'] ?? '';

        if (!$github_id) {
            throw new Exception('Missing GitHub user ID');
        }

        // 4. Database operations
        include '../includes/conn.php';
        if (!isset($conn)) {
            throw new Exception('Database connection failed');
        }

        // Check if user exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE github_id = ? OR email = ?");
        if (!$stmt) {
            throw new Exception('Database prepare failed: ' . $conn->error);
        }

        $stmt->bind_param("is", $github_id, $email);
        if (!$stmt->execute()) {
            throw new Exception('Database execute failed: ' . $stmt->error);
        }

        $stmt->store_result();
        $user_id = null;

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
        } else {
            $stmt = $conn->prepare("INSERT INTO users (github_id, name, email, avatar) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception('Database prepare failed: ' . $conn->error);
            }

            $stmt->bind_param("isss", $github_id, $name, $email, $avatar);
            if (!$stmt->execute()) {
                throw new Exception('Database insert failed: ' . $stmt->error);
            }

            $user_id = $stmt->insert_id;
        }

        // 5. Create user session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_avatar'] = $avatar;
        
        setcookie('user_id', $user_id, time() + (86400 * 30), "/", "", false, true);

        if (!empty($_SESSION['redirect_url'])) {
    $url = $_SESSION['redirect_url'];
    unset($_SESSION['redirect_url']);
    header("Location: $url");
} else {
    header("Location: /dashboard.php");
}
        exit;

    } catch (Exception $e) {
        echo "<h2>Authentication Error</h2>";
        echo "<p>{$e->getMessage()}</p>";
        echo "<h3>Debug Info:</h3>";
        echo "<pre>Token Data: " . print_r($token_data ?? [], true) . "</pre>";
        echo "<pre>User Data: " . print_r($user_data ?? [], true) . "</pre>";
        echo "<pre>Emails: " . print_r($emails ?? [], true) . "</pre>";
        echo '<p><a href="?retry=1">Try again</a></p>';
    }
} 
// Handle OAuth errors from GitHub
elseif (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
    $error_desc = isset($_GET['error_description']) ? 
                 htmlspecialchars($_GET['error_description']) : 
                 'No description provided';
    
    echo "<h2>GitHub Authentication Error</h2>";
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
        'scope' => 'user:email read:user', // Request both email and profile access
        'state' => $_SESSION['oauth_state'],
        'allow_signup' => 'true'
    ];
    
    header("Location: https://github.com/login/oauth/authorize?" . http_build_query($params));
    exit;
}