<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'my_database';

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "Utilisateur supprimé avec succès!";
        header("Location: list_users.php");
    } else {
        echo "Erreur: " . $conn->error;
    }
}
?>
