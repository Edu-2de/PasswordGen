<?php
function generatePassword($length = 12, $useLower = true, $useUpper = true, $useNumbers = true, $useSymbols = true) {
    $lower = 'abcdefghijklmnopqrstuvwxyz';
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $symbols = '!@#$%^&*()-_=+[]{}|;:,.<>?';

    $chars = '';
    if ($useLower) $chars .= $lower;
    if ($useUpper) $chars .= $upper;
    if ($useNumbers) $chars .= $numbers;
    if ($useSymbols) $chars .= $symbols;

    if ($chars === '') return '';

    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}

$password = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $length = isset($_POST['length']) ? (int)$_POST['length'] : 12;
    $useLower = isset($_POST['lowercase']);
    $useUpper = isset($_POST['uppercase']);
    $useNumbers = isset($_POST['numbers']);
    $useSymbols = isset($_POST['symbols']);
    $password = generatePassword($length, $useLower, $useUpper, $useNumbers, $useSymbols);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            background: #fff;
            margin: 50px auto;
            padding: 2em 2.5em 2em 2.5em;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.09);
        }
        h1 {
            text-align: center;
            color: #222;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1em;
        }
        label {
            font-weight: bold;
        }
        .options {
            display: flex;
            flex-wrap: wrap;
            gap: 1em;
        }
        .options label {
            font-weight: normal;
        }
        button {
            padding: 0.7em;
            background: #2b8a3e;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1em;
            margin-top: 10px;
            transition: background 0.2s;
        }
        button:hover {
            background: #237132;
        }
        .password-result {
            background: #e9f5e1;
            color: #215027;
            padding: 1em;
            margin-top: 1em;
            text-align: center;
            border-radius: 8px;
            font-size: 1.2em;
            word-break: break-all;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Secure Password Generator</h1>
    <form method="post">
        <label for="length">Password length:</label>
        <input type="number" name="length" id="length" value="12" min="4" max="64" required>
        <div class="options">
            <label><input type="checkbox" name="lowercase" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' ? $useLower : true) echo 'checked'; ?>> Lowercase</label>
            <label><input type="checkbox" name="uppercase" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' ? $useUpper : true) echo 'checked'; ?>> Uppercase</label>
            <label><input type="checkbox" name="numbers" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' ? $useNumbers : true) echo 'checked'; ?>> Numbers</label>
            <label><input type="checkbox" name="symbols" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' ? $useSymbols : true) echo 'checked'; ?>> Symbols</label>
        </div>
        <button type="submit">Generate Password</button>
    </form>
    <?php if ($password): ?>
        <div class="password-result">
            <strong>Your generated password:</strong><br>
            <?php echo htmlspecialchars($password); ?>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="password-result" style="background: #fbe4e6; color: #a1262c;">
            <strong>Please select at least one character type.</strong>
        </div>
    <?php endif; ?>
</div>
</body>
</html>