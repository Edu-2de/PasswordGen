<?php
function generatePassword($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+[]{}|;:,.<>?';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}

$password = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $length = isset($_POST['length']) ? (int)$_POST['length'] : 12;
    $password = generatePassword($length);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Generator</title>
</head>
<body>
    <h1>Secure Password Generator</h1>
    <form method="post">
        <label for="length">Password length:</label>
        <input type="number" name="length" id="length" value="12" min="4" max="64">
        <button type="submit">Generate Password</button>
    </form>
    <?php if ($password): ?>
        <p><strong>Your generated password:</strong> <?php echo htmlspecialchars($password); ?></p>
    <?php endif; ?>
</body>
</html>