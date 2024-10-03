<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'my_database';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
    
            echo "Utilisateur supprimé avec succès!";
            header("Location: /list_user.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
?>
