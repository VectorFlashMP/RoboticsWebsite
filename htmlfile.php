<!DOCTYPE html>
<html>
<head>
  <title>Team Clock-In/Out</title>
  <style>
    body { font-family: Arial; text-align: center; margin-top: 50px; }
    input[type=text] { font-size: 24px; padding: 10px; width: 200px; text-align: center; }
    button { font-size: 20px; padding: 10px 20px; margin: 10px; }
  </style>
</head>
<body>
  <h2>Enter Your Code</h2>
  <form action="log.php" method="POST">
    <input type="text" name="code" required>
    <br>
    <button type="submit" name="action" value="entry">Enter</button>
    <button type="submit" name="action" value="exit">Exit</button>
  </form>
</body>
</html>
