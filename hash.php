<?php
$password = "reyes2024";

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "Hashed Password: " . $hashedPassword;
?>


<?php
$storedHashedPassword = '$2y$10$QX2xCvAtuv6EeT/h4rixSeOLFRaNAG22zwe.1znrU6goqXh8823Dm';

$enteredPassword = "reyes2024";

if (password_verify($enteredPassword, $storedHashedPassword)) {
    echo "Password is correct!";
} else {
    echo "Invalid password.";
}
?>
