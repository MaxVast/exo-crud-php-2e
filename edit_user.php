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
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            
            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $sql = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => $password,
                    ':id' => $id
                ]);
            } else {
                $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':id' => $id
                ]);
            }
    
            echo "Utilisateur modifié avec succès!";
            header("Location: list_users.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
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
