<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SABUAG</title>
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

        .login-button,
        .create-account-button {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-button {
            background-color: #1a1851;
            color: white;
        }

        .login-button:hover {
            background-color: #fcb315;
        }

        .create-account-button {
            background-color: #fcb315;
            color: #1a1851;
        }

        .create-account-button:hover {
            background-color: #1a1851;
            color: white;
        }

        .remember-me {
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .secondary-buttons {
            text-align: center;
            margin-top: 15px;
        }

        .secondary-buttons a {
            color: #1a1851;
            font-size: 14px;
            text-decoration: none;
        }

        .secondary-buttons a:hover {
            text-decoration: underline;
        }
        h2 {
            font-size: 19px;
            font-style: italic;
            text-align: center;
            color: #3e5569;
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- Left Section -->
        <div class="left-section">
            <div class="title"><strong>SABUAG Connect</strong></div>
            <p class="tagline">Stay updated with the latest campus news and information.</p>
            <div class="facebook-icon">
                <a href="https://web.facebook.com/profile.php?id=61552137712877" target="_blank">
                    <i class="fab fa-facebook-square"></i>
                </a>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="login-container">
                <div class="logo">
                    <a href="index.php"><img src="images/Logos.png" alt="Company Logo"></a>
                </div>
                <h2>Administrative Page</h2>
                <form action="login2.php" method="POST" class="login-form">
                    <div class="form-input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" class="form-input" placeholder="Username" name="username" required>
                    </div>
                    <div class="form-input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" class="form-input" placeholder="Password" name="password" required>
                        <i class="fas fa-eye toggle-visibility" id="toggle-password"></i>
                    </div>
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <button class="login-button" type="submit">Log In</button>
                </form>
                <div class="secondary-buttons">
                    <a href="reset_password.php">Forgot password?</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle icon
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
