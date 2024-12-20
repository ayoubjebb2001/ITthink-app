<?php

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $inputs = [];
    $errors = [];
    // Get form data
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

    // If no errors, process login
    if (empty($errors)) {
        try {
            $sql = "SELECT * FROM utilisateurs where email=:email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email,PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit;
            } else {
                $errors['general'] = 'Invalid email or password';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            $errors['general'] = "Login failed. Please try again.";
        }
    }

    // Store form data for redisplay
    $inputs = [
        'username' => $username,
        'email' => $email
    ];
   
    // Store errors/inputs in session for redirect
    $_SESSION['errors'] = $errors;
    $_SESSION['inputs'] = $inputs;
    
}
// Redirect back to form if there were errors
if (!empty($errors)) {
    header("Location: login.php");
    exit;
}