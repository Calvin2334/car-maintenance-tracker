<head>
	<title>Admin Login</title>
</head>
<body>

<h2>Admin Login</h2>

<form action="admin_auth.php" method="POST">
	Username: <input type="text" name="username" required><br><br>
	Password: <input type="password" name="password" required><br><br>
	<button type="submit">Login</button>
</form>

<?php
if (isset($_GET['error'])){
	echo "<p style='color:red;'>Invalid username or password.</p>";
}
?>

</body>
</html>