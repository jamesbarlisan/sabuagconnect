<?php
class PasswordReset
{
    private $connection;
    private $message = "";

    public function __construct()
    {
        $this->connectDatabase();
    }

    private function connectDatabase()
    {
        $this->connection = new mysqli('localhost', 'root', '1234', 'members');
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function handlePostRequest()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = $_POST['username'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            $this->processPasswordReset($username, $newPassword, $confirmPassword);
        }
    }

    private function processPasswordReset($username, $newPassword, $confirmPassword)
    {
        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->connection->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $hashedPassword, $username);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $this->message = "Password updated successfully.";
            } else {
                $this->message = "Username not found.";
            }
            $stmt->close();
        } else {
            $this->message = "Passwords do not match.";
        }
    }

    public function getMessage()
    {
        return htmlspecialchars($this->message);
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}

$passwordReset = new PasswordReset();
$passwordReset->handlePostRequest();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SABUAG</title>
    <link rel="icon" type="image/png" href="images/Logos.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 20px;
        }

        .content {
            display: flex;
            max-width: 1100px;
            width: 100%;
            background-color: white;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 30px;
            overflow: hidden;
        }

        .left-section {
            flex: 1;
            background-color: #1a1851;
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .left-section .title {
            font-size: 2.8rem;
            margin-bottom: 15px;
        }

        .left-section .tagline {
            font-size: 1.2rem;
            color: #d3d3d3;
            line-height: 1.6;
        }

        .facebook-icon {
            margin-top: 20px;
            text-align: center;
        }

        .facebook-icon a {
            color: #FDFEFF;
            transition: color 0.3s ease;
        }

        .facebook-icon a:hover {
            color: #fcb315;
        }

        .facebook-icon i {
            font-size: 40px;
        }

        .right-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border-radius: 20px;
            background-color: #ffffff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            max-width: 80px;
            height: auto;
            margin-bottom: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        h2 {
            font-size: 19px;
            font-style: italic;
            text-align: center;
            color: #3e5569;
        }
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-input-group {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 14px 14px 14px 40px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 12px;
            margin-top: 8px;
        }

        .form-input:focus {
            border-color: #1a1851;
            box-shadow: 0 0 4px rgba(26, 24, 81, 0.3);
            outline: none;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #888;
        }

        .toggle-visibility {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #888;
            cursor: pointer;
        }

        .reset-btn,
        .back-btn {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .reset-btn {
            background-color: #fcb315;
            color: #1a1851;
        }

        .reset-btn:hover {
            background-color: #1a1851;
            color:  #fcb315;
        }

        .back-btn {
            background-color: #1a1851;
            color: #fcb315;
        }

        .back-btn:hover {
            background-color: #fcb315;
            color: #1a1851;
        }

        .message {
            font-size: 14px;
            color: #1a1851;
            margin-top: 20px;
            font-style: italic;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="content">
        <div class="left-section">
            <div class="title"><strong>SABUAG Connect</strong></div>
            <p class="tagline">Stay updated with the latest campus news and information.</p>
            <div class="facebook-icon">
                <a href="https://web.facebook.com/profile.php?id=61552137712877" target="_blank">
                    <i class="fab fa-facebook-square"></i>
                </a>
            </div>
        </div>
        <div class="right-section">
            <div class="login-container">
                <div class="logo">
                    <a href="index.php"><img src="images/Logos.png" alt="Company Logo"></a>
                </div>
                <h2>Reset Your Password</h2>
                <form method="POST" action="">
                    <div class="form-input-group">
                        <input type="text" name="username" class="form-input" placeholder="Enter your username" required>
                    </div>
                    <div class="form-input-group">
                        <input type="password" name="new_password" class="form-input" placeholder="Enter new password" required>
                    </div>
                    <div class="form-input-group">
                        <input type="password" name="confirm_password" class="form-input" placeholder="Confirm new password" required>
                    </div>
                    <br>
                    <div class="button-container">
                        <button type="submit" class="reset-btn">Reset Password</button>
                    </div>
                </form>
                <br>
                <a href="member_login.php">
                    <button class="back-btn">Back</button>
                </a>
                <div class="message">
                    <?php echo $passwordReset->getMessage(); ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>