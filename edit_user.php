<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'my_database';

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $username, $email, $password, $id);
    } else {
        $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $username, $email, $id);
    }

    if ($stmt->execute()) {
        echo "Utilisateur modifié avec succès!";
        header("Location: list_users.php");
    } else {
        echo "Erreur: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un utilisateur</title>
</head>
<body>
    <h2>Modifier un utilisateur</h2>
    <form method="POST" action="">
        <label>Nom d'utilisateur:</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
        <label>Nouveau mot de passe (optionnel):</label>
        <input type="password" name="password"><br>
        <button type="submit">Modifier l'utilisateur</button>
    </form>
</body>
</html>
