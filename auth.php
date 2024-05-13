<?php
function register_user(string $email, string $username, string $password, bool $is_admin = false): bool
{
    $sql = 'INSERT INTO users(username, email, password, is_admin)
            VALUES(:username, :email, :password, :is_admin)';

    $pdo = db();
    if (!$pdo) {
        die('Could not connect to database');
    }

    $statement = $pdo->prepare($sql);
    if (!$statement) {
        die('Could not prepare statement: ' . print_r($pdo->errorInfo(), true));
    }

    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
    $statement->bindValue(':is_admin', (int)$is_admin, PDO::PARAM_INT);

    $result = $statement->execute();
    if (!$result) {
        die('Could not execute statement: ' . print_r($statement->errorInfo(), true));
    }

    return $result;
}
?>
