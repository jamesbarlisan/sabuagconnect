<?php
session_start();
include 'db_conn.php';

class LoginSystem
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function authenticate($username, $password)
    {
        $user = $this->getUserByUsername($username);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->startSession($user);
                $this->redirectToDashboard();
            } else {
                $this->showError("Invalid Password");
            }
        } else {
            $this->showError("User not found");
        }
    }

    private function getUserByUsername($username)
    {
        $sql = "SELECT * FROM admin WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    private function startSession($user)
    {
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
    }

    private function redirectToDashboard()
    {
        header("Location: dashboard.php");
        exit;
    } 
    private function showError($message)
    {
        echo "<p style='color:red;'>$message</p>";
    }
}
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $loginSystem = new LoginSystem($pdo);
        $loginSystem->authenticate($username, $password);
    }
?>