<?php
session_start();

$HOST = 'containers-us-west-30.railway.app';
$USERNAME = 'root';
$PASSWORD = 'OZhRX1y7jFk2m5OxBDIg'
$DATABASE = 'railway';
$method = filter_input(INPUT_SERVER,'REQUEST_METHOD');
$dsn = "mysql://root:OZhRX1y7jFk2m5OxBDIg@containers-us-west-30.railway.app:6523/railway";
try {
    $pdo = new PDO($dsn, $USERNAME, $PASSWORD);
    // Configurez les options PDO si nécessaire
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Utilisez la connexion PDO pour exécuter des requêtes SQL
    // ...
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

if($method == 'POST'){
    $username = trim(filter_input(INPUT_POST, 'username'));
    $password = trim(filter_input(INPUT_POST, 'password'));
    $requete = $pdo->prepare("
            INSERT INTO users (login, password) VALUES (:login, :password)
            ");
            $requete->execute([
                ":login" => $username,
                ":password" => password_hash($password, PASSWORD_DEFAULT),
            ]);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Administrateur - Inscription</title>
</head>
<body>
    <form method='POST'>
        <h1>Espace Administrateur - Inscription</h1>
       
        <input type='text' id='username' placeholder="username" name='username'>

        <input type='password' id='passsword' placeholder="mots de passe" name='password'>
        <input class="submit" type="submit" value="S'inscrire">
    </form>
    
</body>
</html>
