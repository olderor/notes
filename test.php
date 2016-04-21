<?php
echo 'Hello, ' . $_GET['name'] . '! You are ' . $_GET['age'] . '!';
?>
<html>
<body>
<form action="start.php">
Input name:<br>
<input type=text name="name"><br>
Input age:<br>
<input type=text name="age"><br>
<input type=submit value="OK"></form>
</body>
</html>