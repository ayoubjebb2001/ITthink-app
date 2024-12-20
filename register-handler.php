<?php

// Initialize variables
$errors = [];
$inputs = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get form data
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
  
    // Validate form data
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    // If no errors, process registration
    if (empty($errors)) {
        try {
            // Check if the user is the first to register 
            $role="user";
            $sql = "SELECT count(*) from utilisateurs";
            $count = $pdo->query($sql)->fetch()[0];
            $role = $count < 1? "admin":$role;
            $sql = "INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe,role) VALUES (?, ?, ?,?)";
            $stmt = $pdo->prepare($sql);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            if ($stmt->execute([$username, $email, $hashedPassword,$role])) {
                header("Location: login.php?success=1");
                exit;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            $errors['general'] = "Registration failed. Please try again.";
        }
    }

    // Store form data for redisplay
    $inputs = [
        'username' => $username,
        'email' => $email
    ];
}

// Store errors/inputs in session for redirect
$_SESSION['errors'] = $errors;
$_SESSION['inputs'] = $inputs;

// Redirect back to form if there were errors
if (!empty($errors)) {
    header("Location: register.php");
    exit;
}