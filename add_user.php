<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'my_database';

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $username, $email, $password);
    
    if ($stmt->execute()) {
        echo "Utilisateur ajouté avec succès!";
    } else {
        echo "Erreur: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un utilisateur</title>
</head>
<body>
    <form method="POST" action="add_user.php">
        <label>Nom d'utilisateur:</label>
        <input type="text" name="username" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Mot de passe:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Ajouter l'utilisateur</button>
    </form>
</body>
</html>
