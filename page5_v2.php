<?php
//start the session so we can check who is logged in
session_start();
//if nobody is logged in, send them to the login page
if(!isset($_SESSION['login_user'])) {
	header("location:index_v2.php");
	exit();
}
//if the logged in user is not Graeme, send them to the normal user home page
if(strtolower($_SESSION['login_user']) !== "graeme") {
	header("location:page2_v2.php");
	exit();
}
//user is confirmed as the admin
$User = $_SESSION['login_user'];
//connect to php
require "91902DatabaseAssesment_mysqli.php";
//holds the result message for each form, shown next to its own card further down
$addMessage = NULL;
$updateMessage = NULL;
$deleteMessage = NULL;
//--- ADD USER ---
if(isset($_POST['add_username']))
{
	$UserID = mysqli_real_escape_string($conn, $_POST['add_username']);
	$PW = mysqli_real_escape_string($conn, $_POST['add_password']);
	//create a variable to store sql code for the 'Add Users' query
	$insertquery = "INSERT INTO users_id
		(User_ID, Password)
		VALUES
		('$UserID', '$PW')";
	if(mysqli_query($conn,$insertquery))
	{
		$addMessage = "User added successfully.";
	}
	else
	{
		$addMessage = "Error adding that user.";
	}
}
//--- UPDATE USER ---
if(isset($_POST['ExistingUserName']))
{
	$ExistingUserID = mysqli_real_escape_string($conn, $_POST['ExistingUserName']);
	$NewPassword = mysqli_real_escape_string($conn, $_POST['NewPassword']);
	//create a variable to store sql code for the update query
	$updatequery = "UPDATE users_id
		SET Password = '$NewPassword'
		WHERE User_ID = '$ExistingUserID'";
	if(mysqli_query($conn,$updatequery))
	{
		$updateMessage = "Password updated successfully.";
	}
	else
	{
		$updateMessage = "Error updating that password.";
	}
}
//--- DELETE USER ---
if(isset($_POST['UserName']))
{
	$UserID = mysqli_real_escape_string($conn, $_POST['UserName']);
	//create a variable to store sql code for the 'delete users' query
	$deletequery = "DELETE FROM users_id
		WHERE User_ID = '$UserID'";
	if(mysqli_query($conn,$deletequery))
	{
		$deleteMessage = "User deleted successfully.";
	}
	else
	{
		$deleteMessage = "Error deleting that user.";
	}
}
//run the "display all users" query once, ready for the table further down
$query = "SELECT * FROM users_id";
$result = mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<!-- this tells the phone to size the page to its own screen width instead of shrinking a desktop layout down -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- this is the lil blurb that shows up in Google or tabs -->
<meta name="description" content="Graeme's Music Database - admin settings for managing user accounts">
<!-- these are search keywords, not shown on the page, just helps people find it -->
<meta name="keywords" content="admin settings, manage users, add user, update password, delete user, Graeme's Music">
<!-- who made this website -->
<meta name="author" content="Jabeen Jabbar">
<title>Graeme's Music - Admin Settings</title>
<!-- linking CSS -->
<link rel="stylesheet" type="text/css" href="css/style5_v2.css">
</head>
<body>
<main>
	<button class="menu_toggle" id="menu_toggle" type="button" aria-label="Open navigation" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
        </button>
        <div class="navigation_overlay" id="navigation_overlay"></div>
        <div class="nav" id="navigation_menu"><!-- Holds the page navigation -->
                <a href="index_v2.php">Login</a>
                <a href="page2_v2.php">Home</a>
                <a href="page3_v2.php">Songs by Title</a>
                <a href="page4_v2.php">Songs by Genre</a>
                <a href="page6_v2.php"class="active">Contact</a>
                <a href="page5_v2.php">Admin Settings</a>
                <a href="logout_v2.php">Logout</a>
        </div>
	<div class="content"><!-- Holds the main page content -->
		<!-- Holds the page heading and subtitle -->
		<div class="admin-header">
			<h1>Admin Settings</h1>
			<p class="admin-subtitle">Manage user accounts for Graeme's Music</p>
		</div>
		<!-- === ALL USERS SECTION === -->
		<section class="admin-section">
			<h2>All Users</h2>
			<div class="users-table">
				<!-- Holds the table header labels -->
				<div class="users-row users-header">
					<span>User ID</span>
					<span>Password</span>
				</div>
				<!-- Holds one row per user returned from the database -->
				<?php
				while($output = mysqli_fetch_array($result))
				{
					echo "<div class='users-row'>";
					echo "<span>" . htmlspecialchars($output['User_ID']) . "</span>";
					echo "<span>" . htmlspecialchars($output['Password']) . "</span>";
					echo "</div>";
				}
				?>
			</div>
		</section>
		<!-- === MANAGE ACCOUNTS SECTION === -->
		<section class="admin-section">
			<h2>Manage Accounts</h2>
			<!-- Holds the 3 account management cards side by side -->
			<div class="admin-cards">
				<!-- Holds the add user form -->
				<div class="admin-card">
					<h3>Add User</h3>
					<form method="post" id="admin_add_user">
						<label for="add_username">Username</label>
						<input type="text"
							name="add_username"
							id="add_username"
							placeholder="Enter user name"
							required/>
						<label for="add_password">Password</label>
						<input type="password"
							name="add_password"
							id="add_password"
							placeholder="Enter user password"
							required/>
						<input type="submit" value="Add User"/>
					</form>
					<?php if($addMessage != NULL): ?>
					<p class="form-message"><?php echo $addMessage; ?></p>
					<?php endif; ?>
				</div>
				<!-- Holds the update user form -->
				<div class="admin-card">
					<h3>Update Password</h3>
					<form method="post" id="admin_update_user">
						<label for="ExistingUserName">Username</label>
						<input type="text"
							name="ExistingUserName"
							id="ExistingUserName"
							placeholder="Enter user name"
							required/>
						<label for="NewPassword">New Password</label>
						<input type="password"
							name="NewPassword"
							id="NewPassword"
							placeholder="Enter new password"
							required/>
						<input type="submit" value="Update Password"/>
					</form>
					<?php if($updateMessage != NULL): ?>
					<p class="form-message"><?php echo $updateMessage; ?></p>
					<?php endif; ?>
				</div>
				<!-- Holds the delete user form -->
				<div class="admin-card">
					<h3>Delete User</h3>
					<form method="post" id="admin_delete_user">
						<label for="UserName">Username</label>
						<input type="text"
							name="UserName"
							id="UserName"
							placeholder="Enter user name"
							required/>
						<input type="submit" value="Delete User"/>
					</form>
					<?php if($deleteMessage != NULL): ?>
					<p class="form-message"><?php echo $deleteMessage; ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<!-- === COPYRIGHT SECTION === -->
		<!-- update wording once the schedule is checked -->
		<footer class="copyright">
			<p>&copy; 2026 Graeme's Music. All rights reserved.</p>
		</footer>
	</div>
</main>
<!-- My javascript links -->
<script src="js/navigation.js"></script>
</body>
</html>
