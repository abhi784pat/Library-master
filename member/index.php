<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "../verify_logged_out.php";
	require "../header.php";
?>

<html>
	<head>
		<title>Member Login</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/form_styles.css">
		<link rel="stylesheet" type="text/css" href="css/index_style.css">
	</head>
	<body>
		<form class="cd-form" method="POST" action="#">
		
			<legend>Member Login</legend>
			
			<div class="error-message" id="error-message">
				<p id="error"></p>
			</div>
			
			<div class="icon">
				<input class="m-user" type="text" name="m_user" placeholder="Username" required />
			</div>
			
			<div class="icon">
				<input class="m-pass" type="password" name="m_pass" placeholder="Password" required />
			</div>
			
			<input type="submit" value="Login" name="m_login" />
			
			<br /><br /><br /><br />

			
			<p align="center">Don't have an account?&nbsp;<a href="register.php">Sign up</a>
		</form>
	</body>
	
	<?php
		$conn=Connect();

		if(isset($_POST['m_login']))
		{
			$username = $conn->real_escape_string($_POST['m_user']);
            $password = $conn->real_escape_string($_POST['m_pass']);
			// $query = $conn->prepare("SELECT id, balance FROM member WHERE username = ? AND password = ?;");
			$query="SELECT id, balance FROM member WHERE username='$username' and password='$password'";
			// $query->bind_param("ss", $_POST['m_user'], sha1($_POST['m_pass']));
			$result = $conn->query($query);
			// $query->execute();
			// $result = $query->get_result();
			
			if($result->num_rows != 1)
				echo error_without_field("Invalid username/password combination");
			else 
			{
				$resultRow = mysqli_fetch_array($result);
				$balance = $resultRow[1];
				if($balance < 0)
					echo error_without_field("Your account has been suspended. Please contact a librarian for further information");
				else
				{
					$_SESSION['type'] = "member";
					$_SESSION['id'] = $resultRow[0];
					$_SESSION['username'] = $_POST['m_user'];
					header('Location: home.php');
				}
			}
		}
	?>
	
</html>