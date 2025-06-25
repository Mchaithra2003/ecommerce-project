<?php
// Start session (optional, only if you want to use session right after)
session_start();

// Include your database connection
include '../includes/db.php'; // Make sure this file returns a working $conn (PDO instance)

try {
    // Admin details
    $email = 'admin@example.com';           // Change if needed
    $plainPassword = 'admin123';            // Change to your preferred password
    $role = 'admin';

    // Hash the password
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Check if admin already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo "<p style='color:red;'>Admin with this email already exists.</p>";
    } else {
        // Insert admin user
        $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$email, $hashedPassword, $role]);

        echo "<p style='color:green;'>Admin created successfully!</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Password:</strong> $plainPassword</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
}
?>
