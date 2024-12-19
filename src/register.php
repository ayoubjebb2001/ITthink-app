<?php

    /**
* Register a user
*
* @param string $email
* @param string $username
* @param string $password
* @param bool $is_admin
* @return bool
*/
function register_user(string $email, string $username, string $password, bool $is_admin = false): bool
{
    $sql = 'INSERT INTO utilisateurs(username, email, password, is_admin)
            VALUES(:username, :email, :password, :is_admin)';

    $statement = db()->prepare($sql);

    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
    $statement->bindValue(':is_admin', (int)$is_admin, PDO::PARAM_INT);


    return $statement->execute();
}


    if(is_post_request()){
    $fields = [
        'username' => 'string | required | between: 3, 25 | unique: utilisateurs, username',
        'email' => 'email | required | email | unique: utilisateurs, email',
        'password' => 'string | required | secure'
    ];
    
    $messages = [
        'username' => [
            'required' => 'Please enter the username again',
            'between: 3, 25' => 'username should be between 3 and 25',
            'unique: utilisateurs, username' => 'this username is already used'
        ],
        'email' => [
            'required' => 'Please enter the email again',
            'email' => 'Please Enter a valid email',
            'unique: utilisateurs, email' => 'this email is already used'
        ],
        'password' => [
            'required' => 'Please enter the email again',
        ],
    ];
    
    [$inputs, $errors] = filter($_POST, $fields, $messages);

    if ($errors) {
        redirect_with('register.php', [
            'inputs' => $inputs,
            'errors' => $errors
        ]);
    }

    if (register_user($inputs['email'], $inputs['username'], $inputs['password'])) {
        redirect_with_message(
            'login.php',
            'Your account has been created successfully. Please login here.'
        );

    }

} else if (is_get_request()) {
    [$inputs, $errors] = session_flash('inputs', 'errors');
}