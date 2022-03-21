<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css.css">
<title>M300 - Registration</title>
</head>
<body>

<h3>Name</h3>
<p>This form will send the following data to the database server.</p>

<?php if(isset($_GET['success']) && $_GET['success']==false): ?>
	<p class="error">ERROR! Please try again.</p>
<?php elseif(isset($_GET['success']) && $_GET['success']==true): ?>
	<p class="success">Your data has been successfully submitted to the database server.</p>
<?php endif; ?>

<form method="POST" action="/process.php">
<label>First Name:</label>

<input type="text" name="first">
<br />
<label>Last Name:</label>
<input type="text" name="last">
<br />
<input type="submit" value="Submit">
</form>

</body>
</html>