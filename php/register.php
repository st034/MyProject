<?php
require_once('connectorDatabase.php');
require_once('validate.php');
session_start();


if (isset($_POST['register'])) {
    $username = $_POST['username'] ?? '';    //?? is egual to: $foo = $bar ?? 'something'; $foo = isset($bar) ? $bar : 'something'
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ??'';
    $surname = $_POST['surname'] ??'';
    $email = $_POST['email'] ??'';
    $birthday =$_POST['birthday'] ??'';
    $pwdLenght = mb_strlen($password); //conta caratteri password

    $username=Ceckusernamevalidate($username);
    $email=Ceckmailvalidate($email);
    $name=Ceckstringvalidate($name);
    $surname=Ceckstringvalidate($surname);
}    
    if (empty($username) || empty($password) || empty($name) || empty($surname) || empty($email) || empty($birthday)) {
        $msg = 'Compila tutti i campi %s';
    } elseif ($username=='') {
        $msg = 'Lo username non è valido. Sono ammessi solamente caratteri 
                alfanumerici e l\'underscore. Lunghezza minima 3 caratteri.
                Lunghezza massima 20 caratteri';
    } elseif ($pwdLenght < 8 || $pwdLenght > 20) {
        $msg = 'Lunghezza minima password 8 caratteri.
                Lunghezza massima 20 caratteri';
    } else {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $pdo=preparedbuser();

        $query = "
            SELECT id
            FROM users
            WHERE username = :username
        ";
        
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();
        
        $user = $check->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($user) > 0) {
            $msg = 'Username già in uso %s';
        } else {
            $query = "
                INSERT INTO users
                VALUES (0, :username, :email, :password, :name, :surname, :birthday)
            ";
        
            $check = $pdo->prepare($query);
            $check->bindParam(':username', $username, PDO::PARAM_STR);
            $check->bindParam(':email', $email, PDO::PARAM_STR);
            $check->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $check->bindParam(':name', $name, PDO::PARAM_STR);
            $check->bindParam(':surname', $surname, PDO::PARAM_STR);
            $check->bindParam(':birthday', $birthday, PDO::PARAM_STR);
            $check->execute();
            
            if ($check->rowCount() > 0) {
                session_regenerate_id();
                $_SESSION['session_id'] = session_id();
                $_SESSION['session_user'] = $username;
                $msg = 'Registrazione eseguita con successo';
            } else {
                $msg = 'Problemi con l\'inserimento dei dati %s';
            }
        }
    }
    
    printf($msg, '<a href="../register.html">torna indietro</a>');

?>