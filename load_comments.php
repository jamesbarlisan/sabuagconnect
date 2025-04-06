<?php
$dsn = 'mysql:host=localhost;dbname=members';
$username = 'root';
$password = '1234';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['article_id'])) {
        $article_id = $_GET['article_id'];

        $sql = "SELECT user_name, comment, created_at FROM comments WHERE article_id = :article_id ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':article_id' => $article_id]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='comment'><strong>" . htmlspecialchars($row['user_name']) . "</strong><p>" . htmlspecialchars($row['comment']) . "</p></div>";
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
