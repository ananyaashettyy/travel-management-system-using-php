<?php if(!isset($_SESSION)) { session_start(); } ?>
<!DOCTYPE html>
<html>
<head>
<title>Add New Admin</title>
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css'/>
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery.min.js"></script>
</head>
<body>
<!--header-->
<?php
if($_SESSION['loginstatus']=="")
{
	header("location:loginform.php");
}
?>

<?php include('function.php'); ?>

<?php
// Adding a new admin
if(isset($_POST["add_admin"]))
{
	// Validate and sanitize input data
	$username = mysqli_real_escape_string(makeconnection(), $_POST["username"]);
	$password = mysqli_real_escape_string(makeconnection(), $_POST["password"]);
	$usertype = mysqli_real_escape_string(makeconnection(), $_POST["usertype"]);

	// Check if the username already exists
	$cn = makeconnection();
	$s = "SELECT * FROM users WHERE Username='$username'";
	$result = mysqli_query($cn, $s);
	$r = mysqli_num_rows($result);

	if ($r > 0) {
		echo "<script>alert('Username already exists!');</script>";
	} else {
		// Insert new admin into the database
		$s = "INSERT INTO users (Username, pwd, Typeofuser) VALUES ('$username', '$password', '$usertype')";
		if(mysqli_query($cn, $s)) {
			echo "<script>alert('New Admin Added Successfully');</script>";
		} else {
			echo "<script>alert('Error adding new admin.');</script>";
		}
	}
	mysqli_close($cn);
}
?>

<?php include('top.php'); ?>

<div style="padding-top:100px; box-shadow:1px 1px 20px black; min-height:570px" class="container">
<div class="col-sm-3" style="border-right:1px solid #999; min-height:450px;">
<?php include('left.php'); ?>
</div>

<div class="col-sm-9">
<form method="post">
<table border="0" width="400px" height="300px" align="center" class="tableshadow">
<tr><td colspan="2" class="toptd">Add New Admin</td></tr>
<tr><td class="lefttxt">Username</td><td><input type="text" name="username" required pattern="[a-zA-Z0-9]{1,15}" title="Only letters and numbers, up to 15 characters" /></td></tr>
<tr><td class="lefttxt">Password</td><td><input type="password" name="password" required pattern="[a-zA-Z0-9]{1,15}" title="Only letters and numbers, up to 15 characters" /></td></tr>
<tr><td class="lefttxt">Confirm Password</td><td><input type="password" name="confirm_password" required pattern="[a-zA-Z0-9]{1,15}" title="Only letters and numbers, up to 15 characters" /></td></tr>
<tr><td class="lefttxt">User Type</td><td><select name="usertype" required>
    <option value="">Select</option>
    <option value="Admin">Admin</option>
    <option value="General">General</option>
</select></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" name="add_admin" value="Add Admin" /></td></tr>
</table>
</form>
</div>
</div>

<?php include('bottom.php'); ?>
</body>
</html>
