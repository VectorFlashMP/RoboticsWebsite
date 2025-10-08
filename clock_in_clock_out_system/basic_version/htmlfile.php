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
    <button type="submit" name="action" value="entry">Clock-in</button>
    <button type="submit" name="action" value="exit">Clock-out</button>
  </form>
  <h3>OR</h3>
  <br>
  <br>
<p style="color:red;">Manually enter your time in case you forgot to clock in</p>
<form action="log.php" method="POST">
  <input type="text" name="code" placeholder="Your code" required>
  <input type="datetime-local" name="entrytime">
   <br>
  <button type="submit" name="manualcin" value="1">Enter time manually</button>
</form>
</body>
</html>
