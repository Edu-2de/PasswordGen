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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --primary: #2ecc71;
            --primary-dark: #27ae60;
            --background: #f8fafd;
            --white: #fff;
            --gray-light: #f0f0f0;
            --gray: #d7dbdf;
            --text: #222;
            --text-muted: #6c757d;
            --danger: #fbe4e6;
            --danger-text: #a1262c;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: var(--background);
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: var(--white);
            border-radius: 18px;
            box-shadow: 0 4px 32px rgba(44, 204, 113, 0.10),
                        0 1.5px 8px rgba(0,0,0,0.04);
            padding: 2.5em 2em 2em 2em;
            width: 100%;
            max-width: 390px;
            margin: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            text-align: center;
            color: var(--primary-dark);
            font-size: 2em;
            font-weight: 700;
            margin: 0 0 1.2em 0;
            letter-spacing: 1px;
        }
        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1.2em;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4em;
        }
        label {
            color: var(--text);
            font-size: 1em;
            font-weight: 600;
        }
        input[type="number"] {
            border: 1.5px solid var(--gray);
            border-radius: 8px;
            padding: 0.6em 1em;
            font-size: 1.08em;
            background: var(--gray-light);
            transition: border-color 0.2s;
        }
        input[type="number"]:focus {
            border-color: var(--primary);
            outline: none;
        }
        .options {
            display: flex;
            flex-wrap: wrap;
            gap: 1em 0.8em;
            margin-top: 0.2em;
        }
        .options label {
            font-weight: 500;
            color: var(--text-muted);
            font-size: 1em;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.45em;
        }
        .options input[type="checkbox"] {
            accent-color: var(--primary);
            width: 1.1em;
            height: 1.1em;
        }
        button {
            padding: 0.85em 0;
            background: linear-gradient(90deg, var(--primary) 65%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.09em;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(44,204,113,0.07);
            letter-spacing: 1px;
            transition: background 0.2s, box-shadow 0.2s;
        }
        button:hover {
            background: linear-gradient(90deg, var(--primary-dark) 40%, var(--primary) 100%);
            box-shadow: 0 4px 18px rgba(44,204,113,0.13);
        }
        .password-result {
            background: #e9f5e1;
            color: #215027;
            padding: 1.05em 0.7em;
            margin-top: 1.2em;
            text-align: center;
            border-radius: 10px;
            font-size: 1.22em;
            font-family: 'Fira Mono', 'Consolas', monospace;
            word-break: break-all;
            font-weight: 600;
            letter-spacing: 1.2px;
            box-shadow: 0 1px 4px rgba(44,204,113,0.07);
            user-select: all;
        }
        .danger {
            background: var(--danger);
            color: var(--danger-text);
            border-radius: 10px;
            padding: 1.05em 0.7em;
            font-weight: 600;
            margin-top: 1.2em;
            text-align: center;
        }
        @media (max-width: 450px) {
            .container {
                padding: 1.2em 0.7em;
                max-width: 98vw;
            }
            h1 {
                font-size: 1.45em;
            }
            .password-result {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Secure Password Generator</h1>
    <form method="post" autocomplete="off">
        <div class="form-group">
            <label for="length">Password length</label>
            <input type="number" name="length" id="length" value="12" min="4" max="64" required>
        </div>
        <div class="form-group">
            <span style="font-weight:600;color:var(--text);">Include:</span>
            <div class="options">
                <label><input type="checkbox" name="lowercase" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' ? $useLower : true) echo 'checked'; ?>> Lowercase</label>
                <label><input type="checkbox" name="uppercase" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' ? $useUpper : true) echo 'checked'; ?>> Uppercase</label>
                <label><input type="checkbox" name="numbers" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' ? $useNumbers : true) echo 'checked'; ?>> Numbers</label>
                <label><input type="checkbox" name="symbols" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' ? $useSymbols : true) echo 'checked'; ?>> Symbols</label>
            </div>
        </div>
        <button type="submit">Generate Password</button>
    </form>
    <?php if ($password): ?>
        <div class="password-result" title="Click to copy" onclick="navigator.clipboard.writeText('<?php echo htmlspecialchars($password); ?>');">
            <?php echo htmlspecialchars($password); ?>
        </div>
        <script>
            // Optional: copy to clipboard feedback
            document.querySelector('.password-result').addEventListener('click', function() {
                this.style.background = '#c7f9cc';
                setTimeout(() => { this.style.background = '#e9f5e1'; }, 500);
            });
        </script>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="danger">
            <strong>Please select at least one character type.</strong>
        </div>
    <?php endif; ?>
</div>
</body>
</html>