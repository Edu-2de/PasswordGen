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
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<p><strong>Your password will appear here.</strong></p>";
    }
    ?>
</body>
</html>